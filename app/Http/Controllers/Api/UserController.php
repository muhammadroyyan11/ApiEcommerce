<?php

namespace App\Http\Controllers\Api;

use App\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $requset){
        // dd($requset->all());die();
        $user = User::where('email', $requset->email)->first();

        if($user){

            $user->update([
                'fcm' => $requset->fcm
            ]);

            if(password_verify($requset->password, $user->password)){
                return response()->json([
                    'success' => 1,
                    'message' => 'Selamat datang '.$user->name,
                    'user' => $user
                ]);
            }
            return $this->error('Password Salah');
        }
        return $this->error('Email tidak terdaftar');
    }

    public function register(Request $requset){
        //nama, email, password
        $validasi = Validator::make($requset->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|min:6'
        ]);

        if($validasi->fails()){
            $val = $validasi->errors()->all();
            return $this->error($val[0]);
        }

        $user = User::create(array_merge($requset->all(), [
            'password' => bcrypt($requset->password)
        ]));

        if($user){
            return response()->json([
                'success' => 1,
                'message' => 'Selamat datang Register Berhasil',
                'user' => $user
            ]);
        }

        return $this->error('Registrasi gagal');
    }

    public function update_profile(Request $request){
        $user = User::all()->where('email', $request->old_email)->first();

        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|unique:users'
        ]);

        if ($validasi->fails()) {
            $val = $validasi->errors()->all();
            return $this->error($val[0]);
        }

        if($user){
            if ($user->phone == $request->phone){
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
            } else {
                $user->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                ]);
            }

            return response()->json([
                'success' => 1,
                'message' => 'Update profile berhasil',
                'user' => $user
            ]);
        }
        return $this->error('Update profile gagal');
    }
    public function delete(Request $request){
        $user = User::all()->where('email', $request->email)->first();

        if($user){
            $user->delete();

            return response()->json([
                'success' => 1,
                'message' => 'Delete profile berhasil',
                'user' => $user
            ]);
        }
        return $this->error('Delete profile gagal');
    }

    public function update_password(Request $requset){
        //nama, email, password
        $user = User::all()->where('email', $requset->email)->first();

        $validasi = Validator::make($requset->all(), [
            'password' => 'required|min:6'
        ]);

        if($validasi->fails()){
            $val = $validasi->errors()->all();
            return $this->error($val[0]);
        }

        if($user){
            $user->update([
                'password' => bcrypt($requset->password)
            ]);

            return response()->json([
                'success' => 1,
                'message' => 'Update password berhasil',
                'user' => $requset->password
            ]);
        }

        return $this->error('Registrasi gagal');

    }

    public function error($pasan){
        return response()->json([
            'success' => 0,
            'message' => $pasan
        ]);
    }

}
