@extends('layouts.auth')

@section('title','Forgot Password - SINTEL')

@section('content')
<img src="{{ asset('images/sanditel-logo.png') }}" alt="Logo" 
     style="width: 120px; height: auto; display: block; margin: 0 auto 10px;">
<h3 class="auth-title">Reset Password</h3>
<div class="auth-sub">Masukkan emailmu untuk menerima link reset password</div>

{{-- 🔔 Toast Notification --}}
@if (session('status') || session('success') || session('error') || $errors->any())
  @php
      $toastClass = 'toast-error'; // default merah
      if (session('status') || session('success')) $toastClass = 'toast-success';
  @endphp

  {{-- Diletakkan tepat di bawah subtitle --}}
  <div id="toast" class="{{ $toastClass }}">
      {{ session('status') ?? session('success') ?? session('error') ?? $errors->first() }}
  </div>

  <script>
      document.addEventListener('DOMContentLoaded', () => {
          const toast = document.getElementById('toast');
          if (toast) {
              setTimeout(() => toast.classList.add('show'), 100);
              setTimeout(() => {
                  toast.classList.remove('show');
                  setTimeout(() => toast.remove(), 600);
              }, 10000);
          }
      });
  </script>
@endif


<form method="POST" action="{{ route('password.email') }}">
  @csrf
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" placeholder="email@domain.com" required>
  </div>

  <div class="d-grid">
    <button class="btn btn-primary">Kirim Link Reset</button>
  </div>

  <a class="small-link" href="{{ route('login') }}">Kembali ke Login</a>
</form>

<style>
  /* 🔔 Toast style */
  #toast {
      position: relative; /* biar muncul di bawah subtitle, bukan absolute layar */
      margin: 10px auto 0 auto; /* jarak dari subtitle */
      display: block;
      width: fit-content;
      min-width: 300px;
      text-align: center;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: 600;
      color: white;
      opacity: 0;
      transform: translateY(-15px);
      transition: all 0.5s ease;
  }

  #toast.show {
      opacity: 1;
      transform: translateY(0);
  }

  .toast-success {
      background-color: #28a745;
  }

  .toast-error {
      background-color: #dc3545;
  }

  body {
      background: url("{{ asset('images/gedung-sate.png') }}") no-repeat center center fixed;
      background-size: cover;
      background-attachment: fixed;
      font-family: 'Inter', sans-serif;
  }

  .auth-container {
      background: rgba(255, 255, 255, 0.92);
      backdrop-filter: blur(6px);
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }

  .small-link {
      display: block;
      text-align: center;
      color: #007bff;
      margin-top: 10px;
      text-decoration: none;
  }

  .small-link:hover {
      text-decoration: underline;
  }
</style>
@endsection
