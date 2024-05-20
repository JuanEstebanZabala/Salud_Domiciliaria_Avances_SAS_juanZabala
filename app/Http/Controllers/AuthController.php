<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginFormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

use function Laravel\Prompts\password;

class AuthController extends Controller
{

    public function login(LoginFormRequest $request)
    {
        $user = User::where('document_number', $request->document_number)->first();
        if (!$user) return response()->json(['message' => ['type' => 'error', 'text' => 'No existe ningún registro asociado a esta cedula por favor hacer el registro.']], Response::HTTP_BAD_REQUEST);
        if($request->profile_id != 1){
            $roles = Role::where('id', $request->profile_id)->get();
            $user->roles()->sync($roles);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => ['type' => 'error', 'text' => 'La contraseña es invalida por favor verificar su digitación.']], Response::HTTP_UNAUTHORIZED);
        } else {
            $token = $user->createToken("auth_token")->plainTextToken;
            $cookie = cookie('cookie_token', $token, 120);
            return response()->json([
                'message' => ['type' => 'success', 'text' => 'Session iniciada correctamente'],
                'data' => [
                    'isAuthenticated' => true
                ]
            ], Response::HTTP_OK)->withCookie($cookie);
        }
    }

    public function user()
    {
        $user = Auth::user();
        $userRole = $user->roles[0];
        return response()->json([
            'data' => [
                'isAuthenticated' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'location' => $user->location,
                    'cell_phone' => $user->cell_phone,
                    'document_number' => $user->document_number,
                    'email' => $user->email,
                    'profile_id' => $userRole->id,
                    'profile' => $userRole->name,
                    'permissions' => $this->getPermissions($userRole),
                    'active' => $user->active
                ],
            ]
        ], Response::HTTP_OK);
    }

    public function logout()
    {
        $cookie = Cookie::forget('cookie_token');
        Auth::user()->tokens()->delete();
        return response()->json(['message' => ['type' => 'success', 'text' => 'Session cerrada correctamente']], Response::HTTP_OK)->withCookie($cookie);
    }

    public function getPermissions($role)
    {
        $values = $role->permissions;
        $permissions = array();
        foreach ($values as $key => $value) {
            $permissions[$value->name] = true;
        }
        return $permissions;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'document_number' => 'required',
            'name' => 'required|max:300',
            'email' => 'email|unique:users',
            'cell_phone' => 'digits:10',
            'location' => 'max:300',
            'password' => '',
            'profile_id' => 'required|in:2,3'
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'No se realizó el registro'],
                'errors' => $validator->errors()
            ];
            return response()->json($data, Response::HTTP_BAD_REQUEST);
        }
        $user = User::create([
            'document_number' => $request->document_number,
            'name' => $request->name,
            'email' => $request->email,
            'cell_phone' => $request->cell_phone,
            'location' => $request->location,
            'password' => $request->document_number,
            'profile_id' => $request->profile_id
        ]);
        if (!$user) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'No hay usuarios registrados'],
                'errors' => $validator->errors()
            ];
            return response()->json($data, Response::HTTP_BAD_REQUEST);
        }
        $data = [
            'message' => ['type' => 'success', 'text' => 'Usuario creado correctamente'],
            'data' => [$user]
        ];
        return response()->json($data, Response::HTTP_CREATED);
    }
}
