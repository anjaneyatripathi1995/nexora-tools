@php
  $footerCategories = [
    'Finance & Date Tools' => [
      ['label' => 'EMI Calculator', 'href' => '/tools/emi-calculator'],
      ['label' => 'SIP Calculator', 'href' => '/tools/sip-calculator'],
      ['label' => 'FD / RD Calculator', 'href' => '/tools/fd-rd-calculator'],
      ['label' => 'GST Calculator', 'href' => '/tools/gst-calculator'],
      ['label' => 'Age Calculator', 'href' => '/tools/age-calculator'],
      ['label' => 'Date Converter', 'href' => '/tools/month-to-date-converter'],
    ],
    'PDF & File Tools' => [
      ['label' => 'PDF Merger', 'href' => '/tools/pdf-merger'],
      ['label' => 'Split PDF', 'href' => '/tools/split-pdf'],
      ['label' => 'Compress PDF', 'href' => '/tools/compress-pdf'],
      ['label' => 'PDF to Word', 'href' => '/tools/pdf-to-word'],
      ['label' => 'PDF to Image', 'href' => '/tools/pdf-to-image'],
      ['label' => 'PDF to Excel', 'href' => '/tools/pdf-to-excel'],
      ['label' => 'Lock / Unlock PDF', 'href' => '/tools/lock-unlock-pdf'],
      ['label' => 'OCR Tool', 'href' => '/tools/ocr'],
      ['label' => 'ZIP Compressor', 'href' => '/tools/zip-compressor'],
    ],
    'Text & Content Tools' => [
      ['label' => 'Word Counter', 'href' => '/tools/word-counter'],
      ['label' => 'Grammar Checker', 'href' => '/tools/grammar-checker'],
      ['label' => 'Paraphraser', 'href' => '/tools/paraphraser'],
      ['label' => 'Case Converter', 'href' => '/tools/case-converter'],
      ['label' => 'Plagiarism Checker', 'href' => '/tools/plagiarism-checker'],
      ['label' => 'Resume Builder', 'href' => '/tools/resume-builder'],
      ['label' => 'Essay Generator', 'href' => '/tools/essay-letter-generator'],
    ],
    'Developer & Image Tools' => [
      ['label' => 'JSON Formatter', 'href' => '/tools/json-formatter'],
      ['label' => 'QR Code Generator', 'href' => '/tools/qr-code-generator'],
      ['label' => 'Regex Tester', 'href' => '/tools/regex-tester'],
      ['label' => 'Base64 Encoder', 'href' => '/tools/base64-encoder'],
      ['label' => 'URL Encoder', 'href' => '/tools/url-encoder'],
      ['label' => 'Code Minifier', 'href' => '/tools/minifier'],
      ['label' => 'Image Resizer', 'href' => '/tools/image-resizer'],
      ['label' => 'Background Remover', 'href' => '/tools/background-remover'],
      ['label' => 'Image Compressor', 'href' => '/tools/image-compressor'],
    ],
    'Products & Platform' => [
      ['label' => 'All Tools', 'href' => '/tools'],
      ['label' => 'Projects', 'href' => '/projects'],
      ['label' => 'Apps', 'href' => '/apps'],
      ['label' => 'Templates', 'href' => '/templates'],
      ['label' => 'AI Videos', 'href' => '/ai-videos'],
      ['label' => 'News', 'href' => '/news'],
      ['label' => 'Market', 'href' => '/market'],
      ['label' => 'Dashboard', 'href' => '/dashboard'],
    ],
    'AI Video Tools' => [
      ['label' => 'AI Generator', 'href' => '/ai-videos/generator'],
      ['label' => 'Meme Generator', 'href' => '/ai-videos/meme-generator'],
      ['label' => 'Love Calculator', 'href' => '/ai-videos/love-calculator'],
      ['label' => 'Caption Generator', 'href' => '/ai-videos/caption-generator'],
    ],
  ];
@endphp

<footer class="site-footer">
  <div class="container footer-grid">
    <div class="footer-brand">
      <div class="footer-logo">
        <span class="footer-logo-icon">NT</span>
        <div>
          <div class="footer-logo-name">Nexora Tools</div>
          <div class="footer-logo-tag">Free online tools · Tripathi Nexora Technologies</div>
        </div>
      </div>
      <p class="footer-about mb-3">
        D-71, 3rd Floor<br>
        West Vinod Nagar, Delhi – 110092<br>
        Delhi, India
      </p>
      <div class="footer-cta">
        <a href="mailto:support@tripathinexora.com" class="footer-link-bold">Contact Us</a>
        <span class="footer-divider">•</span>
        <a href="#" class="footer-link-bold">Download the App</a>
      </div>
      <div class="footer-badges">
        <!-- <a href="#" class="store-badge"><i class="fa-brands fa-apple"></i> App Store</a>
        <a href="#" class="store-badge play"><i class="fa-brands fa-google-play"></i> Play Store</a> -->
      </div>
      <div class="social-icons mt-3">
        <a href="#"><i class="fab fa-youtube"></i></a>
        <a href="#"><i class="fab fa-linkedin"></i></a>
        <a href="#"><i class="fab fa-discord"></i></a>
        <a href="#"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
      </div>
    </div>

    <div class="footer-columns">
      @foreach($footerCategories as $category => $links)
        <div class="footer-col">
          <div class="footer-heading">{{ $category }}</div>
          <ul class="footer-list">
            @foreach($links as $item)
              <li><a href="{{ $item['href'] }}">{{ $item['label'] }}</a></li>
            @endforeach
          </ul>
        </div>
      @endforeach
    </div>
  </div>

  <div class="footer-bottom">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
      <div class="small text-muted">&copy; {{ date('Y') }} Nexora Tools · Tripathi Nexora Technologies. All rights reserved.</div>
      <div class="footer-bottom-links small">
        <a href="#">Privacy</a>
        <a href="#">Terms</a>
        <a href="#">Support</a>
      </div>
    </div>
  </div>
</footer>
