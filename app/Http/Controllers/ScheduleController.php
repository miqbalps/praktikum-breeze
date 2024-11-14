<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Schedule;
use App\Models\Practicum;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = Schedule::with(['practicum', 'room'])->paginate(3);
        $practicums = Practicum::get();
        $rooms = Room::get();
        return view('schedules.index', compact(['schedules', 'practicums','rooms']));
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
            'practicum_id' => 'required',
            'room_id' => 'required',
            'class' => 'required',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'capacity' => 'required',
        ]);

        try {
            $schedule = Schedule::create([
                'practicum_id' => $request->practicum_id,
                'room_id' => $request->room_id,
                'class' => $request->class,
                'day' => $request->day,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'capacity' => $request->capacity,
            ]);

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Data jadwal berhasil ditambahkan.');
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
    public function update(Request $request, Schedule $schedule)
    {
        $validatedData = $request->validate([
            'practicum_id' => 'required',
            'room_id' => 'required',
            'class' => 'required',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'capacity' => 'required'
            ]);

        $schedule->update($validatedData);

        return redirect()->back()->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        try {
            $schedule->delete();
            return redirect()->back()->with('success', "Jadwal {$schedule->practicum->name} {$schedule->class} berhasil dihapus.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus ruangan: ' . $e->getMessage());
        }
    }
}
