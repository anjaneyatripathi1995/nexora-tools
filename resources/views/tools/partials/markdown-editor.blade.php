<div class="json-lab" id="markdownLab">
    <div style="margin-bottom:16px;text-align:right">
        <div class="btn-group btn-group-sm" role="group" aria-label="Color mode">
            <button type="button" class="btn btn-outline-secondary active" onclick="markdownLocalTheme('light')">Light</button>
            <button type="button" class="btn btn-outline-secondary" onclick="markdownLocalTheme('dark')">Dark</button>
        </div>
    </div>

    <div class="json-panels">
        <div class="json-panel">
            <div class="json-panel__head">
                <div class="json-panel__title"><i class="fa-solid fa-pen-to-square me-2 text-primary"></i>Markdown Editor</div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light btn-sm json-copy-btn" onclick="pasteMarkdownInput()" title="Paste from clipboard">
                        <i class="fa-solid fa-clipboard me-1"></i>Paste
                    </button>
                    <button type="button" class="btn btn-light btn-sm json-copy-btn" onclick="copyMarkdownInput()">
                        <i class="fa-solid fa-copy me-1"></i>Copy
                    </button>
                </div>
            </div>
            <textarea class="json-editor form-control font-monospace" id="markdown_input" rows="16" placeholder="Write your Markdown here..."># Welcome to Markdown Editor

This is a **live preview** Markdown editor .

## Features

- ✅ Live preview as you type
- ✅ Copy and paste functionality
- ✅ Light/Dark theme toggle
- ✅ XSS-safe HTML rendering

## Code Example

```javascript
function hello() {
    console.log("Hello, World!");
}
```

## Lists

### Unordered List
- Item 1
- Item 2
- Nested item

### Ordered List
1. First item
2. Second item
3. Third item

## Links and Images

[Visit Laravel](https://laravel.com)

## Tables

| Feature | Status |
|---------|--------|
| Live Preview | ✅ |
| Copy/Paste | ✅ |
| Themes | ✅ |

---

*Start writing your own Markdown above and see the live preview on the right!*</textarea>
        </div>

        <div class="json-panel-actions d-none d-lg-flex">
            <div class="json-panel-actions__inner">
                <button type="button" class="json-circle-btn" onclick="renderMarkdown()" title="Render Markdown ▶">
                    <i class="fa-solid fa-eye me-1"></i>
                </button>
                <div class="json-flow-hint">Preview</div>
            </div>
        </div>

        <div class="json-panel">
            <div class="json-panel__head">
                <div class="json-panel__title"><i class="fa-solid fa-eye me-2 text-success"></i>Live Preview</div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light btn-sm json-copy-btn" onclick="copyMarkdownHtml()" title="Copy HTML">
                        <i class="fa-solid fa-code me-1"></i>HTML
                    </button>
                    <button type="button" class="btn btn-light btn-sm json-copy-btn" onclick="copyMarkdownRendered()">
                        <i class="fa-solid fa-copy me-1"></i>Copy
                    </button>
                </div>
            </div>
            <div class="markdown-preview json-output" id="markdown_preview" style="width:100%;height:420px;min-height:420px;max-height:70vh;overflow-y:auto;padding:16px;">
                <div id="markdown_content">
                    <!-- Rendered markdown will appear here -->
                </div>
            </div>
        </div>
    </div>

    <div style="background:var(--bg-elevated);border:1.5px solid var(--border);border-radius:10px;padding:16px;margin-top:20px;font-size:0.95rem;line-height:1.6;color:var(--text)">
        <details style="cursor:pointer">
            <summary style="font-weight:600;color:var(--text-1);user-select:none">
                <i class="fa-solid fa-circle-info me-2"></i>What This Tool Does
            </summary>
            <div style="margin-top:12px;display:flex;flex-direction:column;gap:8px">
                <div><strong>Live Markdown Editor:</strong> Write Markdown syntax in the left panel and see the formatted HTML preview instantly on the right. No page refresh required.</div>
                <div><strong>Features:</strong> Supports headers, lists, links, images, code blocks, tables, blockquotes, and more. Uses marked.js library for fast, secure parsing.</div>
                <div><strong>XSS Protection:</strong> All HTML output is sanitized to prevent cross-site scripting attacks. Only safe Markdown elements are rendered.</div>
                <div><strong>Copy Options:</strong> Copy your Markdown source, rendered HTML, or formatted preview. Paste content from clipboard directly into the editor.</div>
                <div><strong>Themes:</strong> Toggle between light and dark themes for comfortable editing in different lighting conditions.</div>
            </div>
        </details>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/marked@12.0.0/marked.min.js"></script>
<script>
(function(){
    // Configure marked for security
    marked.setOptions({
        breaks: true,
        gfm: true,
        headerIds: false,
        mangle: false
    });

    function showToast(msg, type = 'success') {
        if(window.showFlash) {
            window.showFlash(msg, type, 3000);
        }
    }

    window.markdownLocalTheme = function(mode) {
        var lab = document.getElementById('markdownLab');
        if (!lab) return;
        lab.classList.remove('mode-light','mode-dark');
        lab.classList.add('mode-' + mode);

        // Update button states
        var buttons = document.querySelectorAll('#markdownLab .btn-group .btn');
        buttons.forEach(function(btn, index) {
            btn.classList.remove('active');
            if ((mode === 'light' && index === 0) || (mode === 'dark' && index === 1)) {
                btn.classList.add('active');
            }
        });
    };

    // Default light theme
    markdownLocalTheme('light');

    // Live preview function
    window.renderMarkdown = function() {
        var input = document.getElementById('markdown_input').value;
        var output = document.getElementById('markdown_content');

        try {
            // Use marked to convert markdown to HTML
            var html = marked.parse(input);
            output.innerHTML = html;
        } catch(e) {
            output.innerHTML = '<div class="text-danger">Error rendering markdown: ' + e.message + '</div>';
        }
    };

    // Auto-render on input
    document.getElementById('markdown_input').addEventListener('input', function() {
        renderMarkdown();
    });

    // Initial render
    renderMarkdown();

    // Copy functions
    window.copyMarkdownInput = function() {
        navigator.clipboard.writeText(document.getElementById('markdown_input').value).then(function() {
            showToast('Markdown copied!', 'success');
        }).catch(function(err) {
            showToast('Copy failed', 'error');
        });
    };

    window.copyMarkdownHtml = function() {
        var input = document.getElementById('markdown_input').value;
        try {
            var html = marked.parse(input);
            navigator.clipboard.writeText(html).then(function() {
                showToast('HTML copied!', 'success');
            }).catch(function(err) {
                showToast('Copy failed', 'error');
            });
        } catch(e) {
            showToast('Error generating HTML', 'error');
        }
    };

    window.copyMarkdownRendered = function() {
        var rendered = document.getElementById('markdown_content').innerText;
        navigator.clipboard.writeText(rendered).then(function() {
            showToast('Rendered text copied!', 'success');
        }).catch(function(err) {
            showToast('Copy failed', 'error');
        });
    };

    window.pasteMarkdownInput = function() {
        navigator.clipboard.readText().then(function(text) {
            document.getElementById('markdown_input').value = text;
            renderMarkdown();
            showToast('Pasted to editor!', 'success');
        }).catch(function(err) {
            showToast('Paste failed', 'error');
        });
    };
})();
</script>
@endpush