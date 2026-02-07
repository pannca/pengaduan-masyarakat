@extends('home')

@section('content')
<div class="d-flex justify-content-center align-items-center">
    <div class="card shadow-lg p-4" style="max-width: 400px; margin-top: 50px;">
        <h3 class="text-center mb-4">Login / Daftar Akun</h3>
        
        <!-- Pesan error atau sukses -->
        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login.register') }}" method="POST">
            @csrf

            <!-- Input email -->
            <div class="mb-3">
                <label for="email" class="form-label">Masukkan Email</label>
                <input type="email" name="email" class="form-control" id="email" required value="{{ old('email') }}">
            </div>

            <!-- Input password -->
            <div class="mb-3">
                <label for="password" class="form-label">Masukkan Kata Sandi</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>

            <!-- Tombol Login dengan Icon -->
            <button type="submit" name="login" class="btn btn-primary w-100">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>

            <hr>

            <!-- Tombol Register dengan Icon -->
            <button type="submit" name="register" class="btn btn-success w-100">
                <i class="fas fa-user-plus"></i> Daftar Akun
            </button>
        </form>
    </div>
</div>
@endsection
