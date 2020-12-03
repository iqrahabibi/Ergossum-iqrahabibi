<?php

namespace App\Http\Controllers\Companies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use DB;
use Storage;
// model
use App\Models\companies;

class ControllerCompanies extends Controller
{
    public function index()
    {
        $get = companies::latest()->paginate(10);
        return \response()->json($get);
    }

    public function create(Request $request)
    {
        // var_dump(Storage::disk('public'));
        // exit;
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'email',
            'logo'  => 'image:jpeg,png|max:1024'
        ]);

        if ($validasi->fails()) {
            $this->data['message'] = 'Error';
            $this->data['error'] = $validasi->errors();
            return $this->data;
        }

        DB::beginTransaction();
        try{
            $logo = $request->file('logo');
            $logoUploadedPath = $logo->store('public');

            $company = new companies();
            $company->name      = $request->name;
            $company->email     = $request->email;
            $company->logo      = basename($logoUploadedPath);
            $company->website   = $request->website;
            $company->save();

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
        if(empty($id))
        {
            return "tidak ada data yang diupdate";
        }
        $validasi = Validator::make($request->all(), [
            // 'name' => 'required',
            // 'email' => 'email',
        ]);

        if ($validasi->fails()) {
            $this->data['message'] = 'Error';
            $this->data['error'] = $validasi->errors();
            return $this->data;
        }

        DB::beginTransaction();
        try
        {
            $company = companies::find($id);

            if(empty($company))
            {
               return "data tidak ditemukan";
            }

            $company->name      = $request->name;
            $company->email     = $request->email;
            $company->logo      = $request->logo;
            $company->website   = $request->website;
            $company->save();

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
        $delete = companies::find($id);
        $delete->delete();

        return "berhasil delete";
    }
}
