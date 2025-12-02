@extends('layouts.auth')

@section('title','Reset Password - SIBANGSAT')

@section('content')

<style>
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

.alert {
    border-radius: 8px;
    font-weight: 500;
    margin-bottom: 10px;
    padding: 12px 16px;
}

.alert-success {
    background-color: #d1e7dd;
    color: #0f5132;
    border: 1px solid #badbcc;
}

.alert-danger {
    background-color: #f8d7da;
    color: #842029;
    border: 1px solid #f5c2c7;
}
</style>

<img src="{{ asset('images/sanditel-logo.png') }}" alt="Logo" style="width: 120px; height: auto; display: block; margin: 0 auto 10px;">
<h3 class="auth-title">Atur Ulang Password</h3>
<div class="auth-sub">Masukkan password baru untuk akunmu</div>


{{-- Notifikasi --}}
@if (session('status'))
    <div class="alert alert-success text-center">{{ session('status') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger text-center">
        @foreach ($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('password.update') }}">
  @csrf
  <input type="hidden" name="token" value="{{ $token }}">
  <input type="hidden" name="email" value="{{ $email }}">
  <div class="mb-3">
    <label class="form-label">Password Baru</label>
    <input type="password" name="password" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Konfirmasi Password</label>
    <input type="password" name="password_confirmation" class="form-control" required>
  </div>

  <div class="d-grid">
    <button class="btn btn-primary">Simpan Password</button>
  </div>
</form>
@endsection
