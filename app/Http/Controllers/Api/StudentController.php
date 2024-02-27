<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Mockery\Generator\StringManipulation\Pass\Pass;
use Illuminate\Support\Facades\Hash;


class StudentController extends Controller
{

    //student registration (POST, formdata)
    public function register(Request $request){

        //validation
        $request->validate([
            'name'=>'required',
            'email' =>'required|email|unique:students',
            'password'=>'required|confirmed',
            'phone'=>'required|unique:students'
        ]);

        //student model
        Student::create([
            'name'=>$request->name,
            'email' => $request->email,
            'password'=> Hash::make($request->password),
            'phone'=> $request->phone
            
        ]);

        //response
        return response()->json([
            'status' => 'success', 
            'message' => 'Student registered successfully'   
        ]);
    }

    //student login (POST, formdata)
    public function login(Request $request){

        //validate
            $request->validate([
                'email' =>'required|email',
                'password'=>'required'

            ]);

        //checking
         $student = Student::where('email', $request->email)->first();
         if(!empty($student)){
        //sanctum token
            if(Hash::check($request->password, $student->password)){

                $token = $student->createToken('myapptoken') -> plainTextToken;

                return response()->json([
                 'status' =>'success',
                    'token' => $token,
                  'message' => 'Login successfully'
                ]);
            }
            return response()->json([
                'status' =>'failed',
                'message' => "Password didn't match",
            ]);
        }

        return response()->json([
          'status' =>'failed',
          'message' => "Student doesn't exist",
        ]);
    }

    //student profile (get)
    public function profile(){

        $data = auth()->user();

        return response()->json([
          'status' =>'success',
          'message' => 'Profile data',
            'data' => $data
        ]);

    }

    //student logout (get)
    public function logout(){

    }


}
