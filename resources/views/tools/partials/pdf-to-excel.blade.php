@push('styles')
<style>
 .pdf-convert-hero { text-align: center; padding: 3.5rem 1rem; border-radius: 12px; background: #f7f7fb; }
 .pdf-select-btn { background: #e53935; border-color: #e53935; color: #fff; padding: 1.25rem 2.5rem; font-size: 1.25rem; border-radius: 12px; box-shadow: 0 6px 18px rgba(229,57,53,0.12); }
 .pdf-side-btn { width:48px; height:48px; border-radius:50%; background:#e53935; color:#fff; display:inline-flex; align-items:center; justify-content:center; margin-left:.75rem }
</style>
@endpush

<div class="pdf-convert-hero mb-4">
    <h1 class="fw-bold display-5 mb-2">PDF to EXCEL Converter</h1>
    <p class="mb-3 text-muted">Extract tables and data from PDFs into Excel spreadsheets.</p>
    <p class="small text-muted">Powered by server‑side table recognition or API services.</p>

    <div class="d-flex justify-content-center align-items-center mt-4">
        <label class="pdf-select-btn" for="pdf2x_file">Select PDF file</label>
        <div class="d-inline-block">
            <button class="pdf-side-btn" title="Google Drive"><i class="fa-brands fa-google-drive"></i></button>
            <button class="pdf-side-btn" title="Dropbox"><i class="fa-brands fa-dropbox"></i></button>
        </div>
    </div>

    <form id="pdf2x_form" class="d-none">
        @csrf
        <input type="file" id="pdf2x_file" name="file" accept="application/pdf" style="display:none">
    </form>

    <div class="mt-3">
        <button type="button" class="btn btn-outline-secondary" onclick="alert('PDF to Excel conversion will be available when the server service is configured.')">or drop PDF here</button>
    </div>
</div>

@push('scripts')
<script>
// file select mimic for Excel converter
var pdf2xInput = document.getElementById('pdf2x_file');
document.querySelector('label[for="pdf2x_file"]').addEventListener('click', function(){
    pdf2xInput.click();
});
pdf2xInput.addEventListener('change', function(){
    if(!this.files.length) return;
    alert('File selected: ' + this.files[0].name + '\nConversion service not configured.');
});
</script>
@endpush
