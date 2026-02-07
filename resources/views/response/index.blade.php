@extends('home')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <div class="card p-4 shadow-sm">
                    <h5 class="mb-3">Pencarian dan Ekspor Data</h5>

                    <!-- Form untuk ekspor -->
                    <form method="GET" action="{{ route('report.export') }}" class="row g-3 mt-3">
                        <div class="col-md-8">
                            <label for="province-export" class="form-label">Export Data Berdasarkan Provinsi:</label>
                            <select name="province" id="province-export" class="form-select">
                                <option value="">Semua Provinsi</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-success w-100" id="export-button" disabled>Export
                                Excel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse($responses as $index => $report)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm border-0 rounded">
                        <img src="{{ asset('storage/' . ($report->image ?? 'default.jpg')) }}"
                            alt="Image of {{ $report->user->email ?? 'No Name' }}" class="card-img-top rounded-top"
                            style="object-fit: cover; height: 200px;">
                        <div class="card-body">
                            <h6 class="card-title text-truncate"
                                title="{{ $report->user->email ?? 'Nama tidak tersedia' }}">
                                {{ $report->user->email ?? 'Nama tidak tersedia' }}
                            </h6>
                            <p class="card-text text-muted text-truncate"
                                title="{{ $report->description ?? 'Deskripsi tidak tersedia' }}">
                                {{ $report->description ?? 'Deskripsi tidak tersedia' }}
                            </p>
                            <div class="text-end">
                                <a href="{{ route('response.show', ['id' => $report->id]) }}"
                                    class="btn btn-primary btn-sm">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center" role="alert">
                        Tidak ada laporan yang tersedia.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    @push('script')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script>
            $(document).ready(function() {
                const apiURL = 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json';

                // Fungsi untuk mengambil data provinsi dan mengisi dropdown
                function fetchProvinces(selectElementId) {
                    $.ajax({
                        url: apiURL,
                        method: 'GET',
                        success: function(data) {
                            // Tambahkan opsi ke dropdown
                            data.forEach(function(province) {
                                $(selectElementId).append(
                                    `<option value="${province.id}">${province.name}</option>`
                                );
                            });
                        },
                        error: function() {
                            console.error('Gagal mengambil data provinsi.');
                        }
                    });
                }

                // Ambil data provinsi untuk dropdown search dan export
                fetchProvinces('#province-search');
                fetchProvinces('#province-export');

                // Aktifkan tombol export jika provinsi dipilih
                $('#province-export').on('change', function() {
                    const isSelected = $(this).val() !== '';
                    $('#export-button').prop('disabled', !isSelected);
                });
            });
        </script>
    @endpush
@endsection
