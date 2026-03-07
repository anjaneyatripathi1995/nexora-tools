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
    <div style="background:var(--bg-elevated);border:1.5px solid var(--border);border-radius:10px;padding:16px;margin-top:20px;font-size:0.95rem;line-height:1.6;color:var(--text)">
        <details style="cursor:pointer">
            <summary style="font-weight:600;color:var(--text-1);user-select:none">
                <i class="fa-solid fa-circle-info me-2"></i>What This Tool Does
            </summary>
            <div style="margin-top:12px;display:flex;flex-direction:column;gap:8px">
                <div><strong>UUID Generation:</strong> Creates version 4 (random) UUIDs that are 128-bit identifiers designed to be unique across space and time. Each UUID consists of 32 hexadecimal digits displayed in 5 groups separated by hyphens.</div>
                <div><strong>Structure:</strong> Format is 8-4-4-4-12 characters (xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx) where each 'x' is a hexadecimal digit (0-9, a-f).</div>
                <div><strong>Uniqueness:</strong> Uses cryptographically strong random values to ensure extremely low probability of collisions. Suitable for database primary keys, distributed systems, and unique identifiers.</div>
                <div><strong>Version 4:</strong> Random UUID variant - most commonly used type that doesn't rely on timestamps or MAC addresses, making it ideal for web applications and privacy-conscious systems.</div>
            </div>
        </details>
    </div>
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
