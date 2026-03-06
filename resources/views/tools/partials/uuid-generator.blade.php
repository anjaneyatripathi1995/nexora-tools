<div class="tool-form-wrap">
    <div class="mb-3">
        <label class="form-label">Generate UUID v4</label>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <button type="button" class="btn btn-primary" id="uuid-one">Generate one</button>
            <button type="button" class="btn btn-outline-secondary" id="uuid-bulk">Generate 5</button>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label text-body-secondary small">Result</label>
        <textarea class="form-control font-monospace" id="uuid-output" rows="4" readonly placeholder="UUIDs will appear here"></textarea>
    </div>
    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="document.getElementById('uuid-output').select(); document.execCommand('copy');">Copy</button>
</div>

@push('scripts')
<script>
function uuidv4() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}
document.getElementById('uuid-one').addEventListener('click', function() {
    document.getElementById('uuid-output').value = uuidv4();
});
document.getElementById('uuid-bulk').addEventListener('click', function() {
    document.getElementById('uuid-output').value = Array.from({length: 5}, uuidv4).join('\n');
});
</script>
@endpush
