<?php

namespace App\Http\Controllers;

use App\Models\Practicum;
use Illuminate\Http\Request;

class PracticumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $practicums = Practicum::paginate(3); // Adjust the number of items per page as needed
        return view('practicums.index', compact('practicums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'semester' => ['required'],
            'academic_year' => ['required'],
            'status' => ['required'],
        ]);

        try {
            // Buat entri baru di tabel practicums
            $practicum = Practicum::create([
                'name' => $request->name,
                'semester' => $request->semester,
                'academic_year' => $request->academic_year,
                'status' => $request->status,
            ]);

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Data praktikum berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Tangani error jika gagal menyimpan
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Gagal menambahkan data. ' . $e->getMessage());
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Practicum $practicum)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'semester' => 'required|string|max:10',
            'academic_year' => 'required|string|max:20',
            'status' => 'required|in:active,pending,inactive'
        ]);

        $practicum->update($validatedData);

        return redirect()->back()->with('success', 'Praktikum berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Practicum $practicum)
    {
        try {
            $practicum->delete();
            return redirect()->back()->with('success', "Praktikum {$practicum->name} berhasil dihapus.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus praktikum: ' . $e->getMessage());
        }
    }
}
