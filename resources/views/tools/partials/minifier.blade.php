<div class="tool-form-wrap">
    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#min-js" type="button">JavaScript</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#min-css" type="button">CSS</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#min-html" type="button">HTML</button></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="min-js">
            <div class="mb-3">
                <label class="form-label">Paste JavaScript</label>
                <textarea class="form-control font-monospace small" id="min_js_in" rows="8"></textarea>
            </div>
            <button type="button" class="btn btn-primary mb-2" onclick="minifyJs()">Minify</button>
            <textarea class="form-control font-monospace small" id="min_js_out" rows="6" readonly placeholder="Minified output"></textarea>
        </div>
        <div class="tab-pane fade" id="min-css">
            <div class="mb-3">
                <label class="form-label">Paste CSS</label>
                <textarea class="form-control font-monospace small" id="min_css_in" rows="8"></textarea>
            </div>
            <button type="button" class="btn btn-primary mb-2" onclick="minifyCss()">Minify</button>
            <textarea class="form-control font-monospace small" id="min_css_out" rows="6" readonly placeholder="Minified output"></textarea>
        </div>
        <div class="tab-pane fade" id="min-html">
            <div class="mb-3">
                <label class="form-label">Paste HTML</label>
                <textarea class="form-control font-monospace small" id="min_html_in" rows="8"></textarea>
            </div>
            <button type="button" class="btn btn-primary mb-2" onclick="minifyHtml()">Minify</button>
            <textarea class="form-control font-monospace small" id="min_html_out" rows="6" readonly placeholder="Minified output"></textarea>
        </div>
    </div>
</div>

@push('scripts')
<script>
function minifyJs() {
    var s = document.getElementById('min_js_in').value;
    document.getElementById('min_js_out').value = s.replace(/\/\*[\s\S]*?\*\//g,'').replace(/\/\/[^\n]*/g,'').replace(/\s+/g,' ').trim();
}
function minifyCss() {
    var s = document.getElementById('min_css_in').value;
    document.getElementById('min_css_out').value = s.replace(/\/\*[\s\S]*?\*\//g,'').replace(/\s+/g,' ').trim();
}
function minifyHtml() {
    var s = document.getElementById('min_html_in').value;
    document.getElementById('min_html_out').value = s.replace(/\s+/g,' ').replace(/>\s+</g,'><').trim();
}
</script>
@endpush
