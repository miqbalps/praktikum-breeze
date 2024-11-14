<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::paginate(3); // Adjust the number of items per page as needed
        return view('rooms.index', compact('rooms'));
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
            'name' => 'required',
            'capacity' => 'required',
            'type' => 'required',
            'location' => 'required',
        ]);

        try {
            // Buat entri baru di tabel practicums
            $room = Room::create([
                'name' => $request->name,
                'capacity' => $request->capacity,
                'type' => $request->type,
                'location' => $request->location,
            ]);

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Data ruangan berhasil ditambahkan.');
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
    public function update(Request $request, Room $room)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'capacity' => 'required',
            'type' => 'required',
            'location' => 'required'
        ]);

        $room->update($validatedData);

        return redirect()->back()->with('success', 'Ruangan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        try {
            $room->delete();
            return redirect()->back()->with('success', "Ruangan {$room->name} berhasil dihapus.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus ruangan: ' . $e->getMessage());
        }
    }
}
