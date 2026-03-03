<div class="tool-form-wrap">
    <div class="mb-3">
        <label for="el_type" class="form-label">Type</label>
        <select class="form-select" id="el_type">
            <option value="formal">Formal Letter</option>
            <option value="informal">Informal Letter</option>
            <option value="essay">Short Essay</option>
        </select>
    </div>
    <div id="el_fields_formal" class="el-fields">
        <div class="mb-2"><input type="text" class="form-control" id="el_to" placeholder="Recipient (e.g. The Manager)"></div>
        <div class="mb-2"><input type="text" class="form-control" id="el_subject" placeholder="Subject"></div>
        <div class="mb-2"><textarea class="form-control" id="el_body" rows="4" placeholder="Main points (one per line)"></textarea></div>
    </div>
    <div id="el_fields_essay" class="el-fields d-none">
        <div class="mb-2"><input type="text" class="form-control" id="el_topic" placeholder="Essay topic"></div>
        <div class="mb-2"><textarea class="form-control" id="el_points" rows="4" placeholder="Key points (one per line)"></textarea></div>
    </div>
    <button type="button" class="btn btn-primary mb-3" id="el_generate">
        <i class="fa-solid fa-envelope-open-text me-2"></i>Generate
    </button>
    <div class="mb-2">
        <label class="form-label text-body-secondary small">Output</label>
        <textarea class="form-control" id="el_output" rows="12" readonly placeholder="Generated content"></textarea>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('el_type').addEventListener('change', function() {
    var v = this.value;
    document.getElementById('el_fields_formal').classList.toggle('d-none', v !== 'formal' && v !== 'informal');
    document.getElementById('el_fields_essay').classList.toggle('d-none', v !== 'essay');
});
document.getElementById('el_generate').addEventListener('click', function() {
    var type = document.getElementById('el_type').value;
    var out = '';
    if (type === 'formal' || type === 'informal') {
        var to = document.getElementById('el_to').value.trim() || 'Recipient';
        var subj = document.getElementById('el_subject').value.trim() || 'Subject';
        var bodyLines = document.getElementById('el_body').value.trim().split(/\n/).filter(Boolean);
        var date = new Date().toLocaleDateString('en-IN', { day: 'numeric', month: 'long', year: 'numeric' });
        out = 'Date: ' + date + '\n\n';
        out += 'To,\n' + to + '\n\n';
        out += 'Subject: ' + subj + '\n\n';
        out += 'Dear Sir/Madam,\n\n';
        out += bodyLines.map(function(p, i) { return (i + 1) + '. ' + p; }).join('\n\n');
        out += '\n\nThanking you,\nYours faithfully,\n[Your name]';
    } else {
        var topic = document.getElementById('el_topic').value.trim() || 'Topic';
        var points = document.getElementById('el_points').value.trim().split(/\n/).filter(Boolean);
        out = topic + '\n\n';
        out += 'Introduction\n' + (points[0] || 'Introduce the topic.') + '\n\n';
        out += 'Main points\n' + points.slice(1, 4).map(function(p, i) { return (i + 1) + '. ' + p; }).join('\n') + '\n\n';
        out += 'Conclusion\n' + (points[points.length - 1] || 'Summarise and conclude.');
    }
    document.getElementById('el_output').value = out;
});
</script>
@endpush
