<div class="tool-form-wrap">
    <div class="mb-3">
        <label for="bg_file" class="form-label">Select image (PNG, JPG, max 10MB)</label>
        <div class="fancy-upload">
            <input type="file" id="bg_file" accept="image/png,image/jpeg,image/jpg,image/webp" class="d-none">
            <label for="bg_file" class="fancy-upload__btn">
                <i class="fa-solid fa-cloud-arrow-up me-2"></i>Select image
            </label>
            <div class="fancy-upload__hint">or drop it here</div>
        </div>
    </div>
    <button type="button" class="btn btn-primary mb-3" id="bg_btn" disabled>
        <i class="fa-solid fa-eraser me-2"></i>Remove Background
    </button>
    <div id="bg_message" class="alert d-none" role="alert"></div>
    <div id="bg_preview_wrap" class="mb-3 d-none">
        <label class="form-label text-body-secondary small">Result (no background)</label>
        <div class="border rounded p-2 bg-light">
            <img id="bg_preview" alt="No background" style="max-width: 100%; max-height: 400px;">
        </div>
        <p class="small text-body-secondary mb-0 mt-2"><a id="bg_download" href="#" download="no-bg.png">Download image</a></p>
    </div>
    <p class="small text-body-secondary mt-2">Uses the remove.bg API. To enable, add <code>REMOVEBG_API_KEY</code> to your .env (free tier at <a href="https://www.remove.bg/api" target="_blank" rel="noopener">remove.bg</a>).</p>
</div>

@push('scripts')
<script>
(function() {
    var fileIn = document.getElementById('bg_file');
    var btn = document.getElementById('bg_btn');
    var messageEl = document.getElementById('bg_message');
    var previewWrap = document.getElementById('bg_preview_wrap');
    var preview = document.getElementById('bg_preview');
    var downloadLink = document.getElementById('bg_download');
    var processUrl = '{{ route("tools.process.background-remover") }}';
    var token = '{{ csrf_token() }}';

    fileIn.addEventListener('change', function() {
        btn.disabled = !this.files.length;
        messageEl.classList.add('d-none');
        previewWrap.classList.add('d-none');
    });

    btn.addEventListener('click', function() {
        if (!fileIn.files.length) return;
        var form = new FormData();
        form.append('_token', token);
        form.append('image', fileIn.files[0]);
        btn.disabled = true;
        messageEl.classList.add('d-none');
        messageEl.classList.remove('alert-danger', 'alert-success');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';

        fetch(processUrl, { method: 'POST', body: form })
            .then(function(res) {
                if (res.ok) return res.blob().then(function(blob) { return { ok: true, blob: blob }; });
                return res.json().then(function(data) { return { ok: false, error: data.error || res.statusText }; });
            })
            .then(function(result) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-eraser me-2"></i>Remove Background';
                if (result.ok) {
                    var url = URL.createObjectURL(result.blob);
                    preview.src = url;
                    downloadLink.href = url;
                    downloadLink.download = 'no-bg.png';
                    previewWrap.classList.remove('d-none');
                    messageEl.classList.add('d-none');
                } else {
                    messageEl.textContent = result.error || 'Background removal failed.';
                    messageEl.classList.add('alert-danger');
                    messageEl.classList.remove('d-none');
                    previewWrap.classList.add('d-none');
                }
            })
            .catch(function(err) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-eraser me-2"></i>Remove Background';
                messageEl.textContent = 'Network error: ' + err.message;
                messageEl.classList.add('alert-danger');
                messageEl.classList.remove('d-none');
            });
    });
})();
</script>
@endpush
