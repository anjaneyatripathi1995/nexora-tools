@push('styles')
<style>
 .pdf-convert-hero { text-align: center; padding: 3.5rem 1rem; border-radius: 12px; background: #f7f7fb; }
 .pdf-select-btn { background: #e53935; border-color: #e53935; color: #fff; padding: 1.25rem 2.5rem; font-size: 1.25rem; border-radius: 12px; box-shadow: 0 6px 18px rgba(229,57,53,0.12); }
 .pdf-side-btn { width:48px; height:48px; border-radius:50%; background:#e53935; color:#fff; display:inline-flex; align-items:center; justify-content:center; margin-left:.75rem }
</style>
@endpush

<div class="pdf-convert-hero mb-4">
    <h1 class="fw-bold display-5 mb-2">Lock / Unlock PDF</h1>
    <p class="mb-3 text-muted">Add or remove passwords from your PDF documents.</p>
    <p class="small text-muted">Server support coming soon; upload a file to continue when available.</p>

    <div class="d-flex justify-content-center align-items-center mt-4">
        <label class="pdf-select-btn" for="lock_pdf_file">Select PDF file</label>
        <div class="d-inline-block">
            <button class="pdf-side-btn" title="Google Drive"><i class="fa-brands fa-google-drive"></i></button>
            <button class="pdf-side-btn" title="Dropbox"><i class="fa-brands fa-dropbox"></i></button>
        </div>
    </div>

    <form class="d-none" id="lock_pdf_form">
        @csrf
        <input type="file" id="lock_pdf_file" accept="application/pdf" style="display:none">
        <div class="mb-3 mt-3">
            <label for="lock_pdf_pass" class="form-label">Password (for lock) or current password (for unlock)</label>
            <input type="password" class="form-control" id="lock_pdf_pass" placeholder="Optional">
        </div>
        <button type="button" class="btn btn-primary me-2" onclick="alert('Lock/Unlock PDF will be available when the server library is configured.')">Lock PDF</button>
        <button type="button" class="btn btn-outline-secondary" onclick="alert('Unlock requires the current password; support coming soon.')">Unlock PDF</button>
    </form>

    <div class="mt-3">
        <button type="button" class="btn btn-outline-secondary" onclick="alert('Feature coming soon.')">or drop PDF here</button>
    </div>
</div>

@push('scripts')
<script>
var lockInput = document.getElementById('lock_pdf_file');
document.querySelector('label[for="lock_pdf_file"]').addEventListener('click', function(){ lockInput.click(); });
lockInput.addEventListener('change', function(){ if(this.files.length) alert('File selected: '+this.files[0].name+'\nFeature coming soon.'); });
</script>
@endpush
