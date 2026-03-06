@include('tools.partials.calculator-shared-styles')
<div class="sip-calc-wrap">
    <div class="sip-tabs mb-4">
        <button type="button" class="btn btn-outline-primary active" data-mode="sip">SIP</button>
        <button type="button" class="btn btn-outline-primary" data-mode="lumpsum">Lumpsum</button>
    </div>
    <div class="row g-4">
        {{-- Left: inputs --}}
        <div class="col-lg-6">
            <h5 class="fw-bold mb-3" id="sipInputHeader">Monthly investment</h5>
            <div class="sip-slider-group">
                <label for="sip_amount" id="sipAmountLabel">Monthly investment</label>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="flex-grow-1 position-relative">
                        <input type="range" class="sip-slider w-100" id="sip_amount" min="100" max="500000" step="100" value="10000">
                        <div class="d-flex justify-content-between sip-slider-labels">
                            <span class="sip-min-label"></span>
                            <span class="sip-max-label"></span>
                        </div>
                    </div>
                    <span class="sip-value-box" id="sip_amount_display">₹ 10,000</span>
                </div>
            </div>
            <div class="sip-slider-group">
                <label for="sip_rate">Expected return (p.a)</label>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="flex-grow-1 position-relative">
                        <input type="range" class="sip-slider w-100" id="sip_rate" min="0" max="20" step="0.1" value="12">
                        <div class="d-flex justify-content-between sip-slider-labels">
                            <span class="sip-min-label"></span>
                            <span class="sip-max-label"></span>
                        </div>
                    </div>
                    <span class="sip-value-box" id="sip_rate_display">12 %</span>
                </div>
            </div>
            <div class="sip-slider-group">
                <label for="sip_years">Time period (years)</label>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="flex-grow-1 position-relative">
                        <input type="range" class="sip-slider w-100" id="sip_years" min="1" max="40" step="1" value="10">
                        <div class="d-flex justify-content-between sip-slider-labels">
                            <span class="sip-min-label"></span>
                            <span class="sip-max-label"></span>
                        </div>
                    </div>
                    <span class="sip-value-box" id="sip_years_display">10 Yr</span>
                </div>
            </div>
        </div>
        {{-- Right: small doughnut + bar chart + summary --}}
        <div class="col-lg-6">
            <div class="d-flex flex-wrap gap-3 align-items-center mb-2">
                <span class="sip-legend-item"><span class="sip-legend-dot bg-secondary"></span> Invested amount</span>
                <span class="sip-legend-item"><span class="sip-legend-dot" style="background:#2563eb"></span> Est. returns</span>
            </div>
            <div class="sip-charts-row">
                <div class="sip-doughnut-wrap">
                    <canvas id="sipDonutChart" width="160" height="160"></canvas>
                </div>
                <div class="sip-bar-wrap">
                    <canvas id="sipBarChart" height="120"></canvas>
                </div>
            </div>
            <div id="sipSummary" class="mt-4">
                <div class="sip-summary-card">
                    <div class="label">Invested amount</div>
                    <div class="value" id="sip_invested_display">₹0</div>
                </div>
                <div class="sip-summary-card">
                    <div class="label">Est. returns</div>
                    <div class="value" id="sip_returns_display">₹0</div>
                </div>
                <div class="sip-summary-card">
                    <div class="label">Total value</div>
                    <div class="value" id="sip_total_display">₹0</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="sip-description mt-4">
    <p>Investing in mutual funds through a Systematic Investment Plan (SIP) is one of the most effective ways to build wealth over time. While many confuse SIPs with the mutual funds themselves, a SIP is actually a disciplined strategy for investing, as opposed to a one-time lump sum payment. To help you visualize your financial future, a SIP Calculator provides a clear estimate of your potential returns based on your regular contributions.</p>
    <h5>What is a SIP Calculator?</h5>
    <p>A SIP calculator is a digital tool designed to estimate the future value of your mutual fund investments. It is particularly popular among millennials and first-time investors who want to see how small, regular contributions can grow into a substantial corpus.</p>
    <p><strong>Note:</strong> The calculator provides an estimate based on projected annual returns. It does not account for market volatility, exit loads, or expense ratios, which can affect the final actual value.</p>
    <h5>Key Benefits of Using the Tool</h5>
    <ul>
        <li><strong>Financial Discipline:</strong> Helps you commit to a savings habit.</li>
        <li><strong>Goal Planning:</strong> Assists in determining exactly how much you need to invest to reach a specific target.</li>
        <li><strong>Instant Clarity:</strong> Provides a breakdown of your total invested amount versus the estimated wealth gained.</li>
    </ul>
    <h5>How the Calculation Works</h5>
    <p>The calculator uses a specific formula to account for the power of compounding. The maturity amount is calculated as:</p>
    <p><code>M = P × ((1 + i)<sup>n</sup> - 1) / i × (1 + i)</code></p>
    <p>Where:<br>
       M: Maturity amount.<br>
       P: Monthly investment amount.<br>
       n: Total number of payments (months).<br>
       i: Periodic (monthly) rate of interest.</p>
    <p><strong>Calculating the Monthly Rate (i)</strong><br>
       A common error is simply dividing the annual return by 12. Because mutual fund returns compound, we use a more precise formula for the monthly rate:<br>
       <code>Monthly Return = (1 + Annual Return)^(1/12) - 1</code></p>
    <p><strong>Example:</strong><br>
       If you invest ₹1,000 per month for 12 months at an expected annual return of 12%: The effective monthly rate (i) is approximately 0.95% (not 1%). Plugging this into the formula results in an estimated maturity value of ₹12,766.</p>
    <h5>Why Use the Groww SIP Calculator?</h5>
    <p>Manual calculations involving compounding can be complex and prone to error. The Groww SIP calculator simplifies this into three easy steps:</p>
    <ol>
        <li>Input Monthly Amount: How much you plan to save.</li>
        <li>Select Tenure: How many years you intend to stay invested.</li>
        <li>Expected Return: Your projected annual growth rate.</li>
    </ol>
    <p><strong>Advantages</strong></p>
    <ul>
        <li>Speed: Get results instantly without manual math.</li>
        <li>Accuracy: Uses precise compounding formulas to ensure your projections are realistic.</li>
        <li>Customization: Adjust the variables to see how increasing your investment or tenure impacts your final wealth.</li>
    </ul>
    <p>Would you like me to calculate a specific scenario for you, or perhaps compare how a SIP performs against a lump sum investment over the same period?</p>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.min.css">
<style>
.sip-calc-wrap { max-width: 100%; }
.sip-slider-group { margin-bottom: 1.5rem; }
.sip-slider-group label { font-weight: 600; color: #374151; margin-bottom: 0.5rem; display: block; }
.sip-value-box {
    display: inline-block;
    min-width: 5.5rem;
    padding: 0.375rem 0.5rem;
    background: #dbeafe;
    border: 1px solid #93c5fd;
    border-radius: 8px;
    font-weight: 600;
    color: #1e40af;
    text-align: right;
    font-size: 0.875rem;
}
.sip-slider {
    -webkit-appearance: none;
    width: 100%;
    height: 12px;
    border-radius: 6px;
    background: linear-gradient(to right, #2563eb 0%, #2563eb var(--progress, 0%), #e5e7eb var(--progress, 0%), #e5e7eb 100%);
    outline: none;
}
.sip-slider-labels {
    position: absolute;
    top: 100%;
    width: 100%;
    font-size: 0.75rem;
    color: #64748b;
    margin-top: 0.25rem;
}
.sip-slider-labels .sip-min-label,
.sip-slider-labels .sip-max-label {
    user-select: none;
}
.sip-slider::-moz-range-progress {
    height: 12px;
    border-radius: 6px;
    background: #2563eb;
}
.sip-slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: #2563eb;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(37,99,235,0.4);
}
.sip-slider::-moz-range-thumb {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: #2563eb;
    cursor: pointer;
    border: none;
}
.sip-summary-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 0.75rem;
}
#sipSummary {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    justify-content: flex-start;
    align-items: center;
}
.sip-summary-card {
    flex: 1 1 30%;
    min-width: 8rem;
    margin-bottom: 0;
}
.sip-legend-item { display: inline-flex; align-items: center; gap: 0.5rem; margin-right: 1rem; font-size: 0.875rem; color: #475569; }
.sip-legend-dot { width: 12px; height: 12px; border-radius: 2px; }
/* SIP: small doughnut + bar chart side by side, high resolution */
.sip-charts-row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.5rem;
}
.sip-doughnut-wrap {
    flex-shrink: 0;
    width: 140px;
    height: 140px;
    position: relative;
}
.sip-doughnut-wrap canvas {
    width: 140px !important;
    height: 140px !important;
    max-width: 140px;
    max-height: 140px;
}
.sip-bar-wrap {
    flex: 1;
    min-width: 200px;
    height: 120px;
}
.sip-bar-wrap canvas {
    width: 100% !important;
    height: 120px !important;
}
.sip-tabs button {
    font-weight: 600;
}
.sip-tabs button.active {
    color: #fff !important;
    background-color: #0d6efd !important;
    border-color: #0d6efd !important;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function() {
    var amountSlider = document.getElementById('sip_amount');
    var rateSlider = document.getElementById('sip_rate');
    var yearsSlider = document.getElementById('sip_years');
    var amountDisplay = document.getElementById('sip_amount_display');
    var rateDisplay = document.getElementById('sip_rate_display');
    var yearsDisplay = document.getElementById('sip_years_display');
    var investedDisplay = document.getElementById('sip_invested_display');
    var returnsDisplay = document.getElementById('sip_returns_display');
    var totalDisplay = document.getElementById('sip_total_display');
    var sipDonutChart = null;
    var sipBarChart = null;
    var mode = 'sip';

    function formatINR(n) {
        var x = Math.round(n);
        if (x >= 10000000) return (x / 10000000).toFixed(1) + ' Cr';
        if (x >= 100000) return (x / 100000).toFixed(1) + ' L';
        return '₹ ' + x.toLocaleString('en-IN');
    }

    function formatINRFull(n) {
        return '₹' + Math.round(n).toLocaleString('en-IN');
    }

    function updateRangeLabels(slider) {
        var container = slider.parentElement.querySelector('.sip-slider-labels');
        if (!container) return;
        var minSpan = container.querySelector('.sip-min-label');
        var maxSpan = container.querySelector('.sip-max-label');
        var min = slider.min;
        var max = slider.max;
        if (slider === amountSlider) {
            if (mode === 'sip') {
                minSpan.textContent = formatINRFull(min);
                maxSpan.textContent = formatINRFull(max);
            } else {
                minSpan.textContent = formatINRFull(min);
                maxSpan.textContent = formatINRFull(max);
            }
        } else if (slider === rateSlider) {
            minSpan.textContent = min + ' %';
            maxSpan.textContent = max + ' %';
        } else if (slider === yearsSlider) {
            minSpan.textContent = min + ' Yr';
            maxSpan.textContent = max + ' Yr';
        }
    }

    function setSliderProgress(slider) {
        var min = parseFloat(slider.min);
        var max = parseFloat(slider.max);
        var val = parseFloat(slider.value);
        var pct = min >= max ? 0 : ((val - min) / (max - min)) * 100;
        slider.style.setProperty('--progress', pct + '%');
    }

    function calculate() {
        var amount = parseFloat(amountSlider.value);
        var annual = parseFloat(rateSlider.value);
        var years = parseInt(yearsSlider.value, 10);
        var months = years * 12;
        // monthly rate from annual
        var i = Math.pow(1 + annual/100, 1/12) - 1;
        var invested, maturity;
        if (mode === 'sip') {
            invested = amount * months;
            if (i === 0) maturity = invested;
            else maturity = amount * ((Math.pow(1 + i, months) - 1) / i) * (1 + i);
        } else {
            invested = amount;
            maturity = invested * Math.pow(1 + i, months);
        }
        var returns = maturity - invested;
        investedDisplay.textContent = formatINRFull(invested);
        returnsDisplay.textContent = formatINRFull(returns);
        totalDisplay.textContent = formatINRFull(maturity);
        if (sipDonutChart) {
            sipDonutChart.data.datasets[0].data = [invested, returns];
            sipDonutChart.update();
        }
        if (sipBarChart) {
            sipBarChart.data.datasets[0].data = [invested, returns];
            sipBarChart.update();
        }
    }

    function updateDisplays() {
        var amount = parseFloat(amountSlider.value);
        var annual = parseFloat(rateSlider.value);
        var years = parseInt(yearsSlider.value, 10);
        amountDisplay.textContent = mode === 'sip' ? formatINRFull(amount) : formatINRFull(amount);
        rateDisplay.textContent = annual + ' %';
        yearsDisplay.textContent = years + ' Yr';
    }

    function switchMode(newMode) {
        mode = newMode;
        document.querySelectorAll('.sip-tabs button').forEach(function(btn) {
            btn.classList.toggle('active', btn.getAttribute('data-mode') === mode);
        });
        var header = document.getElementById('sipInputHeader');
        var label = document.getElementById('sipAmountLabel');
        if (mode === 'sip') {
            header.textContent = 'Monthly investment';
            label.textContent = 'Monthly investment';
            // adjust slider range for monthly contributions
            amountSlider.min = 100;
            amountSlider.max = 500000;
            amountSlider.step = 100;
        } else {
            header.textContent = 'Lumpsum amount';
            label.textContent = 'Lumpsum amount';
            // adjust for lump sum (larger values)
            amountSlider.min = 1000;
            amountSlider.max = 10000000;
            amountSlider.step = 500;
        }
        // ensure slider value within new range
        if (parseFloat(amountSlider.value) < parseFloat(amountSlider.min)) {
            amountSlider.value = amountSlider.min;
        }
        if (parseFloat(amountSlider.value) > parseFloat(amountSlider.max)) {
            amountSlider.value = amountSlider.max;
        }
        setSliderProgress(amountSlider);
        updateRangeLabels(amountSlider);
        updateDisplays();
        calculate();
    }

    [amountSlider, rateSlider, yearsSlider].forEach(function(s) {
        s.addEventListener('input', function() {
            setSliderProgress(s);
            updateRangeLabels(s);
            updateDisplays();
            calculate();
        });
        setSliderProgress(s);
        updateRangeLabels(s);
    });

    document.querySelectorAll('.sip-tabs button').forEach(function(btn) {
        btn.addEventListener('click', function() {
            switchMode(this.getAttribute('data-mode'));
        });
    });

    sipDonutChart = new Chart(document.getElementById('sipDonutChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Invested amount', 'Estimated returns'],
            datasets: [{
                data: [0, 0],
                backgroundColor: ['#9ca3af', '#2563eb'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            devicePixelRatio: 2,
            cutout: '65%',
            plugins: { legend: { display: false } }
        }
    });

    sipBarChart = new Chart(document.getElementById('sipBarChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['Invested amount', 'Estimated returns'],
            datasets: [{
                data: [0, 0],
                backgroundColor: ['#9ca3af', '#2563eb'],
                borderWidth: 0,
                borderRadius: 6,
                barPercentage: 0.7
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            devicePixelRatio: 2,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            try { return '₹' + Number(value).toLocaleString('en-IN'); } catch (e) { return value; }
                        }
                    }
                },
                y: { ticks: { color: '#475569', font: { size: 12 } } }
            }
        }
    });

    switchMode('sip');
})();
</script>
@endpush
