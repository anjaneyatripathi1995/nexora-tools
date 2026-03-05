@extends('layouts.app')
@section('title','Careers — Tripathi Nexora Technologies')
@section('content')
<div class="sub-banner"><div class="sub-banner__overlay"></div><div class="container"><div class="sub-banner__content"><div class="sub-banner__anim"><h1 class="sub-banner__title">Careers at <span class="text-primary">Nexora</span></h1><p class="sub-banner__sub">Join us in building the next era of digital innovation.</p></div></div></div></div>
<section class="py-5"><div class="container"><div class="row justify-content-center text-center"><div class="col-lg-7">
    <div class="mb-5">
        <i class="fa-solid fa-rocket fa-4x text-primary mb-4 d-block"></i>
        <h3 class="fw-800 mb-3">We're Growing Fast</h3>
        <p class="text-muted lh-lg">Tripathi Nexora Technologies is on a mission to build the next generation of digital products. We're always looking for talented people who are passionate about technology, design, and creating meaningful digital experiences.</p>
    </div>
    <div class="alert alert-info d-flex gap-3 align-items-start text-start mb-5">
        <i class="fa-solid fa-circle-info mt-1 flex-shrink-0 text-primary"></i>
        <span>No open positions right now — but we're always open to hearing from talented developers, designers, and creators. Send your portfolio to <a href="mailto:contact@tripathinexora.com" class="fw-600">contact@tripathinexora.com</a></span>
    </div>
    <div class="row g-3">
        @foreach(['Laravel Developer','React / Vue Developer','UI/UX Designer','Content Writer','SEO Specialist'] as $role)
        <div class="col-sm-6"><div class="card border-0 shadow-sm p-3 text-start"><div class="d-flex align-items-center gap-3"><div class="rounded-3 bg-primary bg-opacity-10 p-2"><i class="fa-solid fa-user-tie text-primary"></i></div><div><div class="fw-700 small">{{ $role }}</div><div class="text-muted" style="font-size:.75rem">Open to enquiries · Remote</div></div></div></div></div>
        @endforeach
    </div>
    <a href="mailto:contact@tripathinexora.com?subject=Careers%20Enquiry" class="btn btn-primary mt-4 px-5"><i class="fa-solid fa-envelope me-2"></i>Send Your CV</a>
</div></div></div></section>
@endsection
