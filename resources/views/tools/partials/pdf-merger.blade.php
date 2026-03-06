@push('styles')
<style>
 .pdf-convert-hero { text-align: center; padding: 3.5rem 1rem; border-radius: 12px; background: #f7f7fb; }
 .pdf-select-btn { background: #e53935; border-color: #e53935; color: #fff; padding: 1.25rem 2.5rem; font-size: 1.25rem; border-radius: 12px; box-shadow: 0 6px 18px rgba(229,57,53,0.12); }
 .pdf-side-btn { width:48px; height:48px; border-radius:50%; background:#e53935; color:#fff; display:inline-flex; align-items:center; justify-content:center; margin-left:.75rem }
</style>
@endpush

<div class="pdf-convert-hero mb-4">
    <h1 class="fw-bold display-5 mb-2">Merge PDF Files</h1>
    <p class="mb-3 text-muted">Combine multiple PDF documents into a single file.</p>
    <p class="small text-muted">Upload your PDFs below; the merged result will be ready to download when the service is enabled.</p>

    <div class="d-flex justify-content-center align-items-center mt-4">
        <label class="pdf-select-btn" for="pdf_merge_files">Select PDF files</label>
        <div class="d-inline-block">
            <button class="pdf-side-btn" title="Google Drive"><i class="fa-brands fa-google-drive"></i></button>
            <button class="pdf-side-btn" title="Dropbox"><i class="fa-brands fa-dropbox"></i></button>
        </div>
    </div>

    <form id="pdf_merge_form" class="d-none">
        @csrf
        <input type="file" id="pdf_merge_files" name="files[]" accept="application/pdf" multiple style="display:none" required>
    </form>

    <div class="mt-3">
        <button type="button" class="btn btn-outline-secondary" onclick="alert('PDF merge service is not configured.')">or drop PDFs here</button>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('pdf_merge_btn').addEventListener('click', function(){
    var files = document.getElementById('pdf_merge_files').files;
    if (!files.length) return alert('Please select some PDF files.');
    var form = new FormData();
    for (var i=0;i<files.length;i++) form.append('files[]', files[i]);
    fetch('/api/tools/pdf-merger', { method:'POST', body: form, headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}'} })
        .then(r=>r.json())
        .then(data=>{
            if(data.job_id){ startPoll(data.job_id); }
            else alert('Failed to start job');
        });
});
function startPoll(jobId){
    var statusDiv = document.getElementById('pdf-merge-status');
    var statusText = document.getElementById('pdf-merge-status-text');
    var downloadLink = document.getElementById('pdf-merge-download');
    statusDiv.style.display = '';
    function poll(){
        fetch('/api/jobs/'+jobId).then(r=>r.json()).then(j=>{
            statusText.textContent = j.status;
            if(j.status==='done'){
                downloadLink.href='/storage/'+j.result_path;
                downloadLink.style.display='inline-block';
            } else if(j.status==='failed'){
                document.getElementById('pdf-merge-alert').textContent = 'Job failed: '+j.error_message;
                document.getElementById('pdf-merge-alert').style.display='block';
            } else {
                setTimeout(poll,1000);
            }
        });
    }
    poll();
}
</script>
@endpush

@push('scripts')
<script>
document.getElementById('pdf_merge_btn').addEventListener('click', function(){
    var files = document.getElementById('pdf_merge_files').files;
    if (!files.length) return alert('Please select some PDF files.');
    var form = new FormData();
    for (var i=0;i<files.length;i++) form.append('files[]', files[i]);
    fetch('/api/tools/pdf-merger', { method:'POST', body: form, headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}'} })
        .then(r=>r.json())
        .then(data=>{
            if(data.job_id){ startPoll(data.job_id); }
            else alert('Failed to start job');
        });
});
function startPoll(jobId){
    var statusDiv = document.getElementById('pdf-merge-status');
    var statusText = document.getElementById('pdf-merge-status-text');
    var downloadLink = document.getElementById('pdf-merge-download');
    statusDiv.style.display = '';
    function poll(){
        fetch('/api/jobs/'+jobId).then(r=>r.json()).then(j=>{
            statusText.textContent = j.status;
            if(j.status==='done'){
                downloadLink.href='/storage/'+j.result_path;
                downloadLink.style.display='inline-block';
            } else if(j.status==='failed'){
                document.getElementById('pdf-merge-alert').textContent = 'Job failed: '+j.error_message;
                document.getElementById('pdf-merge-alert').style.display='block';
            } else {
                setTimeout(poll,1000);
            }
        });
    }
    poll();
}
</script>
@endpush
