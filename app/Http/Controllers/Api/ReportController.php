<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
}

public function store(Request $request) {
    $request->validate([
        'category_id' => 'required',
        'latitude' => 'required',
        'longitude' => 'required',
        'lokasi' => 'required',
    ]);
    $report = Report::create([
        'user_id'       => $request->user_id,
        'category_id'   => $request->category_id,
        'lokasi'        => $request->lokasi,
        'longitude'     => $request->longitude,
        'latitude'      => $request->latitude,
        'deskripsi'     => $request->deskripsi,
        'status'        => 'pending',

    ]);

    return response()->json(['message => 'Laporan berhasil dibuat, 'data' => report], 201)
}
