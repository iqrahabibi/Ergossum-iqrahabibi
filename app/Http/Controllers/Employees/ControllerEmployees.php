<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use DB;
// model
use App\Models\employees;
use App\Models\companies;

class ControllerEmployees extends Controller
{
    public function index()
    {
        $get = employees::latest()->paginate(10);
        return \response()->json($get);
    }

    public function create(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'first_name'    => 'required',
            'last_name'     => 'required',
            'company'       => 'required',
            'email'         => 'email'
        ]);

        if ($validasi->fails()) {
            $this->data['message'] = 'Error';
            $this->data['error'] = $validasi->errors();
            return $this->data;
        }

        DB::beginTransaction();
        try{
            $cek_companies = companies::find($request->company);
            if(empty($cek_companies))
            {
                return "company yang anda masukan tidak terdaftar";
            }

            $employees = new employees();
            $employees->first_name = $request->first_name;
            $employees->last_name = $request->last_name;
            $employees->company = $request->company;
            $employees->email = $request->email;
            $employees->phone = $request->phone;
            $employees->save();

            DB::commit();
            return "berhasil simpan";
        }catch(Exception $e)
        {
            DB::rollback();
            return $e;
        }
    }

    public function update(Request $request, $id)
    {
        $validasi = Validator::make($request->all(), [
            // 'first_name'    => 'required',
            // 'last_name'     => 'required',
            // 'company'       => 'required',
            // 'email'         => 'email'
        ]);

        if ($validasi->fails()) {
            $this->data['message'] = 'Error';
            $this->data['error'] = $validasi->errors();
            return $this->data;
        }

        DB::beginTransaction();
        try
        {
            $employees = employees::find($id);

            if(empty($employees))
            {
                return "data tidak ditemukan";
            }


            $employees->first_name = $request->first_name;
            $employees->last_name = $request->last_name;
            $employees->company = $request->company;
            $employees->email = $request->email;
            $employees->phone = $request->phone;
            $employees->save();

            DB::commit();
            return "berhasil update";
        }
        catch(Exception $e)
        {
            DB::rollback();
            return $e;
        }
    }

    public function destroy($id)
    {
        $delete = employees::find($id);
        $delete->delete();

        return "berhasil delete";
    }
}
