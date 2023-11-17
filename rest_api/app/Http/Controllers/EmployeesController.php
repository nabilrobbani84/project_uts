<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function index()
    {
        $employees = Employees::all();
        $data = [
            'message' => 'Get All Employees',
            'data' => $employees
        ];

        // jika data kosong
        if ($employees->isEmpty()) {
            $data = [
                'message' => 'kosong',
            ];
            return response()->json($data, 204);
        }

        // Mengirim data (json) dan kode 200
        return response()->json($data, 200);

        

    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            # kolom => 'rules|rules'

            'name' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'address' => 'required|numeric',
            'email' => 'required|email',
            'status' => 'required',
            'timestamp' => 'required'
        ]);

        // $input = [
        //     'nama' => $request->nama,
        //     'nim' => $request->nim,
        //     'email' => $request->email,
        //     'jurusan' => $request->jurusan,
        // ];

        $pegawai = Employees::create($validatedData);

        $data = [
            'message' => 'pegawai is created successfully',
            'data' => $pegawai,
        ];

        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $employees = employees::find($id);

        if ($employees) {
            $input = [
                'id' => $request->id ?? $employees->id,
                'name' => $request->name ?? $employees->name,
                'gender' => $request->gender ?? $employees->gender,
                'phone' => $request->phone ?? $employees->phone,
                'address' => $request->address ?? $employees->address,
                'email' => $request->email ?? $employees->email,
                'status' => $request->status ?? $employees->status,
                'hired_on' => $request->hired_on ?? $employees->hired_on,
                'timestamp' => $request->timestamp ?? $employees->timestamp
            ];

            $employees->update($input);

            $data = [
                'message' => 'get detail resource',
                'data' => $employees,
            ];

            return response()->json($data, 201);
        } else {
            $data = [
                'message' => 'pegawai not found',
            ];
            return response()->json($data, 404);
        }
    }

    //Method menghapus karyawan
    public function destroy($id)
    {
        $employees = Employees::find($id);
        if ($employees) {
            $employees->delete();

            $data = [
                'message' => 'Employees not found',
                'data' => $employees,
            ];

            return response()->json($data, 404);
        } else {
            $data = [
                'message' => 'Employees has been deleted successfully',
            ];

            return response()->json($data, 200);
        }
    }

    public function search(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string',
        ]);

        // Menggunakan Model Employees untuk melakukan pencarian berdasarkan nama
        $employees = Employees::where('name', 'like', '%' . $request->input('name') . '%')->get();

        // Jika tidak ada karyawan yang ditemukan
        if ($employees->isEmpty()) {
            $data = [
                'message' => 'Tidak ada karyawan yang ditemukan dengan dari  nama tersebut',
            ];
            return response()->json($data, 404);
        }

        // Mengirim data json dan kode 200
        $data = [
            'message' => 'Search Employees by Name',
            'data' => $employees,
        ];
        return response()->json($data, 200);
    }

    public function show($id)
    {
        $employees = Employees::find($id);

        if ($employees) {
            $data = [
                'message' => 'Get detail employees',
                'data' => $employees,
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Employees not found',
            ];

            return response()->json($data, 404);
        }
    }

    // Menambahkan method untuk mendapatkan karyawan yang aktif
    public function active()
    {
        // Menggunakan Model Employees untuk select data karyawan yang aktif
        $activeEmployees = Employees::where('status', 'aktif')->get();

        // Jika tidak ada karyawan yang aktif
        if ($activeEmployees->isEmpty()) {
            $data = [
                'message' => 'Tidak ada karyawan yang aktif',
            ];
            return response()->json($data, 204);
        }

        // Mengirim data (json) dan kode 200
        $data = [
            'message' => 'Get Active Employees',
            'data' => $activeEmployees,
        ];
        return response()->json($data, 200);
    }

    public function inactive()
    {
        // Menggunakan Model Employees untuk select data karyawan yang aktif
        $inactiveEmployees = Employees::where('status', 'tidak aktif')->get();

        // Jika tidak ada karyawan yang aktif
        if ($inactiveEmployees->isEmpty()) {
            $data = [
                'message' => 'Semua karyawan aktif',
            ];
            return response()->json($data, 204);
        }

        // Mengirim data (json) dan kode 200
        $data = [
            'message' => 'Get Inactive Employees',
            'data' => $inactiveEmployees,
        ];
        return response()->json($data, 200);
    }

    // Menambahkan method untuk mendapatkan karyawan yang terminated
    public function terminated()
    {
        // Menggunakan Model Employees untuk select data karyawan yang aktif
        $terminEmployees = Employees::where('status', 'terminated')->get();

        // Jika tidak ada karyawan yang aktif
        if ($terminEmployees->isEmpty()) {
            $data = [
                'message' => 'Tidak ada karyawan yang dipecat',
            ];
            return response()->json($data, 204);
        }

        // Mengirim data (json) dan kode 200
        $data = [
            'message' => 'Get Terminated Employees',
            'data' => $terminEmployees,
        ];
        return response()->json($data, 200);
    }

}
