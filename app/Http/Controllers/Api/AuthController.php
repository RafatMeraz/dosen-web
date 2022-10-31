<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Traversy media snactum auth api
    // register
    // yo
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'mimes:jpeg,png,jpg',
            'phone' => 'required|unique:users,phone',
            'role' => 'required',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
             return response()->json([
                'success' => false,
                'message' => $validator->messages()->first(),
            ], 400);
        }

        if ($request->hasFile('image'))
        {
            $image = '';
            try {
                $image = $request->file('image')->storeAs(
                    'public/image', Str::random(56).'.'.$request->file('image')->getClientOriginalExtension()
                );
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Image Failed!',
                ], 400);
            }
            $image = explode("public/",$image);
            try {
                $user = User::create([
                    'name'=> $request->name,
                    'phone'=> $request->phone,
                    'email'=> $request->email,
                    'role'=> $request->role,
                    'designation'=> $request->designation,
                    'password'=> Hash::make($request->password),
                    'image'=> $image[1],
                    'division_id'=> $request->division_id,
                ]);
                $token = $user->createToken('userToken')->plainTextToken;
                return response()->json([
                    'success' => true,
                    'message' => 'User Registered Succesfully!',
                    'data' => [
                        'accessToken' => $token,
                        'user' => $user,
                    ],
                ], 200);
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'User Registration Failed!',
                ], 400);
            }

        }

            try {
                $user = User::create([
                    'name'=> $request->name,
                    'phone'=> $request->phone,
                    'email'=> $request->email,
                    'role'=> $request->role,
                    'designation'=> $request->designation,
                    'password'=> Hash::make($request->password),
                    'image'=> NULL,
                    'division_id'=> $request->division_id,
                ]);
                $token = $user->createToken('userToken')->plainTextToken;
                return response()->json([
                    'success' => true,
                    'message' => 'User Registered Succesfully!',
                    'data' => [
                        'accessToken' => $token,
                        'user' => $user,
                    ],
                ], 200);
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'User Registration Failed!', error($th->getMessage()),
                ], 400);
            }
        // }
    }



    // login
    public function login(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
             return response()->json([
                'success' => false,
                'message' => $validator->messages()->first(),
            ], 400);
        }


        // Check phone
        $user = User::where('phone', $request->phone)->first();

        // Check password
        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Login Failed | Credentials Doesnt Matched!',
            ], 400);
        }

        // block check
        $block = $user->block == 1;
        if($block){
            // return 0;
            return response()->json([
                'success' => false,
                'message' => 'Your Account is blocked, please contact Admin.',
            ], 400);

        }else {

             // create token
            $token = $user->createToken('userToken')->plainTextToken;
            return response()->json([
                'success' => true,
                'message' => 'Login Succesfull!',
                'data' => [
                    'accessToken' => $token,
                    'user' => $user,
                ],
            ], 200);
        }
    }



    // logout
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'success' => true,
            'message' => 'User Logout!',
        ], 200);
    }
}
