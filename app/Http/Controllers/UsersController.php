<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        if ($users->isEmpty()) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'No hay usuarios registrados']
            ];
            return response()->json($data, Response::HTTP_BAD_REQUEST);
        }
        return response()->json($users, Response::HTTP_OK);
    }

    /**
     * muestra el listado de pacientes
     */
    public function findPacientes()
    {
        $pacientes = User::select('users.*')
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->where('model_has_roles.role_id', 3)
        ->get();

        if (!$pacientes) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'Aún no existen pacientes']
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND);
        }
        $data = [
            'message' => ['type' => 'success', 'text' => 'pacientes encontrados correctamente'],
            'data' => ['pacientes' => $pacientes]
        ];
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'document_number' => 'required',
            'name' => 'required|max:300',
            'email' => 'email|unique:users',
            'cell_phone' => 'digits:10',
            'location' => 'max:300',
            'passsword' => '',
            'profile_id' => 'required|in:2,3'
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'No hay usuarios registrados'],
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
            'password'=> $request->document_number,
            'profile_id'=>$request->profile_id
        ]);
        if (!$user) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'No se pudo crear el usuario'],
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'Usuario no encontrado']
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND);
        }
        $data = [
            'message' => ['type' => 'success', 'text' => 'Usuario encontrado correctamente'],
            'data' => [$user]
        ];
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'Usuario no encontrado']
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND);
        }
        $validator = Validator::make($request->all(), [
            'document_number' => 'required',
            'name' => 'required|max:300',
            'email' => 'required|email|unique:users',
            'cell_phone' => 'required|digits:10',
            'location' => 'required',
            'password' => 'required|confirmed',
            'profile_id'=>'in:2,3'

        ]);
        if ($validator->fails()) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'Error en la validación de los datos'],
                'errors' => $validator->errors()
            ];
            return response()->json($data, Response::HTTP_BAD_REQUEST);
        }
        $user->document_number = $request->document_number;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->cell_phone = $request->cell_phone;
        $user->location = $request->location;
        $user->password = $request->password;
        $user->profile_id = $request->profile_id;

        $user->save();
        $data = [
            'message' => ['type' => 'success', 'text' => 'Usuario modificado correctamente'],
            'data' => [$user]
        ];
        return response()->json($data, Response::HTTP_OK);
    }
    public function updatePartial($id, Request $request)
    {
        $user = User::find($id);
        if (!$user) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'Usuario no encontrado']
            ];
            return response()->json($data, 404);
        }
        $validator = Validator::make($request->all(), [
            'document_number' => '',
            'name' => 'max:300',
            'email' => 'email|unique:users,email,'. $id,
            'cell_phone' => 'digits:10',
            'location' => '',
            'password' => 'confirmed',
            'profile_id'=>'in:2,3'
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'Error en la validación de los datos'],
                'errors' => $validator->errors()
            ];
            return response()->json($data, Response::HTTP_BAD_REQUEST);
        }
        if ($request->has('document_number')) {
            $user->document_number = $request->document_number;
        }
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('cell_phone')) {
            $user->cell_phone = $request->cell_phone;
        }
        if ($request->has('location')) {
            $user->location = $request->location;
        }
        if ($request->has('password')) {
            $user->password = $request->password;
        }
        if ($request->has('profile_id')) {
            $user->profile_id = $request->profile_id;
        }
        $user->save();
        $data = [
            'message' => ['type' => 'success', 'text' => 'Usuario modificado correctamente'],
            'data' => [$user]
        ];
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'Usuario no encontrado']
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND );
        }
        $user->delete();
        $data = [
            'message' => ['type' => 'success', 'text' => 'Usuario eliminado'],
        ];
        return response()->json($data, Response::HTTP_OK);
    }
}
