{{-- @extends('home')

@section('content')
    <div class="container my-5">
        <!-- Header Halaman -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-secondary">Daftar Pengaduan</h3>
            <div class="dropdown">
                <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="exportDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-export me-1"></i> Export (.xlsx)
                </button>
                <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                    <li><a class="dropdown-item" href="#">Export Semua</a></li>
                    <li><a class="dropdown-item" href="#">Export Terpilih</a></li>
                </ul>
            </div>
        </div>

        <!-- Tabel Pengaduan -->
        <div class="table-responsive shadow rounded">
            <table class="table table-bordered table-hover align-middle text-center mb-0">
                <thead class="table-light border-0">
                    <tr>
                        <th scope="col" class="text-start ps-4">Gambar & Pengirim</th>
                        <th scope="col">Lokasi & Tanggal</th>
                        <th scope="col" style="width: 30%;">Deskripsi</th>
                        <th scope="col">
                            <div class="d-flex justify-content-center align-items-center">
                                Jumlah Vote
                                <!-- Tanda Panah untuk Sorting -->
                                <div class="d-flex flex-column ms-2">
                                    <!-- Panah Naik -->
                                    <a href="{{ route('staffprovinces.index', ['sort' => 'votes', 'order' => 'asc']) }}"
                                        class="text-decoration-none text-dark {{ $order === 'asc' && $sortBy === 'votes' ? 'fw-bold' : '' }}">
                                        ▲
                                    </a>
                                    <!-- Panah Turun -->
                                    <a href="{{ route('staffprovinces.index', ['sort' => 'votes', 'order' => 'desc']) }}"
                                        class="text-decoration-none text-dark {{ $order === 'desc' && $sortBy === 'votes' ? 'fw-bold' : '' }}">
                                        ▼
                                    </a>
                                </div>
                            </div>
                        </th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($provinsi as $item)
                        <tr>
                            <!-- Gambar & Pengirim -->
                            <td class="text-start ps-4">
                                <div class="d-flex align-items-center">
                                    <!-- Gambar -->
                                    <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/default-image.jpg') }}"
                                        alt="Gambar Pengaduan" class="rounded-circle border me-3"
                                        style="width: 60px; height: 60px; object-fit: cover; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">

                                    <!-- Nama Pengirim -->
                                    <div>
                                        <span class="fw-bold text-primary d-block">{{ $item->user->email ?? 'Anonim' }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Lokasi & Tanggal -->
                            <td>
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $item->location ?? 'Lokasi Tidak Tersedia' }}<br>
                                    <i class="fas fa-calendar-alt me-1"></i>{{ $item->created_at ? $item->created_at->format('d F Y') : 'Tidak Ada Tanggal' }}
                                </small>
                            </td>

                            <!-- Deskripsi -->
                            <td class="text-start">
                                <p class="m-0">{{ Str::limit($item->description, 50, '...') }}</p>
                            </td>

                            <!-- Jumlah Vote -->
                            <td>
                                <span class="badge bg-success fs-6 py-2 px-3 shadow-sm">
                                    <i class="fas fa-thumbs-up me-1"></i>{{ $item->votes ?? 0 }}
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                        id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="actionDropdown">
                                        <li><a class="dropdown-item" href="{{ route('response.show', $item->id) }}">Detail</a></li>
                                        <li><a class="dropdown-item" href="#">Edit</a></li>
                                        <li>
                                            <form action="#" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item text-danger" type="submit">Hapus</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection --}}
