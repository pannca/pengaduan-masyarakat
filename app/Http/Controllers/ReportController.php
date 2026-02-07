<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        if ($report->response) {
            return redirect()->back()->with('error', 'Pengaduan ini sudah mendapatkan tanggapan dan tidak dapat dihapus.');
        }
        $report->delete();
        return redirect()->route('report.article')->with('success', 'Pengaduan berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        if (!$search) {
            return redirect()->back()->with('error', 'Please enter a search term.');
        }

        $reports = Report::where('province', 'like', '%' . $search . '%')->get();

        return view('report.article', compact('reports'));
    }


    public function article()
    {
        $reports = Report::with('user')->latest()->get();
        return view('report.article', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('report.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'province' => 'required',
            'regency' => 'required',
            'subdistrict' => 'required',
            'village' => 'required',
            'type' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'statement' => 'required',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reports', 'public');
        }


        $report = Report::create([
            'user_id' => auth()->user()->id,
            'province' => $request->province,
            'regency' => $request->regency,
            'subdistrict' => $request->subdistrict,
            'village' => $request->village,
            'type' => $request->type,
            'statement' => $request->statement,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('reports.detail')->with('success', 'Laporan berhasil dibuat');
    }

    public function index($id)
    {
        $report = Report::with('user', 'comments')->where('id', $id)->where('user_id', auth()->user()->id)->first();
        $report = Report::findOrFail($id);
        $report->increment('viewers');;

        return view('report.index', compact('report'));
    }

    public function comment(Request $request)
    {
        $request->validate([
            'comment' => 'required',
        ], [
            'comment.required' => 'Isi komentar terlebih dahulu!'  // Pesan error jika komentar kosong
        ]);

        // Simpan komentar baru
        Comment::create([
            'user_id' => auth()->user()->id,
            'comment' => $request->comment,
            'report_id' => $request->report_id,
        ]);

        // Ambil komentar terbaru beserta pengguna yang terkait
        $comments = Comment::with('user')->where('report_id', $request->report_id)->latest()->get();

        // Redirect kembali ke halaman dengan komentar terbaru
        return redirect()->back()->with('comments', $comments);
    }

    public function vote(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        // Ambil data voting, jika null inisialisasi sebagai array kosong
        $voting = $report->voting ?? [];

        $userId = auth()->id(); // id sipengguna yang melakukan voting nya

        // Logika toggle voting
        if (isset($voting[$userId])) {
            unset($voting[$userId]); // Jika sudah vote, hapus
        } else {
            $voting[$userId] = 1; // Tambahkan vote
        }

        // Update data voting di database
        $report->voting = $voting;
        $report->save();

        return redirect()->back();
    }


    /**
     * Display the specified resource.
     */
    public function detail()
    {
        $reports = Report::with('user', 'comments')->where('user_id', auth()->user()->id)->get();
        return view('report.detail', compact('reports'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
}
