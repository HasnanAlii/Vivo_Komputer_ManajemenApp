<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // Menampilkan semua data karyawan
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    // Menampilkan form tambah karyawan
    public function create()
    {
        return view('employees.create');
    }

    // Menyimpan data karyawan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'jabatan' => 'nullable|string|max:100',
        ]);

        Employee::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->route('employees.index')->with([
            'message' => 'Karyawan berhasil ditambahkan.',
            'alert-type' => 'success',
        ]);
    }

    // Menampilkan form edit karyawan
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    // Memperbarui data karyawan
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'jabatan' => 'nullable|string|max:100',
        ]);

        $employee = Employee::findOrFail($id);
        $employee->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->route('employees.index')->with([
            'message' => 'Data karyawan berhasil diperbarui.',
            'alert-type' => 'success',
        ]);
    }

    // Menghapus data karyawan
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('employees.index')->with([
            'message' => 'Data karyawan berhasil dihapus.',
            'alert-type' => 'success',
        ]);
    }
}
