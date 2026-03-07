{{-- QR Code Generator Tool --}}
<div class="tool-form-wrap">

    <div class="row g-4 align-items-start">

        {{-- ── LEFT: Input Section ── --}}
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="qr_text" class="form-label fw-semibold">Text or URL</label>
                <textarea class="form-control"
                          id="qr_text"
                          rows="4"
                          placeholder="Enter text or URL to encode…"></textarea>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-sm-12">
                    <label for="qr_size" class="form-label fw-semibold">QR Code Size</label>
                    <select class="form-select" id="qr_size">
                        <option value="200">200 × 200 px</option>
                        <option value="300" selected>300 × 300 px</option>
                        <option value="500">500 × 500 px</option>
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-6">
                    <label for="qr_fg" class="form-label fw-semibold">Foreground Color</label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="color" class="form-control form-control-color" id="qr_fg"
                               value="#000000" title="QR foreground color" style="width:48px;height:38px;padding:2px;">
                        <span class="text-body-secondary small" id="qr_fg_hex">#000000</span>
                    </div>
                </div>
                <div class="col-6">
                    <label for="qr_bg" class="form-label fw-semibold">Background Color</label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="color" class="form-control form-control-color" id="qr_bg"
                               value="#ffffff" title="QR background color" style="width:48px;height:38px;padding:2px;">
                        <span class="text-body-secondary small" id="qr_bg_hex">#ffffff</span>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <button type="button" class="btn btn-primary px-4" id="qr_generate_btn">
                    <i class="fa-solid fa-qrcode me-1"></i> Generate QR Code
                </button>
                <button type="button" class="btn btn-outline-secondary px-4" id="qr_clear_btn">
                    <i class="fa-solid fa-rotate-left me-1"></i> Clear
                </button>
            </div>
        </div>

        {{-- ── RIGHT: Preview Section ── --}}
        <div class="col-lg-6">
            <label class="form-label fw-semibold">QR Preview</label>
            <div class="border rounded d-flex flex-column align-items-center justify-content-center bg-white p-3"
                 id="qr_preview_wrap"
                 style="min-height:320px;">

                {{-- Placeholder --}}
                <div id="qr_placeholder" class="text-center text-body-secondary py-4">
                    <i class="fa-solid fa-qrcode mb-2" style="font-size:3rem;opacity:.25;"></i>
                    <p class="mb-0 small">Preview appears here</p>
                </div>

                {{-- QR canvas will be injected here --}}
                <div id="qr_canvas_wrap" style="display:none;"></div>

            </div>

            {{-- Download button (shown after generation) --}}
            <div class="mt-3" id="qr_download_wrap" style="display:none;">
                <button type="button" class="btn btn-success w-100" id="qr_download_btn">
                    <i class="fa-solid fa-download me-1"></i> Download QR Code as PNG
                </button>
            </div>
        </div>

    </div>

    <p class="small text-body-secondary mt-4 mb-0">
        <i class="fa-solid fa-circle-info me-1"></i>
        QR codes are generated entirely in your browser using <strong>QRCode.js</strong> — no data is sent to any server.
    </p>

</div>

@push('head_styles')
<style>
    #qr_canvas_wrap canvas,
    #qr_canvas_wrap img {
        max-width: 100%;
        height: auto;
        display: block;
        border-radius: 6px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"
        integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
(function () {
    'use strict';

    var qrInstance   = null;
    var lastText     = '';
    var lastSize     = 300;
    var lastFg       = '#000000';
    var lastBg       = '#ffffff';
    var debounceTimer = null;

    var elText       = document.getElementById('qr_text');
    var elSize       = document.getElementById('qr_size');
    var elFg         = document.getElementById('qr_fg');
    var elBg         = document.getElementById('qr_bg');
    var elFgHex      = document.getElementById('qr_fg_hex');
    var elBgHex      = document.getElementById('qr_bg_hex');
    var elGenerateBtn= document.getElementById('qr_generate_btn');
    var elClearBtn   = document.getElementById('qr_clear_btn');
    var elDownloadBtn= document.getElementById('qr_download_btn');
    var elPlaceholder= document.getElementById('qr_placeholder');
    var elCanvasWrap = document.getElementById('qr_canvas_wrap');
    var elDownloadWrap = document.getElementById('qr_download_wrap');

    function showPlaceholder() {
        elPlaceholder.style.display = '';
        elCanvasWrap.style.display  = 'none';
        elDownloadWrap.style.display = 'none';
    }

    function renderQR(text, size, fg, bg) {
        if (!text) { showPlaceholder(); return; }

        elCanvasWrap.innerHTML = '';
        elPlaceholder.style.display = 'none';
        elCanvasWrap.style.display  = '';

        try {
            qrInstance = new QRCode(elCanvasWrap, {
                text:            text,
                width:           parseInt(size, 10),
                height:          parseInt(size, 10),
                colorDark:       fg,
                colorLight:      bg,
                correctLevel:    QRCode.CorrectLevel.H
            });
            elDownloadWrap.style.display = '';
        } catch (e) {
            elCanvasWrap.innerHTML = '<p class="text-danger small p-2 mb-0">Could not generate QR code. Check your input.</p>';
            elDownloadWrap.style.display = 'none';
        }

        lastText = text;
        lastSize = size;
        lastFg   = fg;
        lastBg   = bg;
    }

    function scheduleRender() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            var text = elText.value.trim();
            var size = parseInt(elSize.value, 10);
            var fg   = elFg.value;
            var bg   = elBg.value;
            if (text !== lastText || size !== lastSize || fg !== lastFg || bg !== lastBg) {
                renderQR(text, size, fg, bg);
            }
        }, 350);
    }

    // Live preview on typing
    elText.addEventListener('input', scheduleRender);

    // Immediate re-render on option changes (only if already generated)
    [elSize, elFg, elBg].forEach(function (el) {
        el.addEventListener('change', function () {
            if (lastText) scheduleRender();
        });
        el.addEventListener('input', function () {
            if (lastText) scheduleRender();
        });
    });

    // Sync hex labels for color pickers
    elFg.addEventListener('input', function () { elFgHex.textContent = this.value; });
    elBg.addEventListener('input', function () { elBgHex.textContent = this.value; });

    // Generate button (explicit trigger)
    elGenerateBtn.addEventListener('click', function () {
        var text = elText.value.trim();
        if (!text) {
            elText.focus();
            elText.classList.add('is-invalid');
            setTimeout(function () { elText.classList.remove('is-invalid'); }, 1500);
            return;
        }
        renderQR(text, parseInt(elSize.value, 10), elFg.value, elBg.value);
    });

    // Clear button
    elClearBtn.addEventListener('click', function () {
        elText.value  = '';
        elSize.value  = '300';
        elFg.value    = '#000000';
        elBg.value    = '#ffffff';
        elFgHex.textContent = '#000000';
        elBgHex.textContent = '#ffffff';
        lastText = '';
        qrInstance = null;
        showPlaceholder();
        elText.focus();
    });

    // Download as PNG
    elDownloadBtn.addEventListener('click', function () {
        var canvas = elCanvasWrap.querySelector('canvas');
        if (!canvas) {
            // QRCode.js sometimes falls back to <img> (in older environments)
            var img = elCanvasWrap.querySelector('img');
            if (img && img.src) {
                var a = document.createElement('a');
                a.href     = img.src;
                a.download = 'qr-code.png';
                a.click();
            }
            return;
        }
        var a = document.createElement('a');
        a.href     = canvas.toDataURL('image/png');
        a.download = 'qr-code.png';
        a.click();
    });

})();
</script>
@endpush
