@extends('home')

@section('content')

<!-- Menggunakan Bootstrap Container untuk layout yang rapi -->
<div class="container my-5">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h1 class="display-4 text-primary">Jumlah Pengaduan Dan Tanggapan</h1>
        </div>
    </div>

    <a href="{{ route('staffprovinces.kelola') }}" class="btn btn-primary mb-3">Kelola Akun</a>
    <!-- Membuat Chart untuk Provinsi -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">Laporan per Provinsi</h5>
                </div>
                <div class="card-body">
                    <canvas id="provinceChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Menggunakan CDN Chart.js untuk membuat grafik -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data dari controller
    const reportByProvince = @json($reportByProvince);

    // Chart untuk provinsi
    const provinceCtx = document.getElementById('provinceChart').getContext('2d');
    new Chart(provinceCtx, {
        type: 'bar', // Tipe chart
        data: {
            labels: Object.keys(reportByProvince), // Labels: Nama Provinsi
            datasets: [{
                label: 'Total Laporan',
                data: Object.values(reportByProvince), // Data total per provinsi
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true // Mulai dari 0
                }
            }
        }
    });
</script>

@endsection
