{{-- EMI Calculator: editable sliders, custom EMI, lump-sum prepayment --}}
@include('tools.partials.calculator-shared-styles')

<div class="emi-calc-wrap">
    <div class="row g-4">
        {{-- Left: Inputs --}}
        <div class="col-lg-6">
            <h5 class="fw-bold mb-3">Loan details</h5>

            {{-- Loan Amount --}}
            <div class="emi-slider-group">
                <label for="emi_amount">Loan amount</label>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="flex-grow-1 position-relative">
                        <input type="range" class="emi-slider w-100" id="emi_amount" min="1000" max="20000000" step="1000" value="100000">
                        <div class="d-flex justify-content-between emi-slider-labels">
                            <span class="emi-min-label"></span>
                            <span class="emi-max-label"></span>
                        </div>
                    </div>
                    <input type="text" class="emi-value-input" id="emi_amount_display" value="1,00,000" inputmode="numeric" title="Type amount and press Enter">
                </div>
            </div>

            {{-- Rate of Interest --}}
            <div class="emi-slider-group">
                <label for="emi_rate">Rate of interest (p.a)</label>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="flex-grow-1 position-relative">
                        <input type="range" class="emi-slider w-100" id="emi_rate" min="1" max="30" step="0.1" value="7.8">
                        <div class="d-flex justify-content-between emi-slider-labels">
                            <span class="emi-min-label"></span>
                            <span class="emi-max-label"></span>
                        </div>
                    </div>
                    <input type="text" class="emi-value-input" id="emi_rate_display" value="7.8 %" inputmode="decimal" title="Type rate % and press Enter">
                </div>
            </div>

            {{-- Loan Tenure --}}
            <div class="emi-slider-group">
                <label for="emi_tenure">Loan tenure</label>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="flex-grow-1 position-relative">
                        <input type="range" class="emi-slider w-100" id="emi_tenure" min="1" max="40" step="1" value="15">
                        <div class="d-flex justify-content-between emi-slider-labels">
                            <span class="emi-min-label"></span>
                            <span class="emi-max-label"></span>
                        </div>
                    </div>
                    <input type="text" class="emi-value-input" id="emi_tenure_display" value="15 Yr" inputmode="numeric" title="Type tenure in years and press Enter">
                </div>
            </div>

            {{-- Custom EMI override --}}
            <div class="emi-custom-emi-box mt-3">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <input type="checkbox" id="emi_custom_toggle" class="form-check-input mt-0">
                    <label for="emi_custom_toggle" class="fw-semibold mb-0" style="cursor:pointer;font-size:0.93rem;">
                        Set my own EMI (back-calculate tenure)
                    </label>
                </div>
                <div id="emiCustomEmiRow" style="display:none">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <input type="number" class="form-control flex-grow-1" id="emi_custom_value" placeholder="Enter desired EMI ₹" min="1" style="min-width: 200px;">
                        <div class="d-flex gap-2">
                            <span style="display: inline-block;"><button type="button" class="btn btn-primary btn-sm" id="emiCustomApply"><span style="color: #ffffff; display: inline-block;">Apply</span></button></span>
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="emiCustomReset">Reset</button>
                        </div>
                    </div>
                    <div id="emiCustomResult" class="mt-2" style="display:none">
                        <span class="badge bg-success-subtle text-success-emphasis me-2" id="emiCustomTenureOut"></span>
                        <span class="badge bg-warning-subtle text-warning-emphasis" id="emiCustomSavingOut"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Small doughnut + bar chart + summary cards --}}
        <div class="col-lg-6">
            <div class="d-flex flex-wrap gap-3 align-items-center mb-2">
                <span class="emi-legend-item"><span class="emi-legend-dot bg-secondary"></span> Principal amount</span>
                <span class="emi-legend-item"><span class="emi-legend-dot" style="background:#2563eb"></span> Interest amount</span>
            </div>
            <div class="emi-charts-row">
                <div class="emi-doughnut-wrap">
                    <canvas id="emiDonutChart" width="160" height="160"></canvas>
                </div>
                <div class="emi-bar-wrap">
                    <canvas id="emiBarChart" height="120"></canvas>
                </div>
            </div>
            <div id="emiSummary" class="mt-4">
                <div class="emi-summary-card">
                    <div class="label">Monthly EMI</div>
                    <div class="value emi-highlight" id="emi_monthly_display">₹944</div>
                </div>
                <div class="emi-summary-card">
                    <div class="label">Principal amount</div>
                    <div class="value" id="emi_principal_display">₹1,00,000</div>
                </div>
                <div class="emi-summary-card">
                    <div class="label">Total interest</div>
                    <div class="value" id="emi_interest_display">₹69,946</div>
                </div>
                <div class="emi-summary-card">
                    <div class="label">Total amount</div>
                    <div class="value" id="emi_total_display">₹1,69,946</div>
                </div>
                <div class="emi-summary-card">
                    <div class="label">Interest %</div>
                    <div class="value" id="emi_interest_pct_display">41.2%</div>
                </div>
                <div class="emi-summary-card">
                    <div class="label">Loan pay-off</div>
                    <div class="value" id="emi_payoff_display">—</div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    {{-- ── Lump Sum Prepayment Section ── --}}
    <div class="emi-prepay-section">
        <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
            <h5 class="fw-bold mb-0">
                <i class="fa-solid fa-hand-holding-dollar me-2 text-primary"></i>Lump Sum Prepayment Simulator
            </h5>
            <span class="badge bg-primary-subtle text-primary-emphasis">Smart feature</span>
        </div>
        <p class="text-muted small mb-3">
            Check how much interest you save &amp; how many months are reduced if you make a one-time
            lump sum payment on top of your regular EMIs.
        </p>
        <div class="row g-3 align-items-end">
            <div class="col-sm-4">
                <label class="form-label fw-semibold">Lump sum amount (₹)</label>
                <div class="input-group">
                    <span class="input-group-text">₹</span>
                    <input type="number" class="form-control" id="prepay_amount" placeholder="e.g. 50000" min="1">
                </div>
            </div>
            <div class="col-sm-4">
                <label class="form-label fw-semibold">Pay after (months from now)</label>
                <input type="number" class="form-control" id="prepay_after_months" value="12" min="1">
            </div>
            <div class="col-sm-4">
                <label class="form-label fw-semibold">After prepayment keep</label>
                <select class="form-select" id="prepay_mode">
                    <option value="reduce_tenure">Same EMI → Reduce tenure</option>
                    <option value="reduce_emi">Same tenure → Reduce EMI</option>
                </select>
            </div>
            <div class="col-12">
                <button type="button" class="btn btn-primary" id="prepayCalcBtn">
                    <i class="fa-solid fa-calculator me-2"></i>Calculate Prepayment Impact
                </button>
            </div>
        </div>

        {{-- Prepayment Results --}}
        <div id="prepayResult" style="display:none" class="mt-4">
            <div class="prepay-comparison-grid">
                {{-- Without --}}
                <div class="prepay-col prepay-col--base">
                    <div class="prepay-col-head">Without Prepayment</div>
                    <div class="prepay-row"><span>Total EMIs</span><strong id="pre_orig_emis">—</strong></div>
                    <div class="prepay-row"><span>Monthly EMI</span><strong id="pre_orig_emi">—</strong></div>
                    <div class="prepay-row"><span>Total interest</span><strong id="pre_orig_interest">—</strong></div>
                    <div class="prepay-row"><span>Total amount</span><strong id="pre_orig_total">—</strong></div>
                    <div class="prepay-row"><span>Loan closes</span><strong id="pre_orig_close">—</strong></div>
                </div>
                {{-- Arrow --}}
                <div class="prepay-arrow"><i class="fa-solid fa-arrow-right fa-xl text-primary"></i></div>
                {{-- With --}}
                <div class="prepay-col prepay-col--new">
                    <div class="prepay-col-head">With Prepayment of <span id="pre_lump_label">₹0</span></div>
                    <div class="prepay-row"><span>Total EMIs</span><strong id="pre_new_emis">—</strong></div>
                    <div class="prepay-row"><span>Monthly EMI</span><strong id="pre_new_emi">—</strong></div>
                    <div class="prepay-row"><span>Total interest</span><strong id="pre_new_interest">—</strong></div>
                    <div class="prepay-row"><span>Total amount</span><strong id="pre_new_total">—</strong></div>
                    <div class="prepay-row"><span>Loan closes</span><strong id="pre_new_close">—</strong></div>
                </div>
            </div>
            {{-- Savings highlight --}}
            <div class="prepay-savings-row mt-3">
                <div class="prepay-saving-badge">
                    <i class="fa-solid fa-piggy-bank me-2"></i>Interest saved: <strong id="pre_interest_saved">—</strong>
                </div>
                <div class="prepay-saving-badge prepay-saving-badge--blue">
                    <i class="fa-solid fa-clock me-2"></i>Months saved: <strong id="pre_months_saved">—</strong>
                </div>
            </div>
            {{-- Prepayment chart --}}
            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <div class="emi-bar-wrap" style="height:130px">
                        <canvas id="prepayBarChart" height="130"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    {{-- Amortization details --}}
    <div class="emi-amort-header">
        <h5 class="fw-bold mb-0">Your Amortization Details (Yearly/Monthly)</h5>
        <button type="button" class="btn btn-outline-secondary btn-sm d-none" id="emiAmortClose" aria-label="Close">×</button>
    </div>
    <div id="emiAmortYears"></div>
    <div class="emi-load-more">
        <button type="button" class="btn btn-primary" id="emiLoadMore">Load More</button>
    </div>
</div>

@push('styles')
<style>
/* Editable value inputs (replacing the static span) */
.emi-value-input {
    display: inline-block;
    min-width: 3rem;
    width: 7rem;
    padding: 0.3rem 0.4rem;
    background: #dbeafe;
    border: 2px solid #93c5fd;
    border-radius: 6px;
    font-weight: 700;
    color: #1e40af;
    font-size: 0.75rem;
    text-align: right;
    flex-shrink: 0;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.emi-value-input:focus {
    background: #fff;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
    outline: none;
    color: #0f172a;
}

/* Custom EMI box */
.emi-custom-emi-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1rem 1.25rem;
}

.emi-custom-emi-box .form-control {
    font-size: 0.9rem;
    padding: 0.5rem 0.75rem;
}

.emi-custom-emi-box .btn-sm {
    padding: 0.4rem 1rem;
    font-size: 0.85rem;
    font-weight: 600;
}

#emiCustomApply,
#emiCustomApply.btn-primary {
    background-color: #0d6efd !important;
    border-color: #0d6efd !important;
}

#emiCustomApply span {
    color: #ffffff !important;
    font-weight: 600;
}

#emiCustomApply:hover span,
#emiCustomApply:hover,
#emiCustomApply:not(:disabled):not(.disabled):hover {
    background-color: #0b5ed7 !important;
    border-color: #0b5ed7 !important;
}

#emiCustomApply:hover span {
    color: #ffffff !important;
}

#emiCustomApply:focus,
#emiCustomApply:focus span {
    background-color: #0d6efd !important;
    border-color: #0d6efd !important;
    color: #ffffff !important;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.5) !important;
}

#emiCustomApply:active,
#emiCustomApply.active {
    background-color: #0b5ed7 !important;
    border-color: #0b5ed7 !important;
}

#emiCustomApply:active span {
    color: #ffffff !important;
}

.emi-custom-emi-box .btn-sm:hover {
    color: inherit !important;
    text-decoration: none;
}

.emi-custom-emi-box .btn-outline-primary:hover {
    color: #fff !important;
    background-color: #0d6efd !important;
    border-color: #0d6efd !important;
}

.emi-custom-emi-box .btn-outline-secondary:hover {
    color: #fff !important;
    background-color: #6c757d !important;
    border-color: #6c757d !important;
}

.emi-custom-emi-box .form-control:focus {
    color: #0f172a !important;
    background-color: #fff !important;
}

#emiCustomEmiRow {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

#emiCustomEmiRow .d-flex {
    flex-wrap: wrap;
    gap: 0.5rem;
}

#emiCustomEmiRow .form-control {
    flex: 1;
    min-width: 150px;
}

#emiCustomEmiRow .btn {
    flex: 0 1 auto;
}

#emiCustomResult {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

#emiCustomResult .badge {
    padding: 0.4rem 0.8rem;
    font-size: 0.8rem;
}

/* Monthly EMI highlight */
.emi-highlight { color: #2563eb; font-size: 1.35rem; }

/* ── Prepayment section ──────────────────────────────── */
.emi-prepay-section {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 16px;
    padding: 1.5rem 1.75rem;
}
.prepay-comparison-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    align-items: center;
}
.prepay-col {
    flex: 1;
    min-width: 220px;
    border-radius: 12px;
    padding: 1.25rem 1.5rem;
    border: 1px solid #e2e8f0;
}
.prepay-col--base { background: #fff; }
.prepay-col--new  { background: linear-gradient(135deg, #eff6ff, #f0fdf4); border-color: #86efac; }
.prepay-col-head  { font-weight: 700; font-size: 0.9rem; margin-bottom: 0.75rem; color: #374151; }
.prepay-col--new .prepay-col-head { color: #15803d; }
.prepay-row { display: flex; justify-content: space-between; align-items: center; padding: 0.35rem 0; border-bottom: 1px solid #f1f5f9; font-size: 0.87rem; color: #64748b; }
.prepay-row:last-child { border-bottom: none; }
.prepay-row strong { color: #0f172a; }
.prepay-col--new .prepay-row strong { color: #15803d; }
.prepay-arrow { font-size: 1.5rem; flex-shrink: 0; display: flex; align-items: center; }
.prepay-savings-row { display: flex; flex-wrap: wrap; gap: 0.75rem; }
.prepay-saving-badge {
    display: inline-flex; align-items: center;
    background: #dcfce7; border: 1px solid #86efac;
    color: #15803d; border-radius: 50px; padding: 0.5rem 1.1rem;
    font-size: 0.88rem; font-weight: 600;
}
.prepay-saving-badge--blue {
    background: #dbeafe; border-color: #93c5fd; color: #1e40af;
}

/* Prepayment section select styling */
#prepay_mode {
    background-color: #fff !important;
    border: 2px solid #93c5fd !important;
    color: #0f172a !important;
    font-weight: 500 !important;
    padding: 0.5rem 2.5rem 0.5rem 0.75rem !important;
    font-size: 0.95rem !important;
    line-height: 1.5;
    min-width: 250px;
}

#prepay_mode:hover {
    border-color: #2563eb !important;
    background-color: #f8fafc !important;
}

#prepay_mode:focus {
    border-color: #2563eb !important;
    box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25) !important;
    color: #0f172a !important;
}

#prepay_mode option {
    background-color: #fff;
    color: #0f172a;
    padding: 0.5rem 1rem;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function() {
    // ── DOM refs ───────────────────────────────────────────
    var amountSlider  = document.getElementById('emi_amount');
    var rateSlider    = document.getElementById('emi_rate');
    var tenureSlider  = document.getElementById('emi_tenure');
    var amountInput   = document.getElementById('emi_amount_display');
    var rateInput     = document.getElementById('emi_rate_display');
    var tenureInput   = document.getElementById('emi_tenure_display');
    var monthlyDisp   = document.getElementById('emi_monthly_display');
    var principalDisp = document.getElementById('emi_principal_display');
    var interestDisp  = document.getElementById('emi_interest_display');
    var totalDisp     = document.getElementById('emi_total_display');
    var pctDisp       = document.getElementById('emi_interest_pct_display');
    var payoffDisp    = document.getElementById('emi_payoff_display');
    var amortContainer= document.getElementById('emiAmortYears');
    var loadMoreBtn   = document.getElementById('emiLoadMore');

    var emiDonutChart = null, emiBarChart = null, prepayBarChart = null;
    var AMORT_PER_PAGE = 5;
    var amortYearsShown = 0, amortSchedule = [], expandedYears = {};
    var currentEMI = 0;   // last computed standard EMI

    // ── Formatting ─────────────────────────────────────────
    function fmtFull(n)  { return '₹' + Math.round(n).toLocaleString('en-IN'); }
    function fmtShort(n) {
        var x = Math.round(n);
        if (x >= 10000000) return '₹' + (x/10000000).toFixed(2) + ' Cr';
        if (x >= 100000)   return '₹' + (x/100000).toFixed(2) + ' L';
        return fmtFull(x);
    }
    function stripINR(s) { return parseFloat(String(s).replace(/[₹,%\s A-Za-z]/g, '')) || 0; }

    // ── Slider progress track ──────────────────────────────
    function setProgress(slider) {
        var mn = parseFloat(slider.min), mx = parseFloat(slider.max), v = parseFloat(slider.value);
        slider.style.setProperty('--progress', ((v - mn) / (mx - mn) * 100) + '%');
    }

    // ── Sync slider ↔ text input ───────────────────────────
    function syncAmountFromSlider() {
        var v = parseInt(amountSlider.value, 10);
        amountInput.value = v.toLocaleString('en-IN');
    }
    function syncRateFromSlider() {
        var v = parseFloat(rateSlider.value);
        rateInput.value = v.toFixed(1) + ' %';
    }
    function syncTenureFromSlider() {
        var v = parseInt(tenureSlider.value, 10);
        tenureInput.value = v + ' Yr';
    }
    function updateRangeLabels() {
        var ap = amountSlider.parentElement.querySelector('.emi-slider-labels');
        if (ap) { ap.querySelector('.emi-min-label').textContent = fmtFull(amountSlider.min); ap.querySelector('.emi-max-label').textContent = fmtShort(amountSlider.max); }
        var rp = rateSlider.parentElement.querySelector('.emi-slider-labels');
        if (rp) { rp.querySelector('.emi-min-label').textContent = rateSlider.min + ' %'; rp.querySelector('.emi-max-label').textContent = rateSlider.max + ' %'; }
        var tp = tenureSlider.parentElement.querySelector('.emi-slider-labels');
        if (tp) { tp.querySelector('.emi-min-label').textContent = tenureSlider.min + ' Yr'; tp.querySelector('.emi-max-label').textContent = tenureSlider.max + ' Yr'; }
    }

    // ── Core calculation ───────────────────────────────────
    function calcEMI(P, annualRate, months) {
        if (months <= 0 || P <= 0) return 0;
        var r = annualRate / 12 / 100;
        if (r === 0) return P / months;
        return (P * r * Math.pow(1 + r, months)) / (Math.pow(1 + r, months) - 1);
    }

    function updateDisplays() {
        var amount  = parseInt(amountSlider.value, 10);
        var rate    = parseFloat(rateSlider.value);
        var years   = parseInt(tenureSlider.value, 10);
        var months  = years * 12;

        syncAmountFromSlider();
        syncRateFromSlider();
        syncTenureFromSlider();

        var emi          = calcEMI(amount, rate, months);
        currentEMI       = emi;
        var totalPayment = emi * months;
        var totalInterest= totalPayment - amount;
        var pct          = amount > 0 ? (totalInterest / totalPayment * 100).toFixed(1) : '0';

        // Pay-off date
        var payoffDate = new Date();
        payoffDate.setMonth(payoffDate.getMonth() + months);
        var payoffStr = payoffDate.toLocaleString('en-IN', { month: 'short', year: 'numeric' });

        monthlyDisp.textContent   = fmtFull(emi);
        principalDisp.textContent = fmtFull(amount);
        interestDisp.textContent  = fmtFull(totalInterest);
        totalDisp.textContent     = fmtFull(totalPayment);
        pctDisp.textContent       = pct + '%';
        payoffDisp.textContent    = payoffStr;

        if (emiDonutChart) { emiDonutChart.data.datasets[0].data = [amount, totalInterest]; emiDonutChart.update(); }
        if (emiBarChart)   { emiBarChart.data.datasets[0].data   = [amount, totalInterest]; emiBarChart.update(); }

        buildAmortSchedule(amount, rate, months, emi);
    }

    // ── Slider event listeners ─────────────────────────────
    amountSlider.addEventListener('input', function() { setProgress(this); updateDisplays(); });
    rateSlider.addEventListener('input',   function() { setProgress(this); updateDisplays(); });
    tenureSlider.addEventListener('input', function() { setProgress(this); updateDisplays(); });
    [amountSlider, rateSlider, tenureSlider].forEach(setProgress);
    updateRangeLabels();

    // ── Editable text inputs → update slider & recalc ─────
    function commitAmountInput() {
        var v = stripINR(amountInput.value);
        if (v < 1000)    v = 1000;
        if (v > 20000000) v = 20000000;
        amountSlider.value = v;
        setProgress(amountSlider);
        updateDisplays();
    }
    function commitRateInput() {
        var v = stripINR(rateInput.value);
        if (v < 1)  v = 1;
        if (v > 30) v = 30;
        rateSlider.value = v;
        setProgress(rateSlider);
        updateDisplays();
    }
    function commitTenureInput() {
        var v = Math.round(stripINR(tenureInput.value));
        if (v < 1)  v = 1;
        if (v > 40) v = 40;
        tenureSlider.value = v;
        setProgress(tenureSlider);
        updateDisplays();
    }
    amountInput.addEventListener('keydown',  function(e){ if(e.key==='Enter') commitAmountInput(); });
    amountInput.addEventListener('blur', commitAmountInput);
    rateInput.addEventListener('keydown',    function(e){ if(e.key==='Enter') commitRateInput(); });
    rateInput.addEventListener('blur', commitRateInput);
    tenureInput.addEventListener('keydown',  function(e){ if(e.key==='Enter') commitTenureInput(); });
    tenureInput.addEventListener('blur', commitTenureInput);

    // Clear unit label on focus so user can type freely
    rateInput.addEventListener('focus',   function(){ this.value = stripINR(this.value) || ''; });
    tenureInput.addEventListener('focus', function(){ this.value = stripINR(this.value) || ''; });

    // ── Custom EMI toggle ──────────────────────────────────
    var customToggle = document.getElementById('emi_custom_toggle');
    var customRow    = document.getElementById('emiCustomEmiRow');
    var customInput  = document.getElementById('emi_custom_value');
    var customApply  = document.getElementById('emiCustomApply');
    var customReset  = document.getElementById('emiCustomReset');
    var customResult = document.getElementById('emiCustomResult');

    customToggle.addEventListener('change', function() {
        customRow.style.display = this.checked ? '' : 'none';
        if (!this.checked) { customResult.style.display = 'none'; }
    });

    customApply.addEventListener('click', function() {
        var desiredEMI  = parseFloat(customInput.value) || 0;
        var amount      = parseInt(amountSlider.value, 10);
        var rate        = parseFloat(rateSlider.value);
        if (desiredEMI <= 0 || amount <= 0 || rate <= 0) return;

        // Back-calculate tenure: n = -ln(1 - Pr/E) / ln(1+r)  (standard formula)
        var r = rate / 12 / 100;
        var minEMI = amount * r; // interest for month 1
        if (desiredEMI <= minEMI) {
            customResult.style.display = 'block';
            document.getElementById('emiCustomTenureOut').textContent = 'EMI too low — must be > ' + fmtFull(minEMI);
            document.getElementById('emiCustomSavingOut').textContent = '';
            return;
        }
        var n = -Math.log(1 - (amount * r) / desiredEMI) / Math.log(1 + r);
        var newMonths = Math.ceil(n);

        var origMonths       = parseInt(tenureSlider.value, 10) * 12;
        var origTotal        = currentEMI * origMonths;
        var newTotal         = desiredEMI * newMonths;
        var interestDiff     = (origTotal - amount) - (newTotal - amount);
        var saved            = interestDiff > 0;

        var tenureYr = Math.floor(newMonths / 12), tenureMo = newMonths % 12;
        var tenureStr = tenureYr > 0 ? tenureYr + ' Yr' + (tenureMo > 0 ? ' ' + tenureMo + ' Mo' : '') : tenureMo + ' Mo';

        document.getElementById('emiCustomTenureOut').textContent = 'New tenure: ' + tenureStr + ' (' + newMonths + ' EMIs)';
        document.getElementById('emiCustomSavingOut').textContent = saved
            ? 'Interest saved: ' + fmtFull(interestDiff)
            : 'Extra interest: ' + fmtFull(-interestDiff);

        customResult.style.display = 'block';
    });

    customReset.addEventListener('click', function() {
        customInput.value = '';
        customResult.style.display = 'none';
    });

    // ── Amortization schedule ──────────────────────────────
    function buildAmortSchedule(P, annualRate, months, emi) {
        var r = annualRate / 12 / 100;
        var schedule = [], balance = P, startDate = new Date();
        for (var i = 0; i < months; i++) {
            var interest  = balance * r;
            var principal = emi - interest;
            if (principal > balance) principal = balance;
            balance = Math.max(0, balance - principal);
            var d = new Date(startDate);
            d.setMonth(d.getMonth() + i);
            schedule.push({
                month: d.getMonth(),
                monthName: d.toLocaleString('en-IN', { month: 'short' }),
                year: d.getFullYear(),
                principal: principal,
                interest: interest,
                total: emi,
                balance: balance
            });
        }
        amortSchedule = schedule;
        amortYearsShown = 0;
        expandedYears = {};
        renderAmortYears(false);
    }

    function getYears() {
        var set = {};
        amortSchedule.forEach(function(r) { set[r.year] = true; });
        return Object.keys(set).map(Number).sort(function(a,b){return a-b;});
    }

    function renderAmortYears(appendOnly) {
        var years = getYears();
        if (!appendOnly) amortYearsShown = Math.min(AMORT_PER_PAGE, years.length);
        else amortYearsShown = Math.min(amortYearsShown + AMORT_PER_PAGE, years.length);
        loadMoreBtn.classList.toggle('d-none', amortYearsShown >= years.length);
        if (!appendOnly) amortContainer.innerHTML = '';
        years.slice(0, amortYearsShown).forEach(function(y) {
            if (appendOnly && document.getElementById('emi-year-' + y)) return;
            var rows = amortSchedule.filter(function(r) { return r.year === y; });
            var yPrincipal = rows.reduce(function(s,r){return s+r.principal;},0);
            var yInterest  = rows.reduce(function(s,r){return s+r.interest;},0);
            var rowEl = document.createElement('div');
            rowEl.className = 'emi-year-row' + (expandedYears[y] ? ' expanded' : '');
            rowEl.id = 'emi-year-' + y;
            rowEl.setAttribute('data-year', y);
            rowEl.setAttribute('role', 'button');
            rowEl.innerHTML =
                '<span class="fw-semibold">' + y + '</span>' +
                '<span class="d-flex gap-3" style="font-size:0.82rem;color:#64748b">' +
                  '<span>Principal: <strong>' + fmtFull(yPrincipal) + '</strong></span>' +
                  '<span>Interest: <strong>' + fmtFull(yInterest) + '</strong></span>' +
                '</span>' +
                '<i class="fa fa-chevron-down"></i>';
            amortContainer.appendChild(rowEl);
            if (expandedYears[y]) insertYearDetail(y, rowEl);
            rowEl.addEventListener('click', function() {
                var yr = parseInt(this.getAttribute('data-year'), 10);
                var detail = document.getElementById('emi-detail-' + yr);
                if (detail) { expandedYears[yr]=false; this.classList.remove('expanded'); detail.remove(); return; }
                expandedYears[yr]=true; this.classList.add('expanded'); insertYearDetail(yr, this);
            });
        });
    }

    function insertYearDetail(y, afterEl) {
        var rows = amortSchedule.filter(function(r) { return r.year === y; });
        var div = document.createElement('div');
        div.className = 'emi-year-detail';
        div.id = 'emi-detail-' + y;
        div.innerHTML = '<div style="overflow-x:auto"><table class="emi-amort-table"><thead><tr><th>Month</th><th>Principal Paid</th><th>Interest Charged</th><th>Total Payment</th><th>Balance</th></tr></thead><tbody>' +
            rows.map(function(row) {
                return '<tr><td>' + row.monthName + '</td><td>' + fmtFull(row.principal) + '</td><td>' + fmtFull(row.interest) + '</td><td>' + fmtFull(row.total) + '</td><td>' + fmtFull(row.balance) + '</td></tr>';
            }).join('') + '</tbody></table></div>';
        afterEl.after(div);
    }

    loadMoreBtn.addEventListener('click', function() { renderAmortYears(true); });

    // ── Charts ─────────────────────────────────────────────
    emiDonutChart = new Chart(document.getElementById('emiDonutChart').getContext('2d'), {
        type: 'doughnut',
        data: { labels: ['Principal', 'Interest'], datasets: [{ data: [100000, 69946], backgroundColor: ['#9ca3af', '#2563eb'], borderWidth: 0 }] },
        options: { responsive:true, maintainAspectRatio:true, devicePixelRatio:2, cutout:'65%', plugins:{ legend:{display:false} } }
    });

    emiBarChart = new Chart(document.getElementById('emiBarChart').getContext('2d'), {
        type: 'bar',
        data: { labels: ['Principal', 'Interest'], datasets: [{ data: [100000, 69946], backgroundColor: ['#9ca3af', '#2563eb'], borderWidth:0, borderRadius:6, barPercentage:0.7 }] },
        options: {
            responsive:true, maintainAspectRatio:false, devicePixelRatio:2,
            plugins:{ legend:{display:false} },
            scales: {
                y:{ beginAtZero:true, ticks:{ callback:function(v){ return '₹'+Number(v).toLocaleString('en-IN'); } } },
                x:{ ticks:{ color:'#475569', font:{size:12} } }
            }
        }
    });

    // ── Lump-sum prepayment calculator ────────────────────
    document.getElementById('prepayCalcBtn').addEventListener('click', function() {
        var lumpSum      = parseFloat(document.getElementById('prepay_amount').value) || 0;
        var afterMonths  = parseInt(document.getElementById('prepay_after_months').value) || 12;
        var mode         = document.getElementById('prepay_mode').value;

        var P     = parseInt(amountSlider.value, 10);
        var rate  = parseFloat(rateSlider.value);
        var years = parseInt(tenureSlider.value, 10);
        var origMonths = years * 12;
        var r     = rate / 12 / 100;
        var emi   = calcEMI(P, rate, origMonths);

        if (lumpSum <= 0) { alert('Please enter a lump sum amount.'); return; }
        if (afterMonths >= origMonths) { alert('Prepayment month must be within the loan tenure.'); return; }

        // ── Without prepayment ───────────────────────────
        var origTotal    = emi * origMonths;
        var origInterest = origTotal - P;

        var payoffDate = new Date();
        payoffDate.setMonth(payoffDate.getMonth() + origMonths);
        var origClose = payoffDate.toLocaleString('en-IN', { month: 'short', year: 'numeric' });

        // ── Simulate up to prepayment month ─────────────
        var balance = P;
        var interestBeforePrepay = 0;
        for (var i = 0; i < afterMonths; i++) {
            var intCharge = balance * r;
            var prinCharge = emi - intCharge;
            if (prinCharge > balance) prinCharge = balance;
            balance -= prinCharge;
            interestBeforePrepay += intCharge;
        }

        // Apply lump sum (reduce from remaining principal, not total)
        balance = Math.max(0, balance - lumpSum);

        // ── Remaining schedule ───────────────────────────
        var newEMI, newRemainingMonths;
        if (mode === 'reduce_tenure') {
            newEMI = emi; // keep same EMI
            if (balance <= 0) {
                newRemainingMonths = 0;
            } else {
                // Calculate new remaining tenure
                newRemainingMonths = Math.ceil(-Math.log(1 - (balance * r) / newEMI) / Math.log(1 + r));
            }
        } else {
            // reduce_emi: keep same tenure, recalculate EMI
            var remainingMonths = origMonths - afterMonths;
            newRemainingMonths = remainingMonths;
            newEMI = balance <= 0 ? 0 : calcEMI(balance, rate, remainingMonths);
        }

        var newTotalMonths   = afterMonths + newRemainingMonths;
        var interestAfter    = 0;
        var bal2 = balance;
        for (var j = 0; j < newRemainingMonths; j++) {
            var ic = bal2 * r;
            var pc = newEMI - ic;
            if (pc > bal2) pc = bal2;
            bal2 -= pc;
            interestAfter += ic;
        }
        var newTotalInterest = interestBeforePrepay + interestAfter;
        var newTotal         = P + newTotalInterest; // effectively the total outflow

        var newPayoff = new Date();
        newPayoff.setMonth(newPayoff.getMonth() + newTotalMonths);
        var newClose = newPayoff.toLocaleString('en-IN', { month: 'short', year: 'numeric' });

        var interestSaved = origInterest - newTotalInterest;
        var monthsSaved   = origMonths - newTotalMonths;

        // ── Populate results ─────────────────────────────
        document.getElementById('pre_lump_label').textContent = fmtFull(lumpSum);
        document.getElementById('pre_orig_emis').textContent     = origMonths + ' months';
        document.getElementById('pre_orig_emi').textContent      = fmtFull(emi);
        document.getElementById('pre_orig_interest').textContent = fmtFull(origInterest);
        document.getElementById('pre_orig_total').textContent    = fmtFull(origTotal);
        document.getElementById('pre_orig_close').textContent    = origClose;

        document.getElementById('pre_new_emis').textContent      = newTotalMonths + ' months';
        document.getElementById('pre_new_emi').textContent       = fmtFull(newEMI);
        document.getElementById('pre_new_interest').textContent  = fmtFull(newTotalInterest);
        document.getElementById('pre_new_total').textContent     = fmtFull(newTotal);
        document.getElementById('pre_new_close').textContent     = newClose;

        document.getElementById('pre_interest_saved').textContent = fmtFull(interestSaved > 0 ? interestSaved : 0);
        document.getElementById('pre_months_saved').textContent   = monthsSaved > 0 ? monthsSaved + ' months' : '0';

        document.getElementById('prepayResult').style.display = 'block';

        // ── Prepayment comparison bar chart ──────────────
        if (prepayBarChart) prepayBarChart.destroy();
        prepayBarChart = new Chart(document.getElementById('prepayBarChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Without Prepayment', 'With Prepayment'],
                datasets: [
                    { label: 'Principal', data: [P, P], backgroundColor: '#9ca3af', borderRadius: 6 },
                    { label: 'Interest',  data: [origInterest, newTotalInterest], backgroundColor: '#2563eb', borderRadius: 6 }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false, devicePixelRatio: 2,
                plugins: { legend: { position: 'bottom' }, tooltip: { callbacks: {
                    label: function(ctx) { return ctx.dataset.label + ': ₹' + Number(ctx.raw).toLocaleString('en-IN'); }
                }}},
                scales: {
                    x: { stacked: true },
                    y: { stacked: true, beginAtZero: true, ticks: { callback: function(v){ return '₹'+Number(v).toLocaleString('en-IN'); } } }
                }
            }
        });
    });

    // ── Initial render ─────────────────────────────────────
    updateDisplays();
})();
</script>
@endpush
