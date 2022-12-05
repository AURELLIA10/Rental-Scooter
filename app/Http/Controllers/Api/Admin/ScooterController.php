<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Scooter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ScooterController extends Controller
{
    public function index()
    {
        $scooter = Scooter::all();
        $scooter->map(function ($scooter) {
            $scooter->image = asset('storage/' . $scooter->image);
            return $scooter;
        });

        return ResponseFormatter::success($scooter, 'Data List Scooter Berhasil Diambil');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth = $request->user();



        if ($auth->role == 'admin') {
            // $request->validate([
            //     'title' => 'required',
            //     'image' => 'required',
            //     'colour' => 'required',
            //     'description' => 'required',
            //     'price' => 'required',
            // ]);

            $image = $request->file('image')->store('scooter', 'public');

            $scooter = Scooter::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'colour' => $request->colour,
                'image' => $image,
                'rented' => 0,
                'description' => $request->description,
                'price' => $request->price,
            ]);

            if ($scooter) {
                return ResponseFormatter::success(
                    $scooter,
                    'Data Scooter Berhasil Ditambahkan'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data Scooter Gagal Ditambahkan',
                    404
                );
            }
        } else {
            return ResponseFormatter::error(
                null,
                'Anda Bukan Admin',
                404
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Scooter $scooter)
    {
        return ResponseFormatter::success($scooter, 'Detail Scooter Berhasil Diambil');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();

        $scooter = Scooter::find($id);

        if ($request->file('image')) {
            $image = $request->file('image')->store('car', 'public');
        } else {
            $image = $scooter->image;
        }

        if ($user->role == 'admin') {
            $scooter->update([
                'title' => $request->title ? $request->title : $scooter->title,
                'slug' => Str::slug($request->title) ? Str::slug($request->title) : $scooter->slug,
                'colour' => $request->colour ?? $scooter->colour,
                'image' => $image ?? $scooter->image,
                'description' => $request->description ?? $scooter->description,
                'price' => $request->price ?? $scooter->price,
            ]);
        } else {
            return ResponseFormatter::success($scooter, 'Anda tidak memiliki akses');
        }

        return ResponseFormatter::success($scooter, 'Data Scooter berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();

        $scooter = Scooter::find($id);

        if ($user->role == 'admin') {
            $scooter->delete();
        } else {
            return ResponseFormatter::success($scooter, 'Anda tidak memiliki akses untuk menghapus data Scooter');
        }

        return ResponseFormatter::success($scooter, 'Data Scooter berhasil dihapus');
    }
}
