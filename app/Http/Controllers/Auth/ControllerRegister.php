<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use DB;
use Storage;
// model
use App\Jobs\SendMailJobIqra;
use App\Models\User;

class ControllerRegister extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();
        $details['email'] = 'iqrahabibi03@gmail.com';
        dispatch(new SendMailJobIqra($details));
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'api_token' => Str::random(60),
        ]);
    }
}
