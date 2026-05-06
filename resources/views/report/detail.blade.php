@extends('home')

@section('content')
    <div class="container my-5">
        @foreach ($reports as $report)
            <div class="card shadow-lg border-0 rounded-4 mb-4">
                <div class="card-header bg-primary text-white rounded-top">
                    <h5 class="fw-bold m-0">{{ $report->created_at->format('d F Y') }}</h5>
                </div>

                <div class="card-body">
                    <!-- Tabs Navigasi -->
                    <ul class="nav nav-pills mb-4" id="pengaduanTabs-{{ $report->id }}" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="data-tab-{{ $report->id }}" data-bs-toggle="pill"
                                href="#data-{{ $report->id }}" role="tab">
                                <i class="fas fa-info-circle me-2"></i>Data
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="gambar-tab-{{ $report->id }}" data-bs-toggle="pill"
                                href="#gambar-{{ $report->id }}" role="tab">
                                <i class="fas fa-image me-2"></i>Gambar
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="status-tab-{{ $report->id }}" data-bs-toggle="pill"
                                href="#status-{{ $report->id }}" role="tab">
                                <i class="fas fa-clipboard-check me-2"></i>Status
                            </a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Data Tab -->
                        <div class="tab-pane fade show active" id="data-{{ $report->id }}" role="tabpanel">
                            <h6 class="text-primary"><strong>Data Pengaduan</strong></h6>
                            <ul class="list-unstyled">
                                <li><strong>Tipe:</strong> {{ $report->type }}</li>
                                <li><strong>Lokasi:</strong> {{ $report->province }}</li>
                                <li><strong>Deskripsi:</strong> {{ $report->description }}</li>
                            </ul>
                        </div>

                        <!-- Gambar Tab -->
                        <div class="tab-pane fade" id="gambar-{{ $report->id }}" role="tabpanel">
                            <h6 class="text-primary"><strong>Gambar Pendukung</strong></h6>
                            <div class="d-flex justify-content-center">
                                <img src="{{ $report->image_url }}" alt="Gambar Pengaduan"
                                    class="img-fluid rounded shadow-sm" style="max-width: 100%; height: auto;">
                            </div>
                        </div>

                        <!-- Status Tab -->
                        <div class="tab-pane fade" id="status-{{ $report->id }}" role="tabpanel">
                            <h6 class="text-primary"><strong>Status Pengaduan</strong></h6>
                            <strong>Status:</strong>
                            <span
                                class="badge {{ $report->response?->response_status == 'DONE' ? 'bg-success' : ($report->response?->response_status == 'REJECT' ? 'bg-danger' : ($report->response?->response_status == 'ON_PROCESS' ? 'bg-primary' : 'bg-warning')) }}">
                                {{ ucfirst($report->response?->response_status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-start mt-4">
                        <button onclick="window.history.back();" class="btn btn-secondary me-2">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </button>
                        @if (!$report->response)
                            <form action="{{ route('reports.destroy', $report->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash-alt me-2"></i>Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
