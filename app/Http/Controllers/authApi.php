<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\token_model;
use Auth;
use Validator;
use Carbon\Carbon;
class authApi extends Controller
{
    public function register(Request $r){
        $val=Validator::make($r->all(),[
            'name'=>'required|min:3',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
        ]);
        if ($val->fails()) {
            return response()->json($val->errors(),400);
        } else {
            $token=bcrypt($r->email);
            $n=token_model::create([
                'token'=>$token
            ]);
            $g=User::create([
                'name'=> $r->name,
                'email'=> $r->email,
                'password'=> bcrypt($r->password),
            ])->token()->save($n);
            return response()->json([
              'msg'=>'success',
              'token'=>$token,
            ],200);
        }
    }
    public function login(Request $r){
        $val=Validator::make($r->all(),[
            'email'=>'required',
            'password'=>'required'
        ]);
        if ($val->fails()) {
            return response()->json($val->errors());
        } else {
           $s=Auth::attempt([
               'email'=>$r->email,
               'password'=>$r->password,
           ]);
           if ($s) {
            $k=Auth::user()->id;
            $tn=token_model::where('token_id',$k)->get('token');
            return response()->json([
                'msg'=>'success',
                'token'=>$tn
            ]);
           } else {
            return response()->json([
                'msg'=>'errrrrrrr',
            ]);

           }
        }
    }
    public function logout(Request $r){
        token_model::where('token',$r->token)->update([
            'token'=>bcrypt(Carbon::now()),
        ]);
        return response()->json([
            'msg'=>'success'
        ]);
        }
}
