@include('tools.partials.calculator-shared-styles')

<div class="emi-calc-wrap">
    {{-- Tabs --}}
    <div class="sip-tabs mb-4">
        <button type="button" class="btn btn-outline-success active" data-fdrd="fd">
            <i class="fa-solid fa-piggy-bank me-1"></i> Fixed Deposit
        </button>
        <button type="button" class="btn btn-outline-success" data-fdrd="rd">
            <i class="fa-solid fa-calendar-plus me-1"></i> Recurring Deposit
        </button>
    </div>

    {{-- FD Panel --}}
    <div id="fdPanel">
        <div class="row g-4">
            <div class="col-lg-6">
                <h5 class="fw-bold mb-3">FD Details</h5>
                <div class="emi-slider-group">
                    <label>Principal amount (₹)</label>
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="flex-grow-1 position-relative">
                            <input type="range" class="emi-slider w-100" id="fd_principal_range" min="1000" max="10000000" step="1000" value="100000">
                            <div class="d-flex justify-content-between emi-slider-labels"><span>₹1,000</span><span>₹1 Cr</span></div>
                        </div>
                        <span class="emi-value-box" id="fd_principal_display">₹1,00,000</span>
                    </div>
                </div>
                <div class="emi-slider-group mt-3">
                    <label>Interest rate (% p.a.)</label>
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="flex-grow-1 position-relative">
                            <input type="range" class="emi-slider w-100" id="fd_rate_range" min="1" max="15" step="0.1" value="7">
                            <div class="d-flex justify-content-between emi-slider-labels"><span>1%</span><span>15%</span></div>
                        </div>
                        <span class="emi-value-box" id="fd_rate_display">7.0 %</span>
                    </div>
                </div>
                <div class="emi-slider-group mt-3">
                    <label>Tenure (years)</label>
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="flex-grow-1 position-relative">
                            <input type="range" class="emi-slider w-100" id="fd_tenure_range" min="1" max="30" step="1" value="5">
                            <div class="d-flex justify-content-between emi-slider-labels"><span>1 Yr</span><span>30 Yr</span></div>
                        </div>
                        <span class="emi-value-box" id="fd_tenure_display">5 Yr</span>
                    </div>
                </div>
                <div class="emi-slider-group mt-3">
                    <label>Compounding frequency</label>
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        @foreach(['1'=>'Yearly','2'=>'Half-yearly','4'=>'Quarterly','12'=>'Monthly'] as $val=>$label)
                        <button type="button" class="btn gst-rate-btn {{ $val==4?'active':'' }}" data-fd-compound="{{ $val }}">{{ $label }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="d-flex flex-wrap gap-3 align-items-center mb-2">
                    <span class="emi-legend-item"><span class="emi-legend-dot bg-secondary"></span> Principal</span>
                    <span class="emi-legend-item"><span class="emi-legend-dot" style="background:#2563eb"></span> Interest earned</span>
                </div>
                <div class="emi-charts-row">
                    <div class="emi-doughnut-wrap">
                        <canvas id="fdDonutChart" width="160" height="160"></canvas>
                    </div>
                    <div class="emi-bar-wrap">
                        <canvas id="fdBarChart" height="120"></canvas>
                    </div>
                </div>
                <div id="fdSummary" class="mt-4">
                    <div class="emi-summary-card"><div class="label">Principal</div><div class="value" id="fd_principal_out">₹1,00,000</div></div>
                    <div class="emi-summary-card"><div class="label">Interest earned</div><div class="value" id="fd_interest_out">₹0</div></div>
                    <div class="emi-summary-card"><div class="label">Maturity value</div><div class="value" id="fd_maturity_out">₹0</div></div>
                    <div class="emi-summary-card"><div class="label">Effective annual yield</div><div class="value" id="fd_yield_out">0%</div></div>
                </div>
            </div>
        </div>
    </div>

    {{-- RD Panel --}}
    <div id="rdPanel" style="display:none">
        <div class="row g-4">
            <div class="col-lg-6">
                <h5 class="fw-bold mb-3">RD Details</h5>
                <div class="emi-slider-group">
                    <label>Monthly deposit (₹)</label>
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="flex-grow-1 position-relative">
                            <input type="range" class="emi-slider w-100" id="rd_monthly_range" min="500" max="100000" step="500" value="5000">
                            <div class="d-flex justify-content-between emi-slider-labels"><span>₹500</span><span>₹1,00,000</span></div>
                        </div>
                        <span class="emi-value-box" id="rd_monthly_display">₹5,000</span>
                    </div>
                </div>
                <div class="emi-slider-group mt-3">
                    <label>Interest rate (% p.a.)</label>
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="flex-grow-1 position-relative">
                            <input type="range" class="emi-slider w-100" id="rd_rate_range" min="1" max="15" step="0.1" value="6.5">
                            <div class="d-flex justify-content-between emi-slider-labels"><span>1%</span><span>15%</span></div>
                        </div>
                        <span class="emi-value-box" id="rd_rate_display">6.5 %</span>
                    </div>
                </div>
                <div class="emi-slider-group mt-3">
                    <label>Tenure (months)</label>
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="flex-grow-1 position-relative">
                            <input type="range" class="emi-slider w-100" id="rd_months_range" min="6" max="360" step="6" value="60">
                            <div class="d-flex justify-content-between emi-slider-labels"><span>6 Mo</span><span>360 Mo</span></div>
                        </div>
                        <span class="emi-value-box" id="rd_months_display">60 Mo</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="d-flex flex-wrap gap-3 align-items-center mb-2">
                    <span class="emi-legend-item"><span class="emi-legend-dot bg-secondary"></span> Total invested</span>
                    <span class="emi-legend-item"><span class="emi-legend-dot" style="background:#2563eb"></span> Interest earned</span>
                </div>
                <div class="emi-charts-row">
                    <div class="emi-doughnut-wrap">
                        <canvas id="rdDonutChart" width="160" height="160"></canvas>
                    </div>
                    <div class="emi-bar-wrap">
                        <canvas id="rdBarChart" height="120"></canvas>
                    </div>
                </div>
                <div id="rdSummary" class="mt-4">
                    <div class="emi-summary-card"><div class="label">Total invested</div><div class="value" id="rd_invested_out">₹3,00,000</div></div>
                    <div class="emi-summary-card"><div class="label">Interest earned</div><div class="value" id="rd_interest_out">₹0</div></div>
                    <div class="emi-summary-card"><div class="label">Maturity value</div><div class="value" id="rd_maturity_out">₹0</div></div>
                    <div class="emi-summary-card"><div class="label">Effective annual yield</div><div class="value" id="rd_yield_out">0%</div></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.gst-rate-btn { background:#f1f5f9; border:2px solid #e2e8f0; color:#374151; font-weight:600; padding:0.45rem 1rem; border-radius:8px; transition:all 0.2s; }
.gst-rate-btn.active { background:#2563eb; border-color:#2563eb; color:#fff; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function(){
    function fmt(n){ return '₹' + Math.round(n).toLocaleString('en-IN'); }
    function setP(s){ var mn=parseFloat(s.min),mx=parseFloat(s.max),v=parseFloat(s.value); s.style.setProperty('--progress',((v-mn)/(mx-mn)*100)+'%'); }

    // ── FD ──────────────────────────────────────────────
    var fdPrincipalRange = document.getElementById('fd_principal_range');
    var fdRateRange      = document.getElementById('fd_rate_range');
    var fdTenureRange    = document.getElementById('fd_tenure_range');
    var fdCompound = 4;
    var fdDonut = null, fdBar = null;

    document.querySelectorAll('[data-fd-compound]').forEach(function(btn){
        btn.addEventListener('click', function(){
            document.querySelectorAll('[data-fd-compound]').forEach(function(b){ b.classList.remove('active'); });
            this.classList.add('active');
            fdCompound = parseInt(this.getAttribute('data-fd-compound'), 10);
            calcFD();
        });
    });

    [fdPrincipalRange, fdRateRange, fdTenureRange].forEach(function(s){
        s.addEventListener('input', function(){ setP(s); calcFD(); });
        setP(s);
    });

    fdDonut = new Chart(document.getElementById('fdDonutChart').getContext('2d'), {
        type:'doughnut', data:{ labels:['Principal','Interest'], datasets:[{ data:[100000,0], backgroundColor:['#9ca3af','#2563eb'], borderWidth:0 }] },
        options:{ responsive:true, maintainAspectRatio:true, devicePixelRatio:2, cutout:'65%', plugins:{ legend:{ display:false } } }
    });
    fdBar = new Chart(document.getElementById('fdBarChart').getContext('2d'), {
        type:'bar', data:{ labels:['Principal','Interest earned'], datasets:[{ data:[100000,0], backgroundColor:['#9ca3af','#2563eb'], borderWidth:0, borderRadius:6, barPercentage:0.7 }] },
        options:{ indexAxis:'y', responsive:true, maintainAspectRatio:false, devicePixelRatio:2, plugins:{ legend:{ display:false } },
            scales:{ x:{ beginAtZero:true, ticks:{ callback:function(v){ return '₹'+Number(v).toLocaleString('en-IN'); } } }, y:{ ticks:{ color:'#475569', font:{ size:12 } } } }
        }
    });

    function calcFD(){
        var P = parseFloat(fdPrincipalRange.value)||100000;
        var r = parseFloat(fdRateRange.value)||7;
        var t = parseInt(fdTenureRange.value)||5;
        var n = fdCompound;
        document.getElementById('fd_principal_display').textContent = fmt(P);
        document.getElementById('fd_rate_display').textContent      = r.toFixed(1)+' %';
        document.getElementById('fd_tenure_display').textContent    = t+' Yr';
        var A = P * Math.pow(1 + (r/100)/n, n*t);
        var interest = A - P;
        var effectiveYield = (Math.pow(1 + (r/100)/n, n) - 1) * 100;
        document.getElementById('fd_principal_out').textContent  = fmt(P);
        document.getElementById('fd_interest_out').textContent   = fmt(interest);
        document.getElementById('fd_maturity_out').textContent   = fmt(A);
        document.getElementById('fd_yield_out').textContent      = effectiveYield.toFixed(2)+'%';
        fdDonut.data.datasets[0].data = [P, interest]; fdDonut.update();
        fdBar.data.datasets[0].data   = [P, interest]; fdBar.update();
    }
    calcFD();

    // ── RD ──────────────────────────────────────────────
    var rdMonthlyRange = document.getElementById('rd_monthly_range');
    var rdRateRange    = document.getElementById('rd_rate_range');
    var rdMonthsRange  = document.getElementById('rd_months_range');
    var rdDonut = null, rdBar = null;

    [rdMonthlyRange, rdRateRange, rdMonthsRange].forEach(function(s){
        s.addEventListener('input', function(){ setP(s); calcRD(); });
        setP(s);
    });

    rdDonut = new Chart(document.getElementById('rdDonutChart').getContext('2d'), {
        type:'doughnut', data:{ labels:['Total invested','Interest'], datasets:[{ data:[300000,0], backgroundColor:['#9ca3af','#2563eb'], borderWidth:0 }] },
        options:{ responsive:true, maintainAspectRatio:true, devicePixelRatio:2, cutout:'65%', plugins:{ legend:{ display:false } } }
    });
    rdBar = new Chart(document.getElementById('rdBarChart').getContext('2d'), {
        type:'bar', data:{ labels:['Total invested','Interest earned'], datasets:[{ data:[300000,0], backgroundColor:['#9ca3af','#2563eb'], borderWidth:0, borderRadius:6, barPercentage:0.7 }] },
        options:{ indexAxis:'y', responsive:true, maintainAspectRatio:false, devicePixelRatio:2, plugins:{ legend:{ display:false } },
            scales:{ x:{ beginAtZero:true, ticks:{ callback:function(v){ return '₹'+Number(v).toLocaleString('en-IN'); } } }, y:{ ticks:{ color:'#475569', font:{ size:12 } } } }
        }
    });

    function calcRD(){
        var P = parseFloat(rdMonthlyRange.value)||5000;
        var r = parseFloat(rdRateRange.value)||6.5;
        var n = parseInt(rdMonthsRange.value)||60;
        document.getElementById('rd_monthly_display').textContent = fmt(P);
        document.getElementById('rd_rate_display').textContent    = r.toFixed(1)+' %';
        document.getElementById('rd_months_display').textContent  = n+' Mo';
        var i = (r/100)/12;
        var M = (i===0) ? P*n : P*(1+i)*((Math.pow(1+i,n)-1)/i);
        var invested = P*n;
        var interest = M - invested;
        var effectiveYield = (M/invested - 1) / (n/12) * 100;
        document.getElementById('rd_invested_out').textContent  = fmt(invested);
        document.getElementById('rd_interest_out').textContent  = fmt(interest);
        document.getElementById('rd_maturity_out').textContent  = fmt(M);
        document.getElementById('rd_yield_out').textContent     = effectiveYield.toFixed(2)+'%';
        rdDonut.data.datasets[0].data = [invested, interest]; rdDonut.update();
        rdBar.data.datasets[0].data   = [invested, interest]; rdBar.update();
    }
    calcRD();

    // ── Tab switching ─────────────────────────────────
    document.querySelectorAll('[data-fdrd]').forEach(function(btn){
        btn.addEventListener('click', function(){
            var mode = this.getAttribute('data-fdrd');
            document.querySelectorAll('[data-fdrd]').forEach(function(b){ b.classList.remove('active'); });
            this.classList.add('active');
            document.getElementById('fdPanel').style.display = mode==='fd' ? '' : 'none';
            document.getElementById('rdPanel').style.display = mode==='rd' ? '' : 'none';
        });
    });
})();
</script>
@endpush
