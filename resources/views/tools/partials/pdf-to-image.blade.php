@push('styles')
<style>
 .pdf-convert-hero { text-align: center; padding: 3.5rem 1rem; border-radius: 12px; background: #f7f7fb; }
 .pdf-select-btn { background: linear-gradient(135deg, #2563EB, #7C3AED); border-color: #2563EB; color: #fff; padding: 1.25rem 2.5rem; font-size: 1.25rem; border-radius: 12px; box-shadow: 0 6px 18px rgba(37,99,235,0.12); }
 .pdf-side-btn { width:48px; height:48px; border-radius:50%; background: linear-gradient(135deg, #2563EB, #7C3AED); color:#fff; display:inline-flex; align-items:center; justify-content:center; margin-left:.75rem }
</style>
@endpush

<div class="pdf-convert-hero mb-4">
    <h1 class="fw-bold display-5 mb-2">PDF to IMAGE Converter</h1>
    <p class="mb-3 text-muted">Extract images from your PDF or convert each page to images.</p>
    <p class="small text-muted">Powered by server-side PDF processing tools.</p>
    <div id="pdf2img_status" class="alert alert-info d-none" role="alert" style="max-width:600px;margin:10px auto 0;">
        Select a PDF to begin. Conversion backend will be wired next.
    </div>

    <div class="d-flex justify-content-center align-items-center mt-4">
        <label class="pdf-select-btn" for="pdf2img_file">Select PDF file</label>
        <div class="d-inline-block">
            <button class="pdf-side-btn" title="Google Drive"><i class="fa-brands fa-google-drive"></i></button>
            <button class="pdf-side-btn" title="Dropbox"><i class="fa-brands fa-dropbox"></i></button>
        </div>
    </div>

    <form id="pdf2img_form" class="d-none">
        @csrf
        <input type="file" id="pdf2img_file" name="file" accept="application/pdf" style="display:none">
    </form>

    <div class="mt-3">
        <button type="button" class="btn btn-outline-secondary" id="pdf2img_drop_hint">or drop PDF here</button>
    </div>
</div>

@push('scripts')
<script>
(function(){
    const input = document.getElementById('pdf2img_file');
    const status = document.getElementById('pdf2img_status');
    const drop = document.getElementById('pdf2img_drop_hint');
    if(drop) drop.addEventListener('click', ()=>{
        if(status){
            status.classList.remove('d-none');
            status.classList.remove('alert-info');
            status.classList.add('alert-warning');
            status.textContent = 'Drag & drop will be enabled once the conversion backend is connected.';
        }
    });
    if(input) input.addEventListener('change', function(){
        if(!this.files.length) return;
        if(status){
            status.classList.remove('d-none','alert-warning');
            status.classList.add('alert-info');
            status.textContent = 'File selected: ' + this.files[0].name + '. Conversion backend will be wired next.';
        }
    });
})();
</script>
@endpush
