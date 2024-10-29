<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

     public function Register(Request $request){
        try {
            //code...
        

            $validat = Validator::make($request->all(),
        
              [
               'name'=>'required|max:255|unique:Users,name',
               'email'=>'required|email|unique:Users,email',
               'password'=>'required',
               'number'=>'required|min:11|numeric'
              ]);


              if($validat->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validat->errors()
                ],401);
              }
              
              $user=User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password'=> Hash::make($request->password),
                'number'=>$request->number,
              ]);
              
              return response()->json([
                'status' => true,
                'message' => 'successfuly created',
                'token' => $user->createToken("API TOKEN")->plainTextToken
              ],200);

            }
             
            
            catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message'=>$th->getMessage()
                ],500);
            }


     }



     public function Login(Request $request){

        try {
           
            $validate = Validator::make($request->all(),[
                'email' => 'required|email',
                'password'=>'required',
                
            ]);

            if($validate->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validate->errors()
                ],401);
            }
                
            if(!Auth::attempt($request->only(['email','password']))){
                
                return response()->json([
                    'status'=>false,
                    'message'=>'email & password dose not match with record'
                ],401);
            }
            $user = User::where('email',$request->email)->first();
             
            return response()->json([
                'status' => true,
                'message' => 'Successfuly Loged In',
                'token' => $user->createToken('API TOKEN')->plainTextToken,
            ],200);

        } 
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message'=>$th->getMessage()
            ],500);
        }

     }
}
