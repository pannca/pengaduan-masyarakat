@extends('home')
@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJX6DjhS2R8OCk4U6X5fL9pGiFlu82lKkYr5ctXlMcXrL5ep8OluZyZRxI8h" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fb;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .card img {
            border-radius: 8px;
            width: 100%;
            height: auto;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .card img:hover {
            transform: scale(1.05);
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .comments-section {
            margin-top: 30px;
        }

        .comment {
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 15px;
            transition: background-color 0.3s ease;
        }

        .comment:hover {
            background-color: #e9ecef;
        }

        textarea {
            width: 100%;
            margin-top: 10px;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }

        .info-box {
            margin-top: 30px;
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 8px;
            font-size: 14px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .info-box h6 {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .info-box a {
            color: #007bff;
            text-decoration: none;
        }

        .info-box a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .btn-back {
            background-color: #6c757d;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Kembali Button -->
        <a href="{{ route('reports.article') }}" class="btn btn-back mb-3">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>

        <!-- Success or Error Alert -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Card with Report Details -->
        <div class="card mb-4">
            <img src="{{ $report->image_url }}" alt="Laporan Gambar" class="card-img-top">

            <div class="card-body">
                <h5 class="card-title text-primary">{{ $report->created_at->format('d F Y') }}</h5>
                <p class="card-text">{{ $report->description }}</p>
                <a href="#" class="btn btn-primary">Kategori: Sosial</a>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="comments-section">
            <h5 class="text-primary">Komentar</h5>

            @if ($report && $report->comments->count())
                @foreach ($report->comments as $comment)
                    <div class="comment">
                        <p><strong>{{ $comment->user->email }}</strong> - {{ $comment->created_at->format('d F Y') }}</p>
                        <p>{{ $comment->comment }}</p>
                    </div>
                @endforeach
            @else
                <p>Belum ada komentar.</p>
            @endif

            <form action="{{ route('reports.comment') }}" method="POST">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <input type="hidden" name="report_id" value="{{ $report->id }}">
                <textarea name="comment" placeholder="Tambahkan komentar Anda" rows="4" class="form-control"></textarea>
                <button type="submit" class="btn btn-primary mt-2">Kirim Komentar</button>
            </form>
        </div>

        <!-- Info Box Section -->
        <div class="info-box">
            <h6>Informasi Pengaduan</h6>
            <ul>
                <li>Pengaduan dapat dibuat setelah login.</li>
                <li>Pastikan data pengaduan benar.</li>
                <li>Pengaduan akan ditanggapi dalam 2x24 jam.</li>
                <li><a href="#">Buat Pengaduan Baru</a>.</li>
            </ul>
        </div>
    </div>
</body>

</html>

@endsection
