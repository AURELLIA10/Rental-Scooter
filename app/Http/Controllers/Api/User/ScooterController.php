<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Scooter;
use Illuminate\Http\Request;

class ScooterController extends Controller
{
    public function index()
    {
        $scooter = Scooter::where('rented', '0')->get();
        $scooter->map(function ($scooter) {
            $scooter->image = asset('storage/' . $scooter->image);
            return $scooter;
        });

        if ($scooter) {
            return ResponseFormatter::success($scooter, 'Data List Scooter Berhasil Diambil');
        } else {
            return ResponseFormatter::error($scooter, 'Data Gagal Diambil');
        }
    }

    public function show(Scooter $scooter)
    {
        return ResponseFormatter::success($scooter, 'Data Scooter Berhasil Diambil');
    }
}
