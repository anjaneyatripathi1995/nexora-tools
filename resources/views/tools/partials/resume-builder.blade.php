<div class="tool-form-wrap">
    <div class="mb-4">
        <h5 class="fw-bold mb-3">Personal</h5>
        <div class="row g-2">
            <div class="col-md-6"><input type="text" class="form-control" id="res_name" placeholder="Full name"></div>
            <div class="col-md-6"><input type="email" class="form-control" id="res_email" placeholder="Email"></div>
            <div class="col-12"><input type="text" class="form-control" id="res_phone" placeholder="Phone"></div>
            <div class="col-12">
                <label class="form-label small">Professional summary</label>
                <textarea class="form-control" id="res_summary" rows="3" placeholder="Brief summary of your experience and goals"></textarea>
            </div>
        </div>
    </div>
    <div class="mb-4">
        <h5 class="fw-bold mb-3">Experience</h5>
        <div id="res_exp_list">
            <div class="res-exp-item border rounded p-3 mb-3">
                <input type="text" class="form-control mb-2" placeholder="Job title">
                <input type="text" class="form-control mb-2" placeholder="Company">
                <input type="text" class="form-control mb-2" placeholder="From - To (e.g. 2020 - Present)">
                <textarea class="form-control small" rows="2" placeholder="Key points"></textarea>
            </div>
        </div>
        <button type="button" class="btn btn-outline-primary btn-sm" id="res_add_exp">+ Add experience</button>
    </div>
    <div class="mb-4">
        <h5 class="fw-bold mb-3">Education</h5>
        <input type="text" class="form-control mb-2" id="res_edu_school" placeholder="School / University">
        <input type="text" class="form-control mb-2" id="res_edu_degree" placeholder="Degree">
        <input type="text" class="form-control" id="res_edu_year" placeholder="Year">
    </div>
    <div class="mb-4">
        <label class="form-label fw-bold">Skills (comma-separated)</label>
        <input type="text" class="form-control" id="res_skills" placeholder="e.g. PHP, Laravel, JavaScript, MySQL">
    </div>
    <button type="button" class="btn btn-primary btn-lg mb-3" id="res_generate">
        <i class="fa-solid fa-id-card me-2"></i>Generate Resume
    </button>
    <div id="res_preview_wrap" class="d-none border rounded p-4 bg-light">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <strong>Preview</strong>
            <div>
                <button type="button" class="btn btn-sm btn-outline-primary me-1" id="res_print">Print</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="res_copy">Copy HTML</button>
            </div>
        </div>
        <div id="res_preview" class="bg-white p-4 rounded shadow-sm"></div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('res_add_exp').addEventListener('click', function() {
    var html = '<div class="res-exp-item border rounded p-3 mb-3">' +
        '<input type="text" class="form-control mb-2" placeholder="Job title">' +
        '<input type="text" class="form-control mb-2" placeholder="Company">' +
        '<input type="text" class="form-control mb-2" placeholder="From - To">' +
        '<textarea class="form-control small" rows="2" placeholder="Key points"></textarea></div>';
    document.getElementById('res_exp_list').insertAdjacentHTML('beforeend', html);
});
function getExp() {
    var items = document.querySelectorAll('.res-exp-item');
    var arr = [];
    items.forEach(function(el) {
        var inps = el.querySelectorAll('input, textarea');
        if (inps.length >= 4) arr.push({
            title: inps[0].value, company: inps[1].value, period: inps[2].value, points: inps[3].value
        });
    });
    return arr;
}
document.getElementById('res_generate').addEventListener('click', function() {
    var name = document.getElementById('res_name').value.trim();
    var email = document.getElementById('res_email').value.trim();
    var phone = document.getElementById('res_phone').value.trim();
    var summary = document.getElementById('res_summary').value.trim();
    var exp = getExp();
    var school = document.getElementById('res_edu_school').value.trim();
    var degree = document.getElementById('res_edu_degree').value.trim();
    var year = document.getElementById('res_edu_year').value.trim();
    var skills = document.getElementById('res_skills').value.trim();
    var html = '<div style="font-family:Georgia,serif; max-width: 700px;">';
    html += '<h1 style="margin:0 0 4px 0; font-size:1.75rem;">' + (name || 'Your Name') + '</h1>';
    html += '<p style="margin:0 0 16px 0; color:#555;">' + [email, phone].filter(Boolean).join(' &nbsp;|&nbsp; ') + '</p>';
    if (summary) html += '<h3 style="font-size:1rem; margin:16px 0 8px 0;">Summary</h3><p style="margin:0 0 16px 0;">' + summary.replace(/\n/g, '<br>') + '</p>';
    if (exp.length) {
        html += '<h3 style="font-size:1rem; margin:16px 0 8px 0;">Experience</h3>';
        exp.forEach(function(e) {
            if (!e.title && !e.company) return;
            html += '<p style="margin:0 0 4px 0;"><strong>' + (e.title || '') + '</strong> &nbsp; ' + (e.company || '') + ' &nbsp; <em>' + (e.period || '') + '</em></p>';
            if (e.points) html += '<p style="margin:0 0 12px 0; font-size:0.9rem;">' + e.points.replace(/\n/g, '<br>') + '</p>';
        });
    }
    if (school || degree) {
        html += '<h3 style="font-size:1rem; margin:16px 0 8px 0;">Education</h3>';
        html += '<p style="margin:0 0 16px 0;">' + [degree, school, year].filter(Boolean).join(', ') + '</p>';
    }
    if (skills) html += '<h3 style="font-size:1rem; margin:16px 0 8px 0;">Skills</h3><p style="margin:0;">' + skills + '</p>';
    html += '</div>';
    document.getElementById('res_preview').innerHTML = html;
    document.getElementById('res_preview_wrap').classList.remove('d-none');
    document.getElementById('res_preview_wrap').dataset.html = html;
});
document.getElementById('res_print').addEventListener('click', function() {
    var w = window.open('', '_blank');
    w.document.write(document.getElementById('res_preview').innerHTML);
    w.document.close();
    w.print();
    w.close();
});
document.getElementById('res_copy').addEventListener('click', function() {
    var html = document.getElementById('res_preview_wrap').dataset.html || document.getElementById('res_preview').innerHTML;
    navigator.clipboard.writeText(html).then(function() { alert('HTML copied to clipboard'); });
});
</script>
@endpush
