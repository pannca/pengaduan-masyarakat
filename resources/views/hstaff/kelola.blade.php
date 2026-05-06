@extends('home')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kelola Akun Staff</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                background-color: #f8f9fa;
            }

            .container {
                margin-top: 30px;
            }

            .card {
                border-radius: 12px;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            }

            .card-header {
                background-color: #007bff;
                color: #fff;
                font-weight: bold;
                border-top-left-radius: 12px;
                border-top-right-radius: 12px;
            }

            .btn-primary {
                background-color: #0d6efd;
                border: none;
            }

            .btn-danger {
                background-color: #dc3545;
                border: none;
            }

            .btn-success {
                background-color: #198754;
                border: none;
            }

            .table th {
                background-color: #f1f1f1;
                color: #333;
            }

            .table td,
            .table th {
                vertical-align: middle;
            }

            .form-control {
                border-radius: 8px;
            }

            .btn {
                border-radius: 8px;
            }

            h3 {
                color: #333;
                font-weight: bold;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <h3 class="mb-4 text-center">Kelola Akun Staff</h3>
            <div class="row g-4">
                <!-- Daftar Akun Staff -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header text-center">
                            Daftar Akun Staff
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session('deleted'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('deleted') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Email</th>
                                        <th>Provinsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user as $index => $staff)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $staff->user->email }}</td>
                                            <td>{{ $staff->province }}</td>
                                            <td>
                                                <a href="{{ route('staffprovinces.reset', $staff->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-redo"></i> Reset Password
                                                </a>
                                                <form action="{{ route('staffprovinces.delete', $staff['id']) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Form Buat Akun Staff -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header text-center">
                            Buat Akun Staff
                        </div>
                        <div class="card-body">
                            <form action="{{ route('staffprovinces.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="province" class="form-label">Provinsi</label>
                                    <select name="province" class="form-control" required>
                                        <option value="">-- Pilih Provinsi --</option>
                                        @foreach ($provinsi as $province)
                                            <option value="{{ $province['id'] }}">{{ $province['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Sandi</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-plus-circle"></i> Buat Akun
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    </body>

    </html>
@endsection
