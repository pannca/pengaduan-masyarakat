<?php

namespace App\Http\Controllers;

use App\Models\Response;
use App\Models\StaffProvinces;
use Illuminate\Http\Request;
use App\Models\Report;

class ResponseController extends Controller
{
    public function index(Request $request)
    {
        $sortOrder = $request->get('sort_order', 'asc');
        $search = $request->get('search');
        $staffProvince = null;
        
        // Jika user adalah STAFF, filter berdasarkan provinsi
        if (auth()->user()->role === 'STAFF') {
            $staffProvinceData = StaffProvinces::where('user_id', auth()->id())->first();
            
            if ($staffProvinceData) {
                $staffProvince = $staffProvinceData->province;
                $query = Report::where('province', $staffProvince);
                
                if ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('regency', 'like', '%' . $search . '%')
                          ->orWhere('type', 'like', '%' . $search . '%')
                          ->orWhere('description', 'like', '%' . $search . '%');
                    });
                }
                
                $responses = $query->orderBy('created_at', $sortOrder)->get();
            } else {
                $responses = collect();
            }
        } else {
            // HEAD_STAFF bisa lihat semua
            $query = Report::query();
            
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('province', 'like', '%' . $search . '%')
                      ->orWhere('regency', 'like', '%' . $search . '%')
                      ->orWhere('type', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
                });
            }
            
            $responses = $query->orderBy('created_at', $sortOrder)->get();
        }

        return view('response.index', compact('responses', 'staffProvince'));
    }

    public function create()
    {
        //
    }


    public function store($id, Request $request)
    {
        $report = Report::find($id);

        response::create([
            'report_id' => $report->id,
            'staff_id' => auth()->id(),
            'response_status' => $request->response_status,
        ]);

        return redirect()->back();
    }



    public function show($id)
    {
        // Cari report berdasarkan ID
        $report = Report::findOrFail($id);

        // Kirim hanya $report ke view
        return view('response.progres', compact('report'));
    }




    public function edit(Response $response)
    {
        //
    }

    public function update(Request $request, $id)
    {
        // Find the response associated with the report ID
        $response = Response::where('report_id', $id)->first();

        // If no response found for this report
        if (!$response) {
            return redirect()->back()->with('error', 'Tidak ada respons yang ditemukan untuk laporan ini');
        }

        // Update response_status
        $response->update([
            'response_status' => $request->input('response_status'),
        ]);

        // Redirect with success message
        return redirect()->route('response.show', $response->report_id)->with('success', 'Status berhasil diperbarui');
    }


    public function destroy(Response $response)
    {
        //
    }

    public function export(Request $request)
    {
        $regency = $request->get('regency');
        
        // Jika user adalah STAFF, filter berdasarkan provinsi
        if (auth()->user()->role === 'STAFF') {
            $staffProvince = StaffProvinces::where('user_id', auth()->id())->first();
            
            if ($staffProvince) {
                $query = Report::with('user', 'response')
                    ->where('province', $staffProvince->province);
                
                // Filter per kabupaten jika dipilih
                if ($regency && $regency !== 'all') {
                    $query->where('regency', $regency);
                }
                
                $reports = $query->orderBy('created_at', 'desc')->get();
            } else {
                $reports = collect();
            }
        } else {
            // HEAD_STAFF bisa export semua atau filter per provinsi
            $province = $request->get('province');
            $query = Report::with('user', 'response');
            
            if ($province && $province !== 'all') {
                $query->where('province', $province);
            }
            
            if ($regency && $regency !== 'all') {
                $query->where('regency', $regency);
            }
            
            $reports = $query->orderBy('created_at', 'desc')->get();
        }

        $filename = 'laporan_pengaduan_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($reports) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Email User', 'Provinsi', 'Kabupaten', 'Tipe', 'Deskripsi', 'Status', 'Tanggal']);

            foreach ($reports as $report) {
                fputcsv($file, [
                    $report->id,
                    $report->user->email ?? '-',
                    $report->province,
                    $report->regency,
                    $report->type,
                    $report->description,
                    $report->response?->response_status ?? 'Belum Ditanggapi',
                    $report->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function check(Request $request)
    {
        $regency = $request->get('regency');
        $province = $request->get('province');
        
        if (auth()->user()->role === 'STAFF') {
            $staffProvince = StaffProvinces::where('user_id', auth()->id())->first();
            
            if ($staffProvince && $regency) {
                $count = Report::where('province', $staffProvince->province)
                    ->where('regency', $regency)
                    ->count();
            } else {
                $count = 0;
            }
        } else {
            if ($province) {
                $count = Report::where('province', $province)->count();
            } else {
                $count = 0;
            }
        }

        return response()->json(['count' => $count]);
    }
}
