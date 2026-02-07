<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Keluhan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm rounded-3 border-0">
                    <div class="card-body">
                        <h2 class="text-center mb-4 fw-bold text-primary"><i class="fas fa-bell me-2"></i> Form Keluhan</h2>
                        <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- Provinsi -->
                            <div class="mb-3">
                                <label for="province" class="form-label">Provinsi</label>
                                <select id="province" name="province" class="form-select shadow-sm">
                                    <option value="">Pilih Provinsi</option>
                                </select>
                            </div>

                            <!-- Kota/Kabupaten -->
                            <div class="mb-3">
                                <label for="regency" class="form-label">Kota/Kabupaten</label>
                                <select id="regency" name="regency" class="form-select shadow-sm" disabled>
                                    <option value="">Pilih Kota/Kabupaten</option>
                                </select>
                            </div>

                            <!-- Kecamatan -->
                            <div class="mb-3">
                                <label for="subdistrict" class="form-label">Kecamatan</label>
                                <select id="subdistrict" name="subdistrict" class="form-select shadow-sm" disabled>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>

                            <!-- Kelurahan -->
                            <div class="mb-3">
                                <label for="village" class="form-label">Kelurahan</label>
                                <select id="village" name="village" class="form-select shadow-sm" disabled>
                                    <option value="">Pilih Kelurahan</option>
                                </select>
                            </div>

                            <!-- Type -->
                            <div class="mb-3">
                                <label for="type" class="form-label">Tipe Keluhan</label>
                                <select id="type" name="type" class="form-select shadow-sm">
                                    <option value="" hidden>Pilih Type</option>
                                    <option>Pembangunan</option>
                                    <option>Sosial</option>
                                    <option>Kejahatan</option>
                                </select>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Detail Keluhan</label>
                                <textarea id="description" name="description" class="form-control shadow-sm" placeholder="Masukkan deskripsi keluhan" rows="4"></textarea>
                            </div>

                            <!-- Gambar -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar Pendukung</label>
                                <input type="file" id="image" name="image" class="form-control shadow-sm">
                            </div>

                            <!-- Statement Checkbox -->
                            <div class="form-check mb-4">
                                <input type="hidden" name="statement" value="0">
                                <input type="checkbox" id="statement" name="statement" class="form-check-input" value="1">
                                <label for="statement" class="form-check-label">Laporan yang disampaikan sesuai dengan kebenaran</label>
                            </div>

                            <!-- Submit and Cancel Buttons -->
                            <div class="d-flex justify-content-between">
                                <a class="btn btn-secondary" href="{{ route('reports.article') }}">Batal</a>
                                <button type="submit" class="btn btn-primary px-4">Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const PROVINCES_API = "https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json";
            const REGENCIES_API = "https://www.emsifa.com/api-wilayah-indonesia/api/regencies/";
            const DISTRICTS_API = "https://www.emsifa.com/api-wilayah-indonesia/api/districts/";
            const VILLAGES_API = "https://www.emsifa.com/api-wilayah-indonesia/api/villages/";

            // Load Provinsi
            $.ajax({
                url: PROVINCES_API,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    data.forEach(province => {
                        $('#province').append(`<option value="${province.id}">${province.name}</option>`);
                    });
                },
                error: function() {
                    alert('Gagal memuat data provinsi.');
                }
            });

            // Ketika Provinsi Dipilih
            $('#province').on('change', function() {
                const provinsiId = $(this).val();
                $('#regency').empty().append('<option value="">Pilih Kota/Kabupaten</option>').prop('disabled', !provinsiId);
                $('#subdistrict').empty().append('<option value="">Pilih Kecamatan</option>').prop('disabled', true);
                $('#village').empty().append('<option value="">Pilih Kelurahan</option>').prop('disabled',true);

                if (provinsiId) {
                    $.ajax({
                        url: `${REGENCIES_API}${provinsiId}.json`,
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            data.forEach(regency => {
                                $('#regency').append(`<option value="${regency.id}">${regency.name}</option>`);
                            });
                            $('#regency').prop('disabled', false);
                        },
                        error: function() {
                            alert('Gagal memuat data kota/kabupaten.');
                        }
                    });
                }
            });

            // Ketika Kota Dipilih
            $('#regency').on('change', function() {
                const kotaId = $(this).val();
                $('#subdistrict').empty().append('<option value="">Pilih Kecamatan</option>').prop('disabled', !kotaId);
                $('#village').empty().append('<option value="">Pilih Kelurahan</option>').prop('disabled',true);

                if (kotaId) {
                    $.ajax({
                        url: `${DISTRICTS_API}${kotaId}.json`,
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            data.forEach(subdistrict => {
                                $('#subdistrict').append(`<option value="${subdistrict.id}">${subdistrict.name}</option>`);
                            });
                            $('#subdistrict').prop('disabled', false);
                        },
                        error: function() {
                            alert('Gagal memuat data kecamatan.');
                        }
                    });
                }
            });

            // Ketika Kecamatan Dipilih
            $('#subdistrict').on('change', function() {
                const kecamatanId = $(this).val();
                $('#village').empty().append('<option value="">Pilih Kelurahan</option>').prop('disabled', !kecamatanId);

                if (kecamatanId) {
                    $.ajax({
                        url: `${VILLAGES_API}${kecamatanId}.json`,
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            data.forEach(village => {
                                $('#village').append(`<option value="${village.id}">${village.name}</option>`);
                            });
                            $('#village').prop('disabled', false);
                        },
                        error: function() {
                            alert('Gagal memuat data kelurahan.');
                        }
                    });
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
