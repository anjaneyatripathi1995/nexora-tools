<div class="tool-form-wrap">
    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#base64-encode" type="button">Encode</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#base64-decode" type="button">Decode</button></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="base64-encode">
            <div class="mb-3">
                <label for="base64_encode_in" class="form-label">Text to encode</label>
                <textarea class="form-control font-monospace" id="base64_encode_in" rows="4" placeholder="Enter text..."></textarea>
            </div>
            <button type="button" class="btn btn-primary mb-3" onclick="base64Encode()">Encode to Base64</button>
            <div class="mb-2">
                <label class="form-label text-body-secondary small">Result</label>
                <textarea class="form-control font-monospace small" id="base64_encode_out" rows="4" readonly></textarea>
            </div>
        </div>
        <div class="tab-pane fade" id="base64-decode">
            <div class="mb-3">
                <label for="base64_decode_in" class="form-label">Base64 string to decode</label>
                <textarea class="form-control font-monospace" id="base64_decode_in" rows="4" placeholder="Paste Base64..."></textarea>
            </div>
            <button type="button" class="btn btn-primary mb-3" onclick="base64Decode()">Decode</button>
            <div id="base64_decode_err" class="alert alert-danger d-none mb-2"></div>
            <div class="mb-2">
                <label class="form-label text-body-secondary small">Result</label>
                <textarea class="form-control font-monospace small" id="base64_decode_out" rows="4" readonly></textarea>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function base64Encode() {
    var t = document.getElementById('base64_encode_in').value;
    try {
        document.getElementById('base64_encode_out').value = btoa(unescape(encodeURIComponent(t)));
    } catch (e) {
        document.getElementById('base64_encode_out').value = 'Error: ' + e.message;
    }
}
function base64Decode() {
    var t = document.getElementById('base64_decode_in').value.replace(/\s/g,'');
    var err = document.getElementById('base64_decode_err');
    var out = document.getElementById('base64_decode_out');
    try {
        out.value = decodeURIComponent(escape(atob(t)));
        err.classList.add('d-none');
    } catch (e) {
        err.textContent = 'Invalid Base64: ' + e.message;
        err.classList.remove('d-none');
        out.value = '';
    }
}
</script>
@endpush
