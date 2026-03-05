@include('tools.partials.calculator-shared-styles')

<div class="emi-calc-wrap">
    <div class="row g-4">
        {{-- Left: Inputs --}}
        <div class="col-lg-6">
            <h5 class="fw-bold mb-3">Date Converter & Info</h5>

            <div class="emi-slider-group">
                <label for="mtd_date_pick">Pick a date</label>
                <input type="date" class="form-control form-control-lg age-date-input" id="mtd_date_pick">
            </div>

            <div class="emi-slider-group mt-3">
                <label>Output format</label>
                <div class="d-flex flex-wrap gap-2 mt-2">
                    <button type="button" class="btn gst-rate-btn active" data-fmt="ddmmyyyy">DD/MM/YYYY</button>
                    <button type="button" class="btn gst-rate-btn" data-fmt="yyyymmdd">YYYY-MM-DD</button>
                    <button type="button" class="btn gst-rate-btn" data-fmt="full">Full text</button>
                    <button type="button" class="btn gst-rate-btn" data-fmt="iso">ISO 8601</button>
                    <button type="button" class="btn gst-rate-btn" data-fmt="us">US (MM/DD/YYYY)</button>
                </div>
            </div>

            <button type="button" class="btn btn-primary btn-lg w-100 mt-3" id="mtdConvertBtn">
                <i class="fa-solid fa-calendar-days me-2"></i>Convert & Analyse
            </button>
        </div>

        {{-- Right: Results --}}
        <div class="col-lg-6">
            <div id="mtdResultArea" style="display:none">
                {{-- Converted date hero --}}
                <div class="emi-summary-card" style="background:linear-gradient(135deg,#eff6ff,#f0fdf4); text-align:center; margin-bottom:1rem;">
                    <div class="label">Converted Date</div>
                    <div style="font-size:1.4rem; font-weight:800; color:#2563eb; word-break:break-all" id="mtd_converted_display">—</div>
                </div>
                <div id="mtdSummary">
                    <div class="emi-summary-card"><div class="label">Day of week</div><div class="value" id="mtd_dayofweek">—</div></div>
                    <div class="emi-summary-card"><div class="label">Day of year</div><div class="value" id="mtd_dayofyear">—</div></div>
                    <div class="emi-summary-card"><div class="label">Week number</div><div class="value" id="mtd_weeknum">—</div></div>
                    <div class="emi-summary-card"><div class="label">Quarter</div><div class="value" id="mtd_quarter">—</div></div>
                    <div class="emi-summary-card"><div class="label">Days in month</div><div class="value" id="mtd_daysinmonth">—</div></div>
                    <div class="emi-summary-card"><div class="label">Leap year</div><div class="value" id="mtd_leapyear">—</div></div>
                    <div class="emi-summary-card"><div class="label">Days from today</div><div class="value" id="mtd_fromtoday">—</div></div>
                    <div class="emi-summary-card"><div class="label">Unix timestamp</div><div class="value" id="mtd_unix">—</div></div>
                </div>
            </div>
            <div id="mtdPlaceholder" class="age-placeholder-box">
                <i class="fa-solid fa-calendar-days fa-3x mb-3" style="color:#cbd5e1"></i>
                <p class="text-muted">Pick a date and click <strong>Convert & Analyse</strong> to see detailed date information</p>
            </div>
        </div>
    </div>

    {{-- Month names reference --}}
    <hr class="my-4">
    <h5 class="fw-bold mb-3">Quick Date Facts</h5>
    <div class="row g-3">
        @php
        $monthFacts = [
            ['Jan','31 days','Q1','#2563eb'],['Feb','28/29 days','Q1','#7c3aed'],['Mar','31 days','Q1','#0891b2'],
            ['Apr','30 days','Q2','#059669'],['May','31 days','Q2','#d97706'],['Jun','30 days','Q2','#dc2626'],
            ['Jul','31 days','Q3','#2563eb'],['Aug','31 days','Q3','#7c3aed'],['Sep','30 days','Q3','#0891b2'],
            ['Oct','31 days','Q4','#059669'],['Nov','30 days','Q4','#d97706'],['Dec','31 days','Q4','#dc2626'],
        ];
        @endphp
        @foreach($monthFacts as $mf)
        <div class="col-6 col-sm-4 col-md-3 col-xl-2">
            <div class="gst-slab-card text-center" style="border-top: 3px solid {{ $mf[3] }}">
                <div class="gst-slab-rate" style="color:{{ $mf[3] }}; font-size:1.1rem">{{ $mf[0] }}</div>
                <div class="gst-slab-desc">{{ $mf[1] }}<br><span style="color:{{ $mf[3] }}">{{ $mf[2] }}</span></div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@push('styles')
<style>
.age-date-input { border:2px solid #e2e8f0; border-radius:10px; font-weight:500; color:#0f172a; padding:0.65rem 1rem; }
.age-date-input:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,0.12); outline:none; }
.gst-rate-btn { background:#f1f5f9; border:2px solid #e2e8f0; color:#374151; font-weight:600; padding:0.4rem 0.85rem; border-radius:8px; transition:all 0.2s; font-size:0.82rem; }
.gst-rate-btn.active { background:#2563eb; border-color:#2563eb; color:#fff; }
.age-placeholder-box { text-align:center; padding:2.5rem 1rem; color:#94a3b8; }
.gst-slab-card { background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:0.85rem 1rem; }
.gst-slab-rate { font-size:1.1rem; font-weight:800; margin-bottom:0.2rem; }
.gst-slab-desc { font-size:0.78rem; color:#64748b; line-height:1.4; }
#mtdSummary { display:flex; flex-wrap:wrap; gap:0.75rem; }
#mtdSummary .emi-summary-card { flex:1 1 40%; min-width:8rem; }
</style>
@endpush

@push('scripts')
<script>
(function(){
    var dateInput  = document.getElementById('mtd_date_pick');
    var convertBtn = document.getElementById('mtdConvertBtn');
    var resultArea = document.getElementById('mtdResultArea');
    var placeholder= document.getElementById('mtdPlaceholder');
    var fmtBtns    = document.querySelectorAll('[data-fmt]');
    var currentFmt = 'ddmmyyyy';

    // Default to today
    dateInput.value = new Date().toISOString().slice(0,10);

    fmtBtns.forEach(function(btn){
        btn.addEventListener('click', function(){
            fmtBtns.forEach(function(b){ b.classList.remove('active'); });
            this.classList.add('active');
            currentFmt = this.getAttribute('data-fmt');
        });
    });

    var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    var days   = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

    function getWeekNum(d){
        var onejan = new Date(d.getFullYear(),0,1);
        return Math.ceil((((d - onejan) / 86400000) + onejan.getDay() + 1) / 7);
    }
    function getDayOfYear(d){
        return Math.floor((d - new Date(d.getFullYear(),0,0)) / 86400000);
    }
    function isLeap(y){ return (y%4===0 && y%100!==0) || y%400===0; }

    function formatDate(d, fmt){
        var dd = String(d.getDate()).padStart(2,'0');
        var mm = String(d.getMonth()+1).padStart(2,'0');
        var yyyy = d.getFullYear();
        if(fmt==='ddmmyyyy') return dd+'/'+mm+'/'+yyyy;
        if(fmt==='yyyymmdd') return yyyy+'-'+mm+'-'+dd;
        if(fmt==='full') return d.getDate()+' '+months[d.getMonth()]+' '+yyyy;
        if(fmt==='iso')  return d.toISOString().slice(0,10);
        if(fmt==='us')   return mm+'/'+dd+'/'+yyyy;
        return dd+'/'+mm+'/'+yyyy;
    }

    convertBtn.addEventListener('click', function(){
        if(!dateInput.value){ alert('Please pick a date.'); return; }
        var d = new Date(dateInput.value + 'T00:00:00');
        var today = new Date(); today.setHours(0,0,0,0);
        var diffDays = Math.round((d - today) / 86400000);
        var fromTodayStr = diffDays === 0 ? 'Today' : (diffDays > 0 ? '+'+diffDays+' days ahead' : Math.abs(diffDays)+' days ago');
        var quarter = 'Q' + Math.ceil((d.getMonth()+1)/3);
        var daysInMonth = new Date(d.getFullYear(), d.getMonth()+1, 0).getDate();

        document.getElementById('mtd_converted_display').textContent = formatDate(d, currentFmt);
        document.getElementById('mtd_dayofweek').textContent  = days[d.getDay()];
        document.getElementById('mtd_dayofyear').textContent  = 'Day ' + getDayOfYear(d);
        document.getElementById('mtd_weeknum').textContent    = 'Week ' + getWeekNum(d);
        document.getElementById('mtd_quarter').textContent    = quarter + ' (' + months[Math.floor(d.getMonth()/3)*3].slice(0,3) + ' – ' + months[Math.floor(d.getMonth()/3)*3+2].slice(0,3) + ')';
        document.getElementById('mtd_daysinmonth').textContent= daysInMonth + ' days';
        document.getElementById('mtd_leapyear').textContent   = isLeap(d.getFullYear()) ? '✅ Yes' : '❌ No';
        document.getElementById('mtd_fromtoday').textContent  = fromTodayStr;
        document.getElementById('mtd_unix').textContent       = Math.floor(d.getTime()/1000).toLocaleString('en-IN');

        placeholder.style.display  = 'none';
        resultArea.style.display   = 'block';
    });
})();
</script>
@endpush
