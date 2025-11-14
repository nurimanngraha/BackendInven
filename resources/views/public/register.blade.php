@extends('layouts.auth')

@section('title', 'Register - Sanditel Apps')

@section('content')

<img src="{{ asset('images/sanditel-logo.png') }}" alt="Logo" 
     style="width: 120px; height: auto; display: block; margin: 0 auto 10px;">

<h3 class="auth-title">Sign Up</h3>
<div class="auth-sub">Buat akun untuk mengakses Sanditel Apps</div>

{{-- 🔔 Alert Notifikasi (Opsi 1 - Tanpa animasi, langsung tampil di bawah subtitle) --}}
@if (session('success'))
  <div class="alert alert-success"
       style="background-color: rgba(0, 128, 0, 0.1); color: #0f5132; border: 1px solid #0f5132;
              border-radius: 6px; padding: 10px 15px; text-align: center; margin-bottom: 15px; font-weight: 500;">
      {{ session('success') }}
  </div>
@endif

@if (session('error'))
  <div class="alert alert-danger"
       style="background-color: rgba(255, 0, 0, 0.1); color: #b00020; border: 1px solid #b00020;
              border-radius: 6px; padding: 10px 15px; text-align: center; margin-bottom: 15px; font-weight: 500;">
      {{ session('error') }}
  </div>
@endif

@if ($errors->any())
  <div class="alert alert-danger"
       style="background-color: rgba(255, 0, 0, 0.1); color: #b00020; border: 1px solid #b00020;
              border-radius: 6px; padding: 10px 15px; text-align: center; margin-bottom: 15px; font-weight: 500;">
      {{ $errors->first() }}
  </div>
@endif

<form method="POST" action="{{ route('register.store') }}">
  @csrf
  <div class="mb-3">
    <label class="form-label">Nama</label>
    <input type="text" name="name" class="form-control" placeholder="Nama lengkap" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" placeholder="email@domain.com" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control" placeholder="password" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Konfirmasi Password</label>
    <input type="password" name="password_confirmation" class="form-control" placeholder="konfirmasi password" required>
  </div>

  <div class="d-grid">
    <button class="btn btn-primary">Buat Akun</button>
  </div>

  <a class="small-link" href="{{ route('login') }}">Sudah punya akun? Login</a>
</form>

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
