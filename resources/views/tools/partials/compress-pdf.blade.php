@push('styles')
<style>
 .pdf-convert-hero { text-align: center; padding: 3.5rem 1rem; border-radius: 12px; background: #f7f7fb; }
 .pdf-select-btn { background: #e53935; border-color: #e53935; color: #fff; padding: 1.25rem 2.5rem; font-size: 1.25rem; border-radius: 12px; box-shadow: 0 6px 18px rgba(229,57,53,0.12); }
 .pdf-side-btn { width:48px; height:48px; border-radius:50%; background:#e53935; color:#fff; display:inline-flex; align-items:center; justify-content:center; margin-left:.75rem }
</style>
@endpush

<div class="pdf-convert-hero mb-4">
    <h1 class="fw-bold display-5 mb-2">Compress PDF File</h1>
    <p class="mb-3 text-muted">Reduce the file size of a PDF without losing quality.</p>
    <p class="small text-muted">Uses server-side compression tools; upload your PDF below.</p>

    <div class="d-flex justify-content-center align-items-center mt-4">
        <label class="pdf-select-btn" for="compress_pdf_file">Select PDF file</label>
        <div class="d-inline-block">
            <button class="pdf-side-btn" title="Google Drive"><i class="fa-brands fa-google-drive"></i></button>
            <button class="pdf-side-btn" title="Dropbox"><i class="fa-brands fa-dropbox"></i></button>
        </div>
    </div>

    <form id="compress_pdf_form" class="d-none">
        @csrf
        <input type="file" id="compress_pdf_file" name="file" accept="application/pdf" style="display:none">
    </form>

    <div class="mt-3">
        <button type="button" class="btn btn-outline-secondary" onclick="alert('Compression service not configured.')">or drop PDF here</button>
    </div>
</div>

@push('scripts')
<script>
// mimic file select and alert
var compInput = document.getElementById('compress_pdf_file');
document.querySelector('label[for="compress_pdf_file"]').addEventListener('click', function(){ compInput.click(); });
compInput.addEventListener('change', function(){ if(this.files.length) alert('File selected: '+this.files[0].name+'\nCompression service not configured.'); });

// original behavior
document.getElementById('compress_pdf_btn').addEventListener('click', function(){
    var f = document.getElementById('compress_pdf_file');
    if(!f.files.length) return alert('Select a PDF');
    var fd = new FormData(); fd.append('files[]', f.files[0]);
    fetch('/api/tools/compress-pdf',{method:'POST',body:fd,headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}}).then(r=>r.json()).then(d=>{ if(d.job_id) poll(d.job_id); });
});
function poll(id){
    var txt=document.getElementById('compress-pdf-status-text');
    var dl=document.getElementById('compress-pdf-download');
    document.getElementById('compress-pdf-status').style.display='';
    (function p(){fetch('/api/jobs/'+id).then(r=>r.json()).then(j=>{
        txt.textContent=j.status;
        if(j.status==='done'){ dl.href='/storage/'+j.result_path; dl.style.display='inline-block'; }
        else if(j.status==='failed'){ document.getElementById('compress-pdf-alert').textContent='Error:'+j.error_message; document.getElementById('compress-pdf-alert').style.display='block'; }
        else setTimeout(p,1000);
    });})();
}
</script>
@endpush
