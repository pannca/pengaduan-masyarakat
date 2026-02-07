@extends('home')

@section('content')
<div class="d-flex justify-content-center align-items-center">
    <div class="card shadow-lg p-4" style="max-width: 400px; margin-top: 50px;">
        <h3 class="text-center mb-4">Daftar Akun</h3>

        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" required value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-success w-100">
                <i class="fas fa-user-plus"></i> Daftar
            </button>

            <hr>

            <a href="{{ route('login') }}" class="btn btn-secondary w-100">
                <i class="fas fa-arrow-left"></i> Kembali ke Login
            </a>
        </form>
    </div>
</div>
@endsection
