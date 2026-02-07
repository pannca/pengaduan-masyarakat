@extends('home')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <div class="card p-4 shadow-sm">
                    <h5 class="mb-3">Pencarian dan Ekspor Data</h5>

                    <!-- Form untuk ekspor -->
                    <form action="{{ route('response.export') }}" method="GET" id="exportForm">
                        @if (auth()->user()->role === 'STAFF')
                            <div class="mb-3">
                                <label for="regency" class="form-label">Export Data Berdasarkan Kabupaten/Kota:</label>
                                <select name="regency" id="regency" class="form-select">
                                    <option value="all">Semua Kabupaten/Kota</option>
                                </select>
                            </div>
                        @else
                            <div class="mb-3">
                                <label for="province" class="form-label">Export Data Berdasarkan Provinsi:</label>
                                <select name="province" id="province" class="form-select">
                                    <option value="all">Semua Provinsi</option>
                                </select>
                            </div>
                        @endif
                        <button type="submit" class="btn btn-success"><i class="fas fa-download"></i> Export CSV</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse($responses as $index => $report)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm border-0 rounded">
                        <img src="{{ $report->image_url }}"
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            @if (auth()->user()->role === 'STAFF')
                // Load kabupaten untuk STAFF berdasarkan provinsi mereka
                const provinceId = '{{ $staffProvince ?? "" }}';
                
                if (provinceId) {
                    $.ajax({
                        url: `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`,
                        method: 'GET',
                        success: function(data) {
                            data.forEach(function(regency) {
                                $('#regency').append(
                                    `<option value="${regency.id}">${regency.name}</option>`
                                );
                            });
                        },
                        error: function() {
                            console.error('Gagal mengambil data kabupaten.');
                        }
                    });
                }

                // Validasi sebelum export untuk STAFF
                $('#exportForm').on('submit', function(e) {
                    const regencyId = $('#regency').val();
                    
                    if (regencyId !== 'all') {
                        e.preventDefault();
                        
                        // Cek apakah ada laporan di kabupaten tersebut
                        $.ajax({
                            url: '{{ route("response.check") }}',
                            method: 'GET',
                            data: { regency: regencyId },
                            success: function(response) {
                                if (response.count === 0) {
                                    alert('Tidak ada keluhan di kabupaten/kota yang dipilih!');
                                } else {
                                    $('#exportForm').off('submit').submit();
                                }
                            },
                            error: function() {
                                alert('Gagal memeriksa data. Silakan coba lagi.');
                            }
                        });
                    }
                });
            @else
                // Load provinsi untuk HEAD_STAFF
                $.ajax({
                    url: 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json',
                    method: 'GET',
                    success: function(data) {
                        data.forEach(function(province) {
                            $('#province').append(
                                `<option value="${province.id}">${province.name}</option>`
                            );
                        });
                    },
                    error: function() {
                        console.error('Gagal mengambil data provinsi.');
                    }
                });

                // Validasi sebelum export untuk HEAD_STAFF
                $('#exportForm').on('submit', function(e) {
                    const provinceId = $('#province').val();
                    
                    if (provinceId !== 'all') {
                        e.preventDefault();
                        
                        $.ajax({
                            url: '{{ route("response.check") }}',
                            method: 'GET',
                            data: { province: provinceId },
                            success: function(response) {
                                if (response.count === 0) {
                                    alert('Tidak ada keluhan di provinsi yang dipilih!');
                                } else {
                                    $('#exportForm').off('submit').submit();
                                }
                            },
                            error: function() {
                                alert('Gagal memeriksa data. Silakan coba lagi.');
                            }
                        });
                    }
                });
            @endif
        });
    </script>
@endsection
