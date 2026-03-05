@extends('layouts.app')

@section('title', 'Love Calculator')

@section('content')
<div class="container py-5 mt-5">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="project-detail-card">
                <div class="text-center mb-4">
                    <i class="fa-solid fa-heart fa-5x text-danger mb-3"></i>
                    <h1 class="display-4 fw-bold">Love Calculator</h1>
                    <p class="lead text-muted">Calculate compatibility between names</p>
                </div>

                <div class="mb-4">
                    <form id="loveCalculatorForm">
                        <div class="mb-3">
                            <label for="name1" class="form-label fw-bold">First Name</label>
                            <input type="text" class="form-control bg-dark text-light" id="name1" placeholder="Enter first name" required>
                        </div>
                        <div class="mb-3">
                            <label for="name2" class="form-label fw-bold">Second Name</label>
                            <input type="text" class="form-control bg-dark text-light" id="name2" placeholder="Enter second name" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-danger btn-lg">
                                <i class="fa-solid fa-heart me-2"></i>Calculate Love
                            </button>
                        </div>
                    </form>
                </div>

                <div id="loveResult" class="mt-4 text-center" style="display: none;">
                    <div class="alert alert-danger">
                        <h2 id="lovePercentage" class="display-1 fw-bold mb-3">0%</h2>
                        <p id="loveMessage" class="lead"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('loveCalculatorForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const name1 = document.getElementById('name1').value.toLowerCase();
        const name2 = document.getElementById('name2').value.toLowerCase();
        
        // Simple love calculator algorithm
        const combined = name1 + name2;
        let score = 0;
        for (let i = 0; i < combined.length; i++) {
            score += combined.charCodeAt(i);
        }
        const percentage = (score % 100);
        
        let message = '';
        if (percentage >= 80) {
            message = 'Perfect Match! 💕';
        } else if (percentage >= 60) {
            message = 'Great Compatibility! ❤️';
        } else if (percentage >= 40) {
            message = 'Good Match! 💖';
        } else {
            message = 'Keep Trying! 💔';
        }
        
        document.getElementById('lovePercentage').textContent = percentage + '%';
        document.getElementById('loveMessage').textContent = message;
        document.getElementById('loveResult').style.display = 'block';
    });
</script>
@endpush
@endsection
