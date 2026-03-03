<div class="tool-form-wrap">
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label for="qr_text" class="form-label">Text or URL</label>
            <textarea class="form-control" id="qr_text" rows="3" placeholder="Enter text or URL to encode in QR code"></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">QR Code</label>
            <div class="border rounded d-flex align-items-center justify-content-center bg-white" id="qr_preview" style="min-height: 180px;">
                <span class="text-body-secondary">Preview appears here</span>
            </div>
        </div>
        <div class="col-12">
            <button type="button" class="btn btn-primary" onclick="generateQR()">Generate QR Code</button>
        </div>
    </div>
    <p class="small text-body-secondary">Uses Google Charts API for QR image. For production, use a server-side library.</p>
</div>

@push('scripts')
<script>
function generateQR() {
    var t = document.getElementById('qr_text').value.trim();
    var el = document.getElementById('qr_preview');
    if (!t) {
        el.innerHTML = '<span class="text-body-secondary">Enter text first</span>';
        return;
    }
    var url = 'https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=' + encodeURIComponent(t);
    el.innerHTML = '<img src="' + url + '" alt="QR Code" width="200" height="200">';
}
</script>
@endpush
