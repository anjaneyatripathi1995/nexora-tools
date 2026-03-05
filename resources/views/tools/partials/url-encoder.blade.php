<div class="tool-form-wrap">
    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#url-encode" type="button">Encode</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#url-decode" type="button">Decode</button></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="url-encode">
            <div class="mb-3">
                <label for="url_encode_in" class="form-label">Text to encode</label>
                <textarea class="form-control font-monospace" id="url_encode_in" rows="4" placeholder="Enter text or URL..."></textarea>
            </div>
            <button type="button" class="btn btn-primary mb-3" onclick="urlEncode()">Encode URL</button>
            <div class="mb-2">
                <label class="form-label text-body-secondary small">Result</label>
                <textarea class="form-control font-monospace small" id="url_encode_out" rows="4" readonly></textarea>
            </div>
        </div>
        <div class="tab-pane fade" id="url-decode">
            <div class="mb-3">
                <label for="url_decode_in" class="form-label">Encoded URL / text to decode</label>
                <textarea class="form-control font-monospace" id="url_decode_in" rows="4" placeholder="Paste encoded URL..."></textarea>
            </div>
            <button type="button" class="btn btn-primary mb-3" onclick="urlDecode()">Decode</button>
            <div class="mb-2">
                <label class="form-label text-body-secondary small">Result</label>
                <textarea class="form-control font-monospace small" id="url_decode_out" rows="4" readonly></textarea>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function urlEncode() {
    document.getElementById('url_encode_out').value = encodeURIComponent(document.getElementById('url_encode_in').value);
}
function urlDecode() {
    try {
        document.getElementById('url_decode_out').value = decodeURIComponent(document.getElementById('url_decode_in').value.replace(/\+/g,' '));
    } catch (e) {
        document.getElementById('url_decode_out').value = 'Error: ' + e.message;
    }
}
</script>
@endpush
