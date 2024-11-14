<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\PracticumAssistant;

class PracticumAssistantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pracassistants = PracticumAssistant::with(['assistant', 'schedule'])->paginate(10);
        $schedules = Schedule::with(['practicum'])->get();
        return view('pracassistants.index', compact(['pracassistants', 'schedules']));
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
        $validator = $request->validate([
            'schedule_id' => 'required',
        ]);

        try {
            $pracassistant = PracticumAssistant::create([
                'schedule_id' => $request->schedule_id,
                'assistant_id' => $request->user()->assistant->id,
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
        $pracassistant = PracticumAssistant::with(['assistant', 'schedule'])->findOrFail($id);
        $students = Student::whereHas('registrations.schedule', function ($query) use ($pracassistant) {
            $query->where('id', $pracassistant->schedule->id);
        })->paginate(3);
        return view('pracassistants.detail', compact(['pracassistant', 'students']));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $pracassistant->delete();
            return redirect()->back()->with('success', "Jadwal {$pracassistant->schedule->practicum->name} {$pracassistant->schedule->class} berhasil dihapus.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus ruangan: ' . $e->getMessage());
        }
    }
}
