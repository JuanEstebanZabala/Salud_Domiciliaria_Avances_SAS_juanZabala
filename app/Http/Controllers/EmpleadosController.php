<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
class EmpleadosController extends Controller
{
   
    public function index()
    {
        $empleados = Empleado::all();
        if ($empleados->isEmpty()) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'No hay empleados registrados']
            ];
            return response()->json($data, Response::HTTP_BAD_REQUEST);
        }
        $data = [
            'message' => ['type' => 'success', 'text' => 'empleados encontrados correctamente'],
            'data' => ['empleados' => $empleados]
        ];
        return response()->json($data, Response::HTTP_OK);
    }

   
    public function create()
    {
       
    }

   
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:empleados',
            'role' => 'required|in:Developer,Designer,Product Manager',
            'location' => 'required',
            'typography' => 'required',
            'avatar' => ''           
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'No hay empleados registrados'],
                'errors' => $validator->errors()
            ];
            return response()->json($data, Response::HTTP_BAD_REQUEST);
        }
        $empleado = Empleado::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'location' => $request->location,
            'typography' => $request->typography,
            'avatar'=> $request->avatar            
        ]);      
        $empleado->save();
        if (!$empleado) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'No hay empleados registrados'],
                'errors' => $validator->errors()
            ];
            return response()->json($data, Response::HTTP_BAD_REQUEST);
        }
        $data = [
            'message' => ['type' => 'success', 'text' => 'Empleado creado correctamente'],
            'data' => [$empleado]
        ];
        return response()->json($data, Response::HTTP_CREATED);
    }

    
    public function show(string $id)
    {
        $empleado = Empleado::find($id);
        if (!$empleado) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'Empleado no encontrado']
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND);
        }
        $data = [
            'message' => ['type' => 'success', 'text' => 'Empleado encontrado correctamente'],
            'data' => [$empleado]
        ];
        return response()->json($data, Response::HTTP_OK);
    }

   
    public function edit(Empleado $empleados)
    {
        
    }

 
    public function update(string $id,Request $request)
    {
        $empleado = Empleado::find($id);
        if (!$empleado) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'Empleado no encontrado']
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:empleados,email,'. $id,
            'role' => 'required|in:Developer,Designer,Product Manager',
            'location' => 'required',
            'typography' => 'required',
            'avatar' => ''
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'Error en la validación de los datos'],
                'errors' => $validator->errors()
            ];
            return response()->json($data, Response::HTTP_BAD_REQUEST);
        }
        $empleado->name = $request->name;
        $empleado->email = $request->email;
        $empleado->role = $request->role;
        $empleado->location = $request->location;
        $empleado->typography = $request->typography;
        $empleado->avatar = $request->avatar;              
        $empleado->save();
        $data = [
            'message' => ['type' => 'success', 'text' => 'Empleado modificado correctamente'],
            'data' => [$empleado]
        ];
        return response()->json($data, Response::HTTP_OK);
    }

   
    public function destroy(string $id)
    {
        $empleado = Empleado::find($id);
        if (!$empleado) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'Empleado no encontrado']
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND );
        }
        $empleado->delete();
        $data = [
            'message' => ['type' => 'success', 'text' => 'empleado eliminado'],
        ];
        return response()->json($data, Response::HTTP_OK);
    }
}
