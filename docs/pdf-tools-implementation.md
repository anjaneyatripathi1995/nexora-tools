# PDF Tools Implementation Plan

This document outlines the implementation logic, server dependencies, API design, and security considerations for the PDF tools shown in the site mega-menu.

General notes applicable to most tools:
- Accept uploads via POST to `/api/tools/{slug}` (multipart/form-data).
- Validate file types and sizes (e.g., PDFs max 50MB for synchronous; larger via chunked uploads or background jobs).
- Use a job queue (Redis + Laravel Queue) for long-running conversions. Respond immediately with a job id; provide `/api/jobs/{id}` for status and result.
- Store uploaded files temporarily in `storage/app/tmp/tools/{job}`; delete after result delivered or after TTL (24h).
- Rate-limit and virus-scan uploaded files (use ClamAV or commercial scanning API) before processing.
- Use streaming responses when possible to avoid loading large files into memory.
- Provide clear error mapping and user-friendly messages in the UI.

Tool-by-tool implementation sketches

1) Merge PDF (`pdf-merger`)
- Client: multiple file inputs or drag-drop; send multipart with multiple files.
- Server: use `setasign/fpdi` + `setasign/fpdf` or `smalot/pdfparser` to concatenate pages, or call `qpdf`/`pdftk` on system.
- Process: synchronous for small uploads; for >20MB use queued job.
- Output: single merged PDF streamed for download.
- Edge cases: differing page sizes, encryption — detect encrypted input and prompt user for password or reject.

2) Split PDF (`split-pdf`)
- Client: upload + pages/range input.
- Server: use `pdfinfo` + `qpdf` to extract ranges, or use `setasign` libraries.
- Output: either single PDF containing selected pages or a ZIP of individual pages.

3) Compress PDF (`compress-pdf`)
- Approach: use Ghostscript (`gs`) with quality presets or `qpdf --stream-data=compress` for lossless.
- Server: run job in background, return download link when done.
- Offer quality presets: high (max compression), medium, low (retain quality).

4) PDF to Image / Image to PDF (`pdf-to-image`, `jpg-to-pdf`)
- Use ImageMagick or Poppler (`pdftoppm`) to rasterize pages to PNG/JPEG.
- For image-to-pdf: use ImageMagick `convert` or PHP Imagick extension.
- Options: resolution (DPI), output format, page range.

5) PDF to Word / Word to PDF (`pdf-to-word`, `word-to-pdf`)
- Server component is required (LibreOffice `soffice --headless --convert-to docx` for Word->PDF and PDF->docx depending on engine) or use cloud APIs (e.g., CloudConvert, Microsoft Graph conversion).
- PDF->Word fidelity varies; advise user and provide link to download result.
- For PDF->Word, often a commercial/cloud engine works best; provide fallback to best-effort conversion with LibreOffice.

6) PDF to Excel (`pdf-to-excel`)
- Use tabular extraction tools: Tabula (Java) or commercial APIs that extract tables reliably.
- Provide preview and allow users to adjust table detection region (advanced).

7) OCR (`ocr`, `image-ocr`)
- Use Tesseract (open-source) or cloud OCR (Google Vision, AWS Textract) for better accuracy.
- Steps: rasterize (if PDF), run OCR, return plain text / searchable PDF / JSON with bounding boxes.

8) Lock/Unlock PDF (`lock-unlock-pdf`)
- Use QPDF (`qpdf --encrypt` / `--decrypt`) to add/remove passwords.
- UI: prompt for password when locking or unlocking.

9) Repair PDF
- Attempt repair via Ghostscript: regenerate PDF pages to new file; detect corrupted structure and recompose.

10) Add Watermark / Add Page Numbers / Rotate / Crop / Edit
- Use `qpdf` or `pdftk` for rotation and simple operations.
- For watermarking/overlay, use `fpdf/fpdi` to stamp content across pages.
- For cropping/advanced editing, consider integrating a JS-based PDF editor in UI and server-side application to apply changes.

11) Sign PDF
- Integrate with a signing library like `setasign/fpdi` + PKCS#11 module or call a signing service; manage certificates securely.

12) Redact PDF
- Render page to image, apply black boxes on regions, and regenerate PDF OR use PDF object-level redaction via advanced libraries.
- Maintain an irreversible redaction operation (zero-out content streams) to ensure privacy.

13) Compare PDF
- Render pages to images and diff visually (ImageMagick) or compare text extractions and present differences.

Operational considerations
- Security: run conversions inside isolated workers/containers; limit CPU/memory and execution time; sanitize filenames and inputs.
- Scalability: use queue workers and autoscaling for heavy jobs; store small results in local storage and larger ones in S3.
- Monitoring: record job durations, failures, and user-perceived errors.

API examples
- POST /api/tools/pdf-merger -> { job_id }
- GET /api/jobs/{job_id} -> { status: pending|running|done|failed, progress, download_url }
- GET /api/tools/catalog -> returns available tools and status (enabled/coming-soon)

UI notes
- Provide clear affordances when a service is "Coming soon" or requires server configuration.
- Show time estimates for queued jobs (e.g., "Takes ~30-90s").
- Offer downloadable sample files and explain limitations (OCR accuracy, table extraction caveats).

This file should be used as the canonical plan when adding server-side conversion services. Implement features incrementally, starting with Merge, Split, Compress, and PDF->Image (these are easier), then OCR and table extraction, and finally Word/Excel conversions which often need commercial engines for high fidelity.

## Deployment record

2026-02-27: Partial implementation deployed to repository. Changes included here were added to the working tree and prepared for push:

- Added shared calculator styles partial: `resources/views/tools/partials/calculator-shared-styles.blade.php`
- Updated calculators to include shared styles: `emi-calculator`, `sip-calculator`, `gst-calculator`, `age-calculator`, `month-to-date-converter` partials
- Replaced EMI donut with a horizontal bar chart for clearer principal vs interest display
- Added tools mega-menu: `resources/views/tools/partials/tools-mega-menu.blade.php` and included it in `resources/views/tools/index.blade.php`
- Redesigned `PDF to Word` partial to hero layout and wired a hidden file input: `resources/views/tools/partials/pdf-to-word.blade.php`
- Created a detailed implementation plan: `docs/pdf-tools-implementation.md` (this file)

If CI and remote are configured, these changes were committed and pushed to the `main` branch, and pushed to a feature branch `anjaneya` for review. If push failed due to remote/auth config, please run the following locally from the repository root to publish the changes:

```bash
git add -A
git commit -m "Implement PDF tools UI improvements, shared styles, and initial API plan"
git push origin main
git checkout -b anjaneya
git push -u origin anjaneya
```

Contact the devops or repository owner if `origin` is protected or requires credentials.
