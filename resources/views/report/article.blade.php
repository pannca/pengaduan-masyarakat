@extends('home')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Header -->
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary"><i class="fas fa-tasks me-2"></i> Daftar Keluhan Warga</h2>
            <div>
                <a href="{{ route('reports.create') }}" class="btn btn-success shadow-sm me-2">
                    <i class="fas fa-plus-circle me-1"></i> Tambah Keluhan
                </a>
                <a href="{{ route('reports.detail') }}" class="btn btn-info shadow-sm">
                    <i class="fas fa-info-circle me-1"></i> Keluhan Saya
                </a>
            </div>
        </div>

        <!-- Search Form -->
        <form action="{{ route('reports.search') }}" method="GET" class="mb-4">
            @csrf
            <div class="row g-2">
                <div class="col-md-4">
                    <select name="search" id="provinsi" class="form-select shadow-sm">
                        <option value="">Pilih Provinsi</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 shadow-sm">
                        <i class="fas fa-search me-1"></i> Cari
                    </button>
                </div>
            </div>
        </form>

        <!-- Success Alert -->
        @if (session('success'))
            <div class="alert alert-success d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Reports List -->
        @if ($reports->isEmpty())
            <div class="alert alert-warning text-center">
                <i class="fas fa-exclamation-circle me-2"></i> Data tidak ditemukan.
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($reports as $report)
                    <div class="col">
                        <div class="card shadow-sm border-0 h-100 hover-card" style="border-radius: 15px; overflow: hidden;">
                            <img src="{{ $report->image_url }}" class="card-img-top"
                                style="object-fit: cover; height: 200px;" alt="Laporan Gambar">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <h5 class="card-title fw-bold text-truncate">
                                    <a href="{{ route('reports.index', $report->id) }}" class="text-primary text-decoration-none">
                                        {{ $report->description ?? 'Deskripsi tidak tersedia' }}
                                    </a>
                                </h5>
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-envelope me-1"></i>
                                    {{ $report->user->email ?? 'Email tidak tersedia' }}
                                </p>
                                <p class="text-muted small mb-2">
                                    {{ $report->province_name ?? 'Provinsi tidak ditemukan' }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i> {{ $report->created_at->diffForHumans() }}
                                    </small>
                                    <div class="d-flex align-items-center">
                                        <form action="{{ route('reports.vote', $report->id) }}" method="POST" class="me-2">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-heart"></i>
                                                <span id="voting-count-{{ $report->id }}" class="ms-1">
                                                    {{ is_array($report->voting) ? count($report->voting) : 0 }}
                                                </span>
                                            </button>
                                        </form>
                                        <span class="badge bg-info"><i class="fas fa-eye me-1"></i> {{ $report->viewers ?? 0 }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

<!-- External Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        // Fetch provinsi data
        $.ajax({
            url: 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                data.forEach(province => {
                    $('#provinsi').append(
                        `<option value="${province.id}">${province.name}</option>`
                    );
                });
            }
        });
    });
</script>

<style>
    .hover-card {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .hover-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .card-title a {
        transition: color 0.3s ease;
    }

    .card-title a:hover {
        color: #0d6efd;
    }
</style>

