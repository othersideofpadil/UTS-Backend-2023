<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function index(){
      $pegawai = Employee::all();

      // jika data kosong maka kirim status code 204
      if($pegawai->isEmpty()){
        $data = [
          "message"=> 'Resource is empty',
        ];

        return response()->json($data, 204);  

      }
      
      $data = [
        'message' => 'Get All Pegawai',
        'data'=> $pegawai
      ];

      return response()->json($data, 200);
    }

    // membuat function store
    public function store(Request $request){  
        // memvalidasi data request 
        $validateData = $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required',
            'status' => 'required',
            'hired_on' => 'required'
        ]);


        // membuat data
        $employees = Employee::create($validateData);
        
        $data = [
            'message' =>'Pegawai is Created Succesfully',
            'data'=> $employees,
        ];

        // mengembalikan data (json) dan kode 201
        return response()->json($data, 201);
    }

    // membuat function update
    public function update(Request $request,$id){
      // mencari data yang ingin di update
      $pegawai = Employee::find($id);

      // jika data yang dicari tidak ada, kirim kode 404
      if(!$pegawai){
        $data = [
          'message' => 'Data not Found'
        ];

        return response()->json($data, 404);
      }

      // menangkap data request 
      $input = [
            'name' => $request->name ?? $pegawai->name,
            'gender' => $request->gender ?? $pegawai->gender,
            'phone' => $request->phone ?? $pegawai->phone,
            'address' => $request->address ?? $pegawai->address,
            'email' => $request->email ?? $pegawai->email,
            'status' => $request->status ?? $pegawai->status,
            'hired_on' => $request->hired_on ?? $pegawai->hired_on
          ];

        // mengupdate nilai pegawai berdasarkan id
        $data = [
          'message'=> 'Pegawai updated successfully',
          'data'=> $input
        ];
        
        // mengembalikan data 
        return response()->json($data, 200);
      
    }
    // membuat function delete
    public function destroy($id){
      // cari id pegawai yang ingin dihapus
      $pegawai = Employee::find($id);

      // jika data yang dicari tidak ada kirim kode 404
      if(!$pegawai){
        $data = [
          'message' => 'Data pegawai not Found'
        ];

        return response()->json($data, 404);
      }
      
      // hapus pegawai 
      $pegawai->delete();

      $data = [
        'message'=> 'Pegawai deleted succesfully',
        'data'=> $pegawai
      ];

      // mengembalikan data kode 200
      return response()->json($data, 200);
  
  }

  // membuat detail pegawai
  public function show ($id){
    // cari id pegawai yang ingin didapatkan
    $pegawai = Employee::find($id);

    if($pegawai){
      $data = [
        'message' => 'Get Detail Pegawai',
        'data' => $pegawai
      ];

      // mengembalikan data 200
      return response()->json($data, 200);
    }
    else{
      $data = [
        'message' => 'Pegawai not Found',
      ];

      // mengembalikan data 404
      return response()->json($data, 404);
    }
  }

  // membuat function search by name
  public function search(Request $request, $name){
        // mendapatkan data employeee
        $employees = Employee::where('name', 'like', '%' . $name . '%')->get();

        // mengecek jika yang di search tidak ada di data
        if ($employees->isEmpty()) {
            $data = [
                'message' => 'No employees found with name ' . $name,
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => 'Get Search succesfully',
            'data' => $employees
        ];
        return response()->json($data,200);
     }

    
    // membuat function active  
    public function active()
    {
        $activeEmployees = Employee::where('active', true)->get();
        return view('employee.active', compact('activeEmployees'));
    }
   
    //membuat function inactive 
    public function inactive()
    {
        $inactiveEmployees = Employee::where('active', false)->get();
        return view('employee.inactive', compact('inactiveEmployees'));
    }

    // membuat function terminated
    public function terminated()
    {
        $terminatedEmployees = Employee::where('status', 'terminated')->get();
        return view('employee.terminated', compact('terminatedEmployees'));
    }
}
