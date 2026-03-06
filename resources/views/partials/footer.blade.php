@php
  $popularTools = [
    ['label' => 'JSON Formatter',      'slug' => 'json-formatter'],
    ['label' => 'Password Generator',  'slug' => 'password-generator'],
    ['label' => 'PDF to Word',         'slug' => 'pdf-to-word'],
    ['label' => 'Image Resizer',       'slug' => 'image-resizer'],
    ['label' => 'EMI Calculator',      'slug' => 'emi-calculator'],
    ['label' => 'Word Counter',        'slug' => 'word-counter'],
  ];

  $footerCategories = [
    ['label' => 'Developer',      'hash' => 'developer'],
    ['label' => 'PDF & File',     'hash' => 'pdf'],
    ['label' => 'Text & Content', 'hash' => 'text'],
    ['label' => 'Image Tools',    'hash' => 'image'],
    ['label' => 'SEO Tools',      'hash' => 'seo'],
    ['label' => 'Finance & Date', 'hash' => 'finance'],
    ['label' => 'AI Tools',       'hash' => 'ai'],
  ];

  $companyLinks = [
    ['label' => 'About Us',        'href' => route('about')],
    ['label' => 'Contact',         'href' => url('/contact')],
    ['label' => 'Privacy Policy',  'href' => route('privacy')],
    ['label' => 'Terms of Service','href' => route('terms')],
    ['label' => 'Support',         'href' => 'mailto:support@tripathinexora.com'],
  ];

  $tagline = config('app.tagline', 'Your Complete Tech Solution Hub');
@endphp

<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="{{ url('/') }}" class="footer-logo">
          <span class="nav-logo-icon">N</span>
          <span class="logo-nexora">Nexora</span>
          <span class="logo-badge">Tools</span>
        </a>
        <p class="footer-tagline">{{ $tagline }}. Free online tools for developers, designers, and everyone.</p>
        <div class="footer-social">
          <a href="https://x.com" class="social-link" aria-label="X / Twitter"><i class="fa-brands fa-x-twitter"></i></a>
          <a href="https://www.linkedin.com/company/tripathi-nexora" class="social-link" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          <a href="https://github.com/anjaneyatripathi1995/nexora-tools" class="social-link" aria-label="GitHub"><i class="fab fa-github"></i></a>
        </div>
      </div>

      <div class="footer-col">
        <h4 class="footer-heading">Popular Tools</h4>
        <ul class="footer-links">
          @foreach($popularTools as $tool)
            <li><a href="{{ route('tools.show', $tool['slug']) }}">{{ $tool['label'] }}</a></li>
          @endforeach
        </ul>
      </div>

      <div class="footer-col">
        <h4 class="footer-heading">Categories</h4>
        <ul class="footer-links">
          @foreach($footerCategories as $cat)
            <li><a href="{{ url('/tools#' . $cat['hash']) }}">{{ $cat['label'] }}</a></li>
          @endforeach
        </ul>
      </div>

      <div class="footer-col">
        <h4 class="footer-heading">Company</h4>
        <ul class="footer-links">
          @foreach($companyLinks as $link)
            <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
          @endforeach
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <p class="mb-0">&copy; {{ now()->year }} Tripathi Nexora Technologies. All rights reserved.</p>
      <p class="mb-0">Made with <span style="color:#ef4444;">&#10084;</span> in India &nbsp;&middot;&nbsp; <a href="{{ route('privacy') }}">Privacy</a> &nbsp;&middot;&nbsp; <a href="{{ route('terms') }}">Terms</a></p>
    </div>
  </div>
</footer>
