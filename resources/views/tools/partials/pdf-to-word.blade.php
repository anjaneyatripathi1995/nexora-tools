@push('styles')
<style>
 .pdf-convert-hero { text-align: center; padding: 3.5rem 1rem; border-radius: 12px; background: #f7f7fb; }
 .pdf-select-btn { background: linear-gradient(135deg, #2563EB, #7C3AED); border-color: #2563EB; color: #fff; padding: 1.25rem 2.5rem; font-size: 1.25rem; border-radius: 12px; box-shadow: 0 6px 18px rgba(37,99,235,0.12); }
 .pdf-side-btn { width:48px; height:48px; border-radius:50%; background: linear-gradient(135deg, #2563EB, #7C3AED); color:#fff; display:inline-flex; align-items:center; justify-content:center; margin-left:.75rem }
</style>
@endpush

<div class="pdf-convert-hero mb-4">
    <h1 class="fw-bold display-5 mb-2">PDF to WORD Converter</h1>
    <p class="mb-3 text-muted">Convert your PDF to WORD documents with incredible accuracy.</p>
    <p class="small text-muted">Powered by a server-side conversion engine (LibreOffice, Tika, or cloud APIs).</p>
    <div id="pdf2w_status" class="alert alert-info d-none" role="alert" style="max-width:600px;margin:10px auto 0;"></div>

    <div class="d-flex justify-content-center align-items-center mt-4">
        <label class="pdf-select-btn" for="pdf2w_file_input">Select PDF file</label>
        <div class="d-inline-block">
            <button class="pdf-side-btn" title="Google Drive"><i class="fa-brands fa-google-drive"></i></button>
            <button class="pdf-side-btn" title="Dropbox"><i class="fa-brands fa-dropbox"></i></button>
        </div>
    </div>

    <form id="pdf2w_form" class="d-none">
        @csrf
        <input type="file" id="pdf2w_file_input" name="file" accept="application/pdf" style="display:none">
    </form>

    <div class="mt-3">
        <button type="button" class="btn btn-outline-secondary" id="pdf2w_drop_hint">or drop PDF here</button>
    </div>
</div>

<div class="mt-3 text-center d-none" id="pdf2w_download_wrap">
    <a id="pdf2w_download_link" class="btn btn-success" download>Download DOCX</a>
</div>

@push('scripts')
<script>
const pdf2wInput = document.getElementById('pdf2w_file_input');
const pdf2wStatus = document.getElementById('pdf2w_status');
const pdf2wDownload = document.getElementById('pdf2w_download_link');
const pdf2wDownloadWrap = document.getElementById('pdf2w_download_wrap');

function showPdf2wStatus(msg, type = 'info') {
    if (!pdf2wStatus) return;
    pdf2wStatus.classList.remove('d-none', 'alert-info', 'alert-warning', 'alert-success', 'alert-danger');
    pdf2wStatus.classList.add('alert-' + type);
    pdf2wStatus.textContent = msg;
}

pdf2wInput.addEventListener('change', function(){
    if (!this.files || this.files.length === 0) return;
    const file = this.files[0];
    showPdf2wStatus('Uploading ' + file.name + '...', 'info');
    pdf2wDownloadWrap.classList.add('d-none');

    const fd = new FormData();
    fd.append('file', file);
    fd.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

    fetch('{{ route('tools.process.pdf-to-word') }}', {
        method: 'POST',
        body: fd,
        headers: { 'Accept': 'application/json' }
    }).then(async res => {
        if (!res.ok) {
            // try to parse a JSON error body if present
            let txt = await res.text();
            let msg = txt;
            try {
                const j = JSON.parse(txt);
                if (j.error) msg = j.error;
            } catch (_) {}
            throw new Error('Server error ' + res.status + ': ' + msg);
        }

        const ct = res.headers.get('content-type') || '';
        const fallbackMsg = res.headers.get('x-fallback-warning');
        if (ct.includes('application/json')) {
            // normal JSON response (could include message or download_url)
            const data = await res.json();
            if (data.error) throw new Error(data.error);
            let msg = data.message || 'Converted successfully.';
            if (fallbackMsg) msg += '\n' + fallbackMsg;
            showPdf2wStatus(msg, fallbackMsg ? 'warning' : 'success');
            if (data.download_url) {
                pdf2wDownload.href = data.download_url;
                pdf2wDownloadWrap.classList.remove('d-none');
            }
        } else {
            // assume this is a binary file (the DOCX)
            const blob = await res.blob();
            let msg = 'Converted successfully.';
            if (fallbackMsg) msg += '\n' + fallbackMsg;
            showPdf2wStatus(msg, fallbackMsg ? 'warning' : 'success');
            const blobUrl = URL.createObjectURL(blob);
            pdf2wDownload.href = blobUrl;
            pdf2wDownload.download = 'converted.docx';
            pdf2wDownloadWrap.classList.remove('d-none');
        }
    }).catch(err => {
        console.error('pdf-to-word conversion error:', err);
        showPdf2wStatus(err.message, 'danger');
    });
});



document.getElementById('pdf2w_drop_hint').addEventListener('click', function(){
    showPdf2wStatus('Drag & drop support will be wired after the conversion backend is connected.', 'warning');
});
</script>
@endpush
