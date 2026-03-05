@include('tools.partials.calculator-shared-styles')

<div class="emi-calc-wrap">
    <div class="row g-4">
        {{-- Left: Inputs --}}
        <div class="col-lg-6">
            <h5 class="fw-bold mb-3">Enter Date Details</h5>

            <div class="emi-slider-group">
                <label for="age_dob">Date of Birth</label>
                <input type="date" class="form-control form-control-lg age-date-input" id="age_dob">
            </div>

            <div class="emi-slider-group">
                <label for="age_as_on">Calculate Age as on</label>
                <input type="date" class="form-control form-control-lg age-date-input" id="age_as_on">
                <div class="d-flex gap-2 mt-2 flex-wrap">
                    <button type="button" class="btn age-quick-btn" id="ageToday">Today</button>
                    <button type="button" class="btn age-quick-btn" id="ageNewYear">New Year 2026</button>
                    <button type="button" class="btn age-quick-btn" id="ageBday">My Birthday 2026</button>
                </div>
            </div>

            <button type="button" class="btn btn-primary btn-lg w-100 mt-2" id="ageCalcBtn">
                <i class="fa-solid fa-birthday-cake me-2"></i>Calculate Age
            </button>
        </div>

        {{-- Right: Results --}}
        <div class="col-lg-6">
            <div id="ageResultArea" style="display:none">
                <div class="age-progress-wrap mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <small class="text-muted">Year progress</small>
                        <small class="fw-semibold" id="ageYearPct">0%</small>
                    </div>
                    <div class="age-progress-bar-track">
                        <div class="age-progress-bar-fill" id="ageYearBar" style="width:0%"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <small class="text-muted" id="ageBirthdayLabel">Last birthday</small>
                        <small class="text-muted" id="ageNextBirthdayLabel">Next birthday</small>
                    </div>
                </div>

                <div id="ageSummary" class="mt-3">
                    <div class="emi-summary-card age-hero-card">
                        <div class="label">Your Age</div>
                        <div class="age-hero-value" id="ageHeroDisplay">—</div>
                    </div>
                    <div class="emi-summary-card">
                        <div class="label">Total months</div>
                        <div class="value" id="ageTotalMonths">—</div>
                    </div>
                    <div class="emi-summary-card">
                        <div class="label">Total weeks</div>
                        <div class="value" id="ageTotalWeeks">—</div>
                    </div>
                    <div class="emi-summary-card">
                        <div class="label">Total days</div>
                        <div class="value" id="ageTotalDays">—</div>
                    </div>
                    <div class="emi-summary-card">
                        <div class="label">Total hours</div>
                        <div class="value" id="ageTotalHours">—</div>
                    </div>
                    <div class="emi-summary-card">
                        <div class="label">Next birthday in</div>
                        <div class="value" id="ageNextBday">—</div>
                    </div>
                </div>
            </div>
            <div id="agePlaceholder" class="age-placeholder-box">
                <i class="fa-solid fa-cake-candles fa-3x mb-3" style="color:#cbd5e1"></i>
                <p class="text-muted">Enter your date of birth and hit <strong>Calculate Age</strong></p>
            </div>
        </div>
    </div>

    {{-- Zodiac & Day-of-week info (shown after calc) --}}
    <div id="ageExtraInfo" class="mt-4" style="display:none">
        <hr class="mb-4">
        <h5 class="fw-bold mb-3">About Your Birth Date</h5>
        <div class="row g-3">
            <div class="col-sm-6 col-lg-3">
                <div class="gst-slab-card text-center">
                    <div class="gst-slab-rate" id="ageDayOfWeek" style="color:#2563eb">—</div>
                    <div class="gst-slab-desc">Day of the week you were born</div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="gst-slab-card text-center">
                    <div class="gst-slab-rate" id="ageZodiac" style="color:#7c3aed">—</div>
                    <div class="gst-slab-desc">Zodiac sign</div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="gst-slab-card text-center">
                    <div class="gst-slab-rate" id="ageSeason" style="color:#0891b2">—</div>
                    <div class="gst-slab-desc">Birth season (Northern Hemisphere)</div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="gst-slab-card text-center">
                    <div class="gst-slab-rate" id="ageDayOfYear" style="color:#059669">—</div>
                    <div class="gst-slab-desc">Day of the year</div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.age-date-input {
    border: 2px solid #e2e8f0; border-radius: 10px; font-weight: 500;
    color: #0f172a; padding: 0.65rem 1rem;
}
.age-date-input:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.12); outline: none; }
.age-quick-btn {
    background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 20px;
    font-size: 0.8rem; padding: 0.3rem 0.85rem; color: #475569;
    transition: all 0.18s;
}
.age-quick-btn:hover { background: #dbeafe; border-color: #93c5fd; color: #1e40af; }
.age-progress-wrap { background: #f8fafc; border-radius: 12px; padding: 1rem 1.25rem; }
.age-progress-bar-track { height: 10px; background: #e2e8f0; border-radius: 5px; overflow: hidden; }
.age-progress-bar-fill { height: 100%; background: linear-gradient(to right, #2563eb, #7c3aed); border-radius: 5px; transition: width 0.6s ease; }
#ageSummary { display: flex; flex-wrap: wrap; gap: 0.75rem; }
.age-hero-card { flex: 1 1 100% !important; text-align: center; background: linear-gradient(135deg, #eff6ff, #f0fdf4); }
.age-hero-value { font-size: 1.5rem; font-weight: 800; color: #2563eb; }
.age-placeholder-box { text-align: center; padding: 2.5rem 1rem; color: #94a3b8; }
.gst-slab-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 1rem 1.25rem; }
.gst-slab-rate { font-size: 1.3rem; font-weight: 800; margin-bottom: 0.3rem; }
.gst-slab-desc { font-size: 0.82rem; color: #64748b; line-height: 1.4; }
</style>
@endpush

@push('scripts')
<script>
(function(){
    var dobInput   = document.getElementById('age_dob');
    var asOnInput  = document.getElementById('age_as_on');
    var calcBtn    = document.getElementById('ageCalcBtn');
    var resultArea = document.getElementById('ageResultArea');
    var placeholder= document.getElementById('agePlaceholder');
    var extraInfo  = document.getElementById('ageExtraInfo');

    // Set today as default "as on" date
    var todayStr = new Date().toISOString().slice(0,10);
    asOnInput.value = todayStr;

    document.getElementById('ageToday').addEventListener('click', function(){ asOnInput.value = new Date().toISOString().slice(0,10); });
    document.getElementById('ageNewYear').addEventListener('click', function(){ asOnInput.value = '2026-01-01'; });
    document.getElementById('ageBday').addEventListener('click', function(){
        if(!dobInput.value) return;
        var d = new Date(dobInput.value);
        asOnInput.value = '2026-' + String(d.getMonth()+1).padStart(2,'0') + '-' + String(d.getDate()).padStart(2,'0');
    });

    var days  = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    var zodiacs = [
        {sign:'Capricorn',from:[1,1],to:[1,19]},{sign:'Aquarius',from:[1,20],to:[2,18]},{sign:'Pisces',from:[2,19],to:[3,20]},
        {sign:'Aries',from:[3,21],to:[4,19]},{sign:'Taurus',from:[4,20],to:[5,20]},{sign:'Gemini',from:[5,21],to:[6,20]},
        {sign:'Cancer',from:[6,21],to:[7,22]},{sign:'Leo',from:[7,23],to:[8,22]},{sign:'Virgo',from:[8,23],to:[9,22]},
        {sign:'Libra',from:[9,23],to:[10,22]},{sign:'Scorpio',from:[10,23],to:[11,21]},{sign:'Sagittarius',from:[11,22],to:[12,21]},{sign:'Capricorn',from:[12,22],to:[12,31]}
    ];

    function getZodiac(month, day){
        for(var i=0;i<zodiacs.length;i++){
            var z = zodiacs[i];
            if((month === z.from[0] && day >= z.from[1]) || (month === z.to[0] && day <= z.to[1])) return z.sign;
        }
        return '—';
    }
    function getSeason(month){
        if(month >= 3 && month <= 5) return 'Spring 🌸';
        if(month >= 6 && month <= 8) return 'Summer ☀️';
        if(month >= 9 && month <= 11) return 'Autumn 🍂';
        return 'Winter ❄️';
    }
    function getDayOfYear(d){
        var start = new Date(d.getFullYear(), 0, 0);
        var diff = d - start;
        return Math.floor(diff / 86400000);
    }

    calcBtn.addEventListener('click', function(){
        if(!dobInput.value){ alert('Please enter your date of birth.'); return; }
        var dob   = new Date(dobInput.value);
        var asOn  = asOnInput.value ? new Date(asOnInput.value) : new Date();
        if(dob > asOn){ alert('Date of birth cannot be after the "As on" date.'); return; }

        var years = asOn.getFullYear() - dob.getFullYear();
        var months = asOn.getMonth() - dob.getMonth();
        var daysRem = asOn.getDate() - dob.getDate();
        if(daysRem < 0){ months--; daysRem += new Date(asOn.getFullYear(), asOn.getMonth(), 0).getDate(); }
        if(months < 0){ years--; months += 12; }

        var totalDays  = Math.floor((asOn - dob) / 86400000);
        var totalMonths= years * 12 + months;
        var totalWeeks = Math.floor(totalDays / 7);
        var totalHours = totalDays * 24;

        // Next birthday
        var nextBday = new Date(asOn.getFullYear(), dob.getMonth(), dob.getDate());
        if(nextBday <= asOn) nextBday.setFullYear(nextBday.getFullYear() + 1);
        var daysToNext = Math.ceil((nextBday - asOn) / 86400000);

        // Year progress between last & next birthday
        var lastBday = new Date(nextBday); lastBday.setFullYear(lastBday.getFullYear() - 1);
        var yearSpan = nextBday - lastBday;
        var elapsed  = asOn - lastBday;
        var pct = Math.min(100, Math.round(elapsed / yearSpan * 100));

        // Update displays
        document.getElementById('ageHeroDisplay').textContent = years + ' yrs, ' + months + ' mos, ' + daysRem + ' days';
        document.getElementById('ageTotalMonths').textContent = totalMonths.toLocaleString('en-IN');
        document.getElementById('ageTotalWeeks').textContent  = totalWeeks.toLocaleString('en-IN');
        document.getElementById('ageTotalDays').textContent   = totalDays.toLocaleString('en-IN');
        document.getElementById('ageTotalHours').textContent  = totalHours.toLocaleString('en-IN');
        document.getElementById('ageNextBday').textContent    = daysToNext + ' days';

        document.getElementById('ageYearPct').textContent     = pct + '%';
        document.getElementById('ageYearBar').style.width     = pct + '%';
        document.getElementById('ageBirthdayLabel').textContent    = 'Birthday ' + lastBday.getFullYear();
        document.getElementById('ageNextBirthdayLabel').textContent = 'Birthday ' + nextBday.getFullYear();

        // Extra info
        document.getElementById('ageDayOfWeek').textContent = days[dob.getDay()];
        document.getElementById('ageZodiac').textContent    = getZodiac(dob.getMonth()+1, dob.getDate());
        document.getElementById('ageSeason').textContent    = getSeason(dob.getMonth()+1);
        document.getElementById('ageDayOfYear').textContent = 'Day ' + getDayOfYear(dob);

        placeholder.style.display = 'none';
        resultArea.style.display  = 'block';
        extraInfo.style.display   = 'block';
    });
})();
</script>
@endpush
