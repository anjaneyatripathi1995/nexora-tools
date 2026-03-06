<div class="tool-form-wrap">
    <form action="{{ route('tools.process.zip-compressor') }}" method="post" enctype="multipart/form-data" class="mb-4">
        @csrf
        <div class="mb-3">
            <label for="zip_files" class="form-label">Select files to compress</label>
            <div class="fancy-upload">
                <input type="file" id="zip_files" name="files[]" multiple required class="d-none">
                <label for="zip_files" class="fancy-upload__btn">
                    <i class="fa-solid fa-cloud-arrow-up me-2"></i>Select files
                </label>
                <div class="fancy-upload__hint">or drop files here (max 50 MB each)</div>
            </div>
        </div>
        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fa-solid fa-file-zipper me-2"></i>Create ZIP & Download
        </button>
    </form>
</div>
