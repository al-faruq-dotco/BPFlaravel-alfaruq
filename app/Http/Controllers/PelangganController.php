<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;


class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['dataPelanggan'] = Pelanggan::all();
    return view('admin.pelanggan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pelanggan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // //dd($request->all()); // Beri komentar (nonaktifkan debug)

    $data['first_name'] = $request->first_name;
    $data['last_name']  = $request->last_name;
    $data['birthday']   = $request->birthday;
    $data['gender']     = $request->gender;
    $data['email']      = $request->email;
    $data['phone']      = $request->phone;

    // Simpan data ke database
    Pelanggan::create($data);

    // Kembalikan ke halaman index pelanggan dengan pesan sukses
    return redirect()->route('pelanggan.index')->with('success', 'Penambahan Data Berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dataPelanggan = Pelanggan::findOrFail($id);
    return view('admin.pelanggan.edit', compact('dataPelanggan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi data input jika diperlukan
    $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'birthday' => 'required|date',
        'gender' => 'required',
    ]);

    // Cari data pelanggan berdasarkan ID lalu update
    $pelanggan = Pelanggan::findOrFail($id);
    $pelanggan->update($request->all());

    // Redirect kembali ke halaman index pelanggan
    return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil di-update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
    $pelanggan->delete();

    return redirect()->route('pelanggan.index');
    }
}
