<?php

namespace App\Http\Controllers;

use App\Models\StaffProvinces;
use App\Models\User;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Charts\ReportChart;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

class StaffProvincesController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->query('sort', 'voting'); // Default: 'voting'
        $order = $request->query('order', 'desc'); // Default: 'desc'

        $provinsi = Report::with(['user'])
            ->get()
            ->sortBy(function ($report) use ($sortBy, $order) {
                if ($sortBy === 'voting') {
                    return $order === 'desc' ? -$report->voting_count : $report->voting_count;
                }
                return $report->{$sortBy};
            });

        return view('hstaff.index', compact('provinsi', 'sortBy', 'order'));
    }




    public function kelola()
    {
        $response = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
        $provinsi = $response->json();

        // Ambil daftar staff beserta provinsinya
        $user = StaffProvinces::with('user')->get();

        return view('hstaff.kelola', compact('provinsi', 'user'));
    }

    // Menyimpan akun staff baru berdasarkan provinsi
    public function store(Request $request)
    {

        // Buat akun user
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash password dengan Hash::make
            'role' => 'STAFF'
        ]);

        // Simpan data provinsi ke tabel staff_provinces
        StaffProvinces::create([ // Pastikan nama model sesuai (StaffProvince)
            'user_id' => $user->id,
            'province' => $request->province
        ]);

        return redirect()->back()->with('success', 'Akun staff berhasil dibuat.');
    }

    public function resetPassword($id)
    {
        // Cari staff berdasarkan ID
        $staffProvince = StaffProvinces::findOrFail($id);

        // Ambil user terkait
        $user = $staffProvince->user;

        // Buat password baru dari 4 karakter pertama email
        $newPassword = substr($user->email, 0, 4);

        // Hash password baru dan update
        $user->password = bcrypt($newPassword);
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', "Password berhasil direset. Password baru: $newPassword");
    }


    public function delete($id)
    {
        StaffProvinces::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Akun staff dan data terkait berhasil dihapus.');
    }
}
