@include('tools.partials.calculator-shared-styles')

<div class="emi-calc-wrap">
    <div class="row g-4">
        {{-- Left: Inputs --}}
        <div class="col-lg-6">
            <h5 class="fw-bold mb-3">GST Details</h5>

            <div class="emi-slider-group">
                <label for="gst_amount">Base amount (₹)</label>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="flex-grow-1 position-relative">
                        <input type="range" class="emi-slider w-100" id="gst_amount_range" min="100" max="1000000" step="100" value="10000">
                        <div class="d-flex justify-content-between emi-slider-labels">
                            <span class="emi-min-label">₹100</span>
                            <span class="emi-max-label">₹10,00,000</span>
                        </div>
                    </div>
                    <span class="emi-value-box" id="gst_amount_display">₹10,000</span>
                </div>
            </div>

            <div class="emi-slider-group mt-4">
                <label>GST Rate</label>
                <div class="d-flex flex-wrap gap-2 mt-2">
                    @foreach([5, 12, 18, 28] as $rate)
                    <button type="button" class="btn gst-rate-btn {{ $rate == 18 ? 'active' : '' }}" data-rate="{{ $rate }}">{{ $rate }}%</button>
                    @endforeach
                </div>
            </div>

            <div class="emi-slider-group mt-4">
                <label>Calculation Type</label>
                <div class="d-flex gap-3 mt-2">
                    <label class="gst-type-label">
                        <input type="radio" name="gst_type" value="exclusive" checked> Add GST (Exclusive)
                    </label>
                    <label class="gst-type-label">
                        <input type="radio" name="gst_type" value="inclusive"> Remove GST (Inclusive)
                    </label>
                </div>
            </div>
        </div>

        {{-- Right: Doughnut + bar chart + summary --}}
        <div class="col-lg-6">
            <div class="d-flex flex-wrap gap-3 align-items-center mb-2">
                <span class="emi-legend-item"><span class="emi-legend-dot bg-secondary"></span> Net amount</span>
                <span class="emi-legend-item"><span class="emi-legend-dot" style="background:#2563eb"></span> GST amount</span>
            </div>
            <div class="emi-charts-row">
                <div class="emi-doughnut-wrap">
                    <canvas id="gstDonutChart" width="160" height="160"></canvas>
                </div>
                <div class="emi-bar-wrap">
                    <canvas id="gstBarChart" height="120"></canvas>
                </div>
            </div>
            <div id="gstSummary" class="mt-4">
                <div class="emi-summary-card">
                    <div class="label">Net amount (excl. GST)</div>
                    <div class="value" id="gst_net_display">₹10,000</div>
                </div>
                <div class="emi-summary-card">
                    <div class="label">GST amount</div>
                    <div class="value" id="gst_tax_display">₹1,800</div>
                </div>
                <div class="emi-summary-card">
                    <div class="label">Total amount</div>
                    <div class="value" id="gst_total_display">₹11,800</div>
                </div>
                <div class="emi-summary-card">
                    <div class="label">CGST (50%)</div>
                    <div class="value" id="gst_cgst_display">₹900</div>
                </div>
                <div class="emi-summary-card">
                    <div class="label">SGST (50%)</div>
                    <div class="value" id="gst_sgst_display">₹900</div>
                </div>
                <div class="emi-summary-card">
                    <div class="label">Effective rate</div>
                    <div class="value" id="gst_effective_display">18.0%</div>
                </div>
            </div>
        </div>
    </div>

    {{-- GST Rate Info Table --}}
    <hr class="my-4">
    <h5 class="fw-bold mb-3">GST Slab Reference</h5>
    <div class="row g-3">
        @foreach([['5%','Essential goods — food grains, medicines, low-cost restaurants','#22c55e'],['12%','Processed foods, business class hotels, electronics accessories','#3b82f6'],['18%','Standard services, most manufactured goods, telecom','#f59e0b'],['28%','Luxury goods, automobiles, tobacco, high-end hotels','#ef4444']] as $slab)
        <div class="col-sm-6 col-xl-3">
            <div class="gst-slab-card" style="border-top: 4px solid {{ $slab[2] }}">
                <div class="gst-slab-rate" style="color:{{ $slab[2] }}">{{ $slab[0] }}</div>
                <div class="gst-slab-desc">{{ $slab[1] }}</div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@push('styles')
<style>
.gst-rate-btn {
    background: #f1f5f9; border: 2px solid #e2e8f0;
    color: #374151; font-weight: 600; padding: 0.45rem 1.1rem;
    border-radius: 8px; transition: all 0.2s;
}
.gst-rate-btn.active {
    background: #2563eb; border-color: #2563eb; color: #fff;
}
.gst-type-label {
    display: flex; align-items: center; gap: 0.5rem;
    font-weight: 500; color: #374151; cursor: pointer; font-size: 0.93rem;
}
.gst-slab-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 10px;
    padding: 1rem 1.25rem;
}
.gst-slab-rate { font-size: 1.5rem; font-weight: 800; margin-bottom: 0.3rem; }
.gst-slab-desc { font-size: 0.82rem; color: #64748b; line-height: 1.4; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function(){
    var amountRange = document.getElementById('gst_amount_range');
    var rateButtons = document.querySelectorAll('.gst-rate-btn');
    var typeInputs  = document.querySelectorAll('input[name="gst_type"]');
    var amountDisplay = document.getElementById('gst_amount_display');

    var gstDonut = null, gstBar = null;
    var currentRate = 18;

    function fmt(n){ return '₹' + Math.round(n).toLocaleString('en-IN'); }
    function fmtDec(n){ return '₹' + n.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ','); }

    function setProgress(slider){
        var min = parseFloat(slider.min), max = parseFloat(slider.max), val = parseFloat(slider.value);
        slider.style.setProperty('--progress', ((val-min)/(max-min)*100) + '%');
    }

    function calculate(){
        var amount = parseFloat(amountRange.value) || 10000;
        var rate = currentRate;
        var type = document.querySelector('input[name="gst_type"]:checked').value;
        var net, gst, total;
        if(type === 'exclusive'){
            net = amount; gst = amount * (rate/100); total = net + gst;
        } else {
            total = amount; net = amount / (1 + rate/100); gst = total - net;
        }
        amountDisplay.textContent = fmt(amount);
        document.getElementById('gst_net_display').textContent   = fmtDec(net);
        document.getElementById('gst_tax_display').textContent   = fmtDec(gst);
        document.getElementById('gst_total_display').textContent = fmtDec(total);
        document.getElementById('gst_cgst_display').textContent  = fmtDec(gst/2);
        document.getElementById('gst_sgst_display').textContent  = fmtDec(gst/2);
        document.getElementById('gst_effective_display').textContent = (gst/net*100).toFixed(1) + '%';

        if(gstDonut){ gstDonut.data.datasets[0].data = [net, gst]; gstDonut.update(); }
        if(gstBar){   gstBar.data.datasets[0].data   = [net, gst]; gstBar.update(); }
    }

    amountRange.addEventListener('input', function(){ setProgress(this); calculate(); });
    setProgress(amountRange);

    rateButtons.forEach(function(btn){
        btn.addEventListener('click', function(){
            rateButtons.forEach(function(b){ b.classList.remove('active'); });
            this.classList.add('active');
            currentRate = parseInt(this.getAttribute('data-rate'), 10);
            calculate();
        });
    });

    typeInputs.forEach(function(inp){ inp.addEventListener('change', calculate); });

    gstDonut = new Chart(document.getElementById('gstDonutChart').getContext('2d'), {
        type: 'doughnut',
        data: { labels: ['Net amount','GST amount'], datasets: [{ data: [10000,1800], backgroundColor: ['#9ca3af','#2563eb'], borderWidth: 0 }] },
        options: { responsive: true, maintainAspectRatio: true, devicePixelRatio: 2, cutout: '65%', plugins: { legend: { display: false } } }
    });

    gstBar = new Chart(document.getElementById('gstBarChart').getContext('2d'), {
        type: 'bar',
        data: { labels: ['Net amount','GST amount'], datasets: [{ data: [10000,1800], backgroundColor: ['#9ca3af','#2563eb'], borderWidth: 0, borderRadius: 6, barPercentage: 0.7 }] },
        options: {
            indexAxis: 'y', responsive: true, maintainAspectRatio: false, devicePixelRatio: 2,
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, ticks: { callback: function(v){ return '₹'+Number(v).toLocaleString('en-IN'); } } },
                y: { ticks: { color: '#475569', font: { size: 12 } } }
            }
        }
    });

    calculate();
})();
</script>
@endpush
