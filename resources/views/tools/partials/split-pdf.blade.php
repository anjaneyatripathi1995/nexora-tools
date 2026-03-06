@push('styles')
<style>
 .pdf-convert-hero { text-align: center; padding: 3.5rem 1rem; border-radius: 12px; background: #f7f7fb; }
 .pdf-select-btn { background: #e53935; border-color: #e53935; color: #fff; padding: 1.25rem 2.5rem; font-size: 1.25rem; border-radius: 12px; box-shadow: 0 6px 18px rgba(229,57,53,0.12); }
 .pdf-side-btn { width:48px; height:48px; border-radius:50%; background:#e53935; color:#fff; display:inline-flex; align-items:center; justify-content:center; margin-left:.75rem }
</style>
@endpush

<div class="pdf-convert-hero mb-4">
    <h1 class="fw-bold display-5 mb-2">Split PDF into Pages</h1>
    <p class="mb-3 text-muted">Break a PDF into individual pages packaged as a ZIP file.</p>
    <p class="small text-muted">Upload your PDF below; the service will extract each page separately.</p>

    <div class="d-flex justify-content-center align-items-center mt-4">
        <label class="pdf-select-btn" for="split_pdf_file">Select PDF file</label>
        <div class="d-inline-block">
            <button class="pdf-side-btn" title="Google Drive"><i class="fa-brands fa-google-drive"></i></button>
            <button class="pdf-side-btn" title="Dropbox"><i class="fa-brands fa-dropbox"></i></button>
        </div>
    </div>

    <form id="split_pdf_form" class="d-none">
        @csrf
        <input type="file" class="form-control form-control-lg" id="split_pdf_file" name="files[]" accept=".pdf,application/pdf" required style="display:none">
        <div class="form-text mt-2">One PDF per page will be created and downloaded as a ZIP. Max 20 MB.</div>
    </form>

    <div class="mt-3">
        <button type="button" class="btn btn-outline-secondary" onclick="alert('Split service not configured.')">or drop PDF here</button>
    </div>
</div>

@push('scripts')
<script>
// mimic selection click
var splitInput = document.getElementById('split_pdf_file');
document.querySelector('label[for="split_pdf_file"]').addEventListener('click', function(){ splitInput.click(); });
splitInput.addEventListener('change', function(){ if(this.files.length) alert('File selected: '+this.files[0].name+'\nSplit service not configured.'); });

document.getElementById('split_pdf_btn').addEventListener('click', function(){
    var fileEl = document.getElementById('split_pdf_file');
    if(!fileEl.files.length) return alert('Choose a PDF');
    var fd = new FormData();
    fd.append('files[]', fileEl.files[0]);
    fetch('/api/tools/split-pdf', { method:'POST', body: fd, headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}'} })
        .then(r=>r.json()).then(d=>{ if(d.job_id) startPoll(d.job_id); });
});
function startPoll(id){
    var statusDiv = document.getElementById('split-pdf-status');
    var statusText = document.getElementById('split-pdf-status-text');
    var link = document.getElementById('split-pdf-download');
    statusDiv.style.display = '';
    function p(){ fetch('/api/jobs/'+id).then(r=>r.json()).then(j=>{
        statusText.textContent = j.status;
        if(j.status==='done'){ link.href='/storage/'+j.result_path; link.style.display='inline-block'; }
        else if(j.status==='failed'){ document.getElementById('split-pdf-alert').textContent='Error: '+j.error_message; document.getElementById('split-pdf-alert').style.display='block'; }
        else setTimeout(p,1000);
    }); }
    p();
}
</script>
@endpush
