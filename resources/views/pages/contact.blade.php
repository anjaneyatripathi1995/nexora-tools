@extends('layouts.site')

@php
    $site = config('nexora.site');
    $pageTitle = 'Contact Us';
    $pageDesc = 'Contact Nexora Tools for support, partnership or feature requests.';
    $canonical = route('contact');
@endphp

@section('content')
<div class="sub-banner">
    <div class="container">
        <div class="sub-banner-inner">
            <h1>Contact Us</h1>
            <p>We read every message — don't hesitate to reach out!</p>
        </div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 1.6fr;gap:48px;align-items:start;max-width:960px;margin:0 auto">
            <div>
                <h3 style="margin-bottom:24px">Get in touch</h3>
                @php
                    $rows = [
                        ['📧','Email',$site['email'] ?? ''],
                        ['🌐','Website',$site['domain'] ?? ''],
                        ['🏢','Company',$site['company'] ?? ''],
                        ['⏱️','Response','Within 1–2 business days'],
                    ];
                @endphp
                @foreach ($rows as [$ic,$label,$val])
                    <div style="display:flex;gap:14px;align-items:flex-start;margin-bottom:20px">
                        <span style="font-size:1.4rem">{{ $ic }}</span>
                        <div>
                            <div style="font-weight:600;margin-bottom:2px">{{ $label }}</div>
                            <span style="color:var(--text-2);font-size:.9rem">{{ $val }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="tool-wrap">
                @if (!empty($success))
                    <div class="alert alert-success">{{ $success }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-error">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('contact') }}">
                    @csrf
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                        <div class="form-group">
                            <label class="form-label">Name *</label>
                            <input type="text" name="name" class="form-input" required placeholder="Your name" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-input" required placeholder="you@example.com" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-input" placeholder="What's this about?" value="{{ old('subject') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Message *</label>
                        <textarea name="message" class="form-textarea" required placeholder="Your message…">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-full btn-lg">Send Message →</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
