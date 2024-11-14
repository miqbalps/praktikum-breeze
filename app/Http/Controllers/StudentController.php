<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Assistant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = Student::where('user_id', Auth::user()->id)->first();
        $assistant = Assistant::where('user_id', Auth::user()->id)->first();

        return view('students.index', compact(['student','assistant']));
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
        //
    }

    public function applyAssistant(Request $request)
    {
        // Cek apakah user adalah student
        $student = auth()->user()->student;

        // if (!$student) {
        //     return redirect()->back()->with('error', 'Hanya mahasiswa yang dapat mendaftar.');
        // }

        // Cek apakah sudah pernah apply
        // $existingApplication = Assistant::where('user_id', auth()->id())->first();

        // if ($existingApplication) {
        //     return redirect()->back()->with('error', 'Anda sudah pernah mengajukan permohonan assistant.');
        // }

        if (!$student || is_null($student->nrp) || is_null($student->department) || is_null($student->batch) || is_null($student->phone)) {
            return redirect()->back()->with('error', 'Silakan lengkapi data diri Anda sebelum mengajukan permohonan assistant.');
        }

        try {
            // Buat entri baru di tabel assistants
            $assistant = Assistant::create([
                'user_id' => auth()->id(),
                'type' => 'student',
                'status' => 'pending'
            ]);

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Permohonan assistant berhasil diajukan.');
        } catch (\Exception $e) {
            // Tangani error jika gagal menyimpan
            return redirect()->back()->with('error', 'Gagal mengajukan permohonan. ' . $e->getMessage());
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
    public function update(Request $request, Student $student)
    {
        $student = Student::findOrFail(auth()->user()->student->id);

        // Validasi dengan aturan unik yang mempertimbangkan kondisi tertentu
        $validatedData = $request->validate([
            'nrp' => [
                'required',
                Rule::unique('students', 'nrp')->ignore($student->id),
            ],
            'department' => 'required',
            'batch' => 'required',
            'phone' => 'required|numeric'
        ]);

        // Cek apakah NRP berubah
        if ($request->nrp != $student->nrp) {
            // Jika NRP berubah, tambahkan validasi tambahan
            $validatedData['nrp'] = $request->nrp;
        }

        // Update data
        $student->update($validatedData);

        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
