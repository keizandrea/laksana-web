<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report; 
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request) 
    {
        $query = Report::with(['category', 'user'])->latest();

        if($request->has('category_id') && $request->category_id != '' ){
            $query->where('category_id', $request->category_id); // 🌟 SEKARANG PAKAI $
        }
        if ($request->has('tingkat_keparahan') && $request->tingkat_keparahan != '') {
            $query->where('tingkat_keparahan', $request->tingkat_keparahan);
        }
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $reports = $query->get();        
        return response()->json([
            'message' => 'Berhasil mengambil semua data laporan',
            'data' => $reports
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'latitude'    => 'required',
            'longitude'   => 'required',
            'lokasi'      => 'required',
        ]);

        // Ambil user_id dari request React, jika kosong default ke ID 1 (Admin)
        $userId = $request->user_id ?? auth()->id() ?? 1;

       
        $statusAwal = 'pending'; 

        $report = Report::create([
            'user_id'           => $userId, 
            'category_id'       => intval($request->category_id),
            'lokasi'            => strip_tags($request->lokasi), // Bersihkan teks alamat dari karakter aneh
            'longitude'         => strval($request->longitude),
            'latitude'          => strval($request->latitude),
            'deskripsi'         => $request->deskripsi,
            'tingkat_keparahan' => $request->tingkat_keparahan ?? '3', 
            'status'            => $statusAwal, // 🌟 DIJAMIN AMAN, masuk sebagai 'pending' sesuai ENUM database
        ]);

        return response()->json([
            'message' => 'Laporan berhasil disimpan ke database Laksana!',
            'data'    => $report
        ], 201);
    }

    public function updateStatus(Request $request, $id){
        $request->validate([
            'status' => 'required|in:Baru,pending,proses,selesai,ditolak', // Menyesuaikan opsi status di frontend
        ]);

        $report = Report::find($id);

        if(!$report){
            return response()->json([
                'message' => 'Laporan tidak ditemukan!'
            ], 404);
        }

        $report->status = $request->status;
        $report->save();

        return response()->json([
            'message' => 'Status laporan berhasil diperbarui menjadi ' . $request->status,
            'data' => $report
        ], 200);
    }

    public function myReports(Request $request)
    {
        $userId = $request->user()->id;

        $myReports = Report::with(['category'])
                            ->where('user_id', $userId)
                            ->latest()
                            ->get();
        
        return response()->json([
            'message' => 'Berhasil mengambil daftar laporan Anda!',
            'data' => $myReports
        ], 200);
    }
}