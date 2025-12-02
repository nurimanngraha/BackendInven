@extends('layouts.auth')

@section('title', 'Login - SIBANGSAT')

@section('content')
<img src="{{ asset('images/sanditel-logo.png') }}" alt="Logo" style="width: 120px; height: auto; display: block; margin: 0 auto 10px;">

<h3 class="auth-title">SIBANGSAT</h3>
<div class="auth-sub">Sistem Invetaris Barang Sanditel</div>

    {{-- 🔔 Toast Notification (Benar-benar di tengah) --}}
@if (session('success') || session('error'))
<div class="toast-container">
    <div id="toast"
         class="toast-box {{ session('success') ? 'toast-success' : 'toast-error' }}">
        {{ session('success') ?? session('error') }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toast = document.getElementById('toast');
        if (toast) {
            toast.style.opacity = "0";
            toast.style.transform = "translateY(-10px)";
            setTimeout(() => {
                toast.style.opacity = "1";
                toast.style.transform = "translateY(0)";
            }, 100);
            setTimeout(() => {
                toast.style.opacity = "0";
                toast.style.transform = "translateY(-10px)";
                setTimeout(() => toast.remove(), 500);
            }, 5000);
        }
    });
</script>
@endif

<style>
    body {
        background: url("{{ asset('images/gedung-sate.png') }}") no-repeat center center fixed;
        background-size: cover;
        background-attachment: fixed;
        font-family: 'Inter', sans-serif;
    }

    .auth-container {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(4px);
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    
    /* === Toast Container === */
    .toast-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    position: relative;
    margin-top: 20px; /* jarak dari teks "Sistem terpadu..." */
    margin-bottom: 10px;
    text-align: center;
    }

    /* === Toast Box === */
    .toast-box {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.5s ease-in-out;
    text-align: center;
    color: #fff;
    min-width: 220px;
    max-width: 80%;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
    }

    .toast-success {
        background-color: #28a745; /* hijau Bootstrap */
    }

    .toast-error {
        background-color: #dc3545; /* merah Bootstrap */
    }
</style>


<form method="POST" action="{{ route('login') }}">
  @csrf
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="text" name="email" class="form-control" placeholder="Email" required autofocus>
  </div>
  <div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control" placeholder="password" required>
  </div>

  <div class="d-grid">
    <button class="btn btn-primary">→ Login</button>
  </div>

  <a class="small-link" href="{{ route('password.request') }}">Lupa password?</a>
</form>
@endsection
