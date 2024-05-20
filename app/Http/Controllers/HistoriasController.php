<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Historia;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class HistoriasController extends Controller
{
      /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $historia = Historia::all();
        if ($historia->isEmpty()) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'No hay historias registradas']
            ];
            return response()->json($data, Response::HTTP_BAD_REQUEST);
        }
        return response()->json($historia, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_profesional' => 'required',
            'informacion_relevante' => 'required|max:600',
            'hora' => 'required|date_format:H:i',
            'fecha' => 'required|date_format:Y-m-d',
            'estado' => 'max:40|in:pendiente,asistida',
            'antecedentes' => 'max:600',
            'evaluacion' => '',
            'concepto' => '',
            'recomendaciones' => '',
            'id_paciente' => 'required'
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'No hay historias registradas'],
                'errors' => $validator->errors()
            ];
            return response()->json($data, Response::HTTP_BAD_REQUEST);
        }

        $historia = Historia::create([
            'id_profesional' => $request->id_profesional,
            'informacion_relevante' => $request->informacion_relevante,
            'hora' => $request->hora,
            'fecha' => $request->fecha,
            'consecutivo' => $request->consecutivo ?? 1,
            'estado'=> $request->estado,
            'antecedentes' => $request->antecedentes,
            'evaluacion' => $request->evaluacion,
            'concepto' => $request->concepto,
            'recomendaciones' => $request->recomendaciones,
            'id_paciente'=> $request->id_paciente
        ]);
        $historia->consecutivo = $historia->id;
        $historia->save();
        if (!$historia) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'No hay historias registradas'],
                'errors' => $validator->errors()
            ];
            return response()->json($data, Response::HTTP_BAD_REQUEST);
        }
        $data = [
            'message' => ['type' => 'success', 'text' => 'Usuario creado correctamente'],
            'data' => [$historia]
        ];
        return response()->json($data, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $historia = Historia::find($id);
        if (!$historia) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'Historia no encontrada']
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND);
        }
        $data = [
            'message' => ['type' => 'success', 'text' => 'Historia encontrada correctamente'],
            'data' => [$historia]
        ];
        return response()->json($data, Response::HTTP_OK);
    }
    // funcion para mostrar las historias para un paciente
    public function show_paciente($id_paciente)
    {
        $historias = Historia::select('historias.*', 
        'profesional.document_number as profesional_document_number', 
        'profesional.name as profesional_name')
        ->join('users as profesional', 'profesional.id', '=', 'historias.id_profesional')
        ->where('historias.id_paciente', $id_paciente)
        ->get()->map(function ($value) {
            $value->usuario = $value->profesional_name . " " . $value->profesional_document_number;
            return $value;
        });

        if (!$historias) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'el paciente aun no tiene historias']
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND);
        }
        $data = [
            'message' => ['type' => 'success', 'text' => 'Historias encontradas correctamente'],
            'data' => ['historias' => $historias]
        ];
        return response()->json($data, Response::HTTP_OK);
    }
  // funcion para mostrar las historias creadas por un profesional
    public function show_profesional($id_profesional)
    {
        $historias = Historia::select('historias.*',
        'paciente.document_number as paciente_document_number', 
        'paciente.name as paciente_name')
        ->join('users as profesional', 'profesional.id', '=', 'historias.id_profesional')
        ->join('users as paciente', 'paciente.id', '=', 'historias.id_paciente')
        ->where('historias.id_profesional', $id_profesional)
        ->get()->map(function ($value) {           
            $value->usuario = $value->paciente_name . " " . $value->paciente_document_number;
            return $value;
        });

        if (!$historias) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'el profesional aun no tiene historias']
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND);
        }
        $data = [
            'message' => ['type' => 'success', 'text' => 'Historias encontradas correctamente'],
            'data' => ['historias' => $historias]
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
        $historia = Historia::find($id);
        if (!$historia) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'Usuario no encontrado']
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND);
        }
        $validator = Validator::make($request->all(), [
            'id_profesional' => 'required',
            'informacion_relevante' => 'required|max:600',
            'hora' => 'required|date_format:H:i',
            'fecha' => 'required|date_format:Y-m-d',
            'consecutivo' => 'required',
            'estado' => 'max:40|in:pendiente,asistida',
            'antecedentes' => 'max:600',
            'evaluacion' => '',
            'concepto' => '',
            'recomendaciones' => '',
            'estado' => '',
            'id_paciente' => 'required'
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'Error en la validación de los datos'],
                'errors' => $validator->errors()
            ];
            return response()->json($data, Response::HTTP_BAD_REQUEST);
        }
        $historia->id_profesional = $request->id_profesional;
        $historia->informacion_relevante = $request->informacion_relevante;
        $historia->hora = $request->hora;
        $historia->fecha = $request->fecha;
        $historia->consecutivo = $request->consecutivo;
        $historia->estado_paciente = $request->estado_paciente;
        $historia->antecedentes = $request->antecedentes;
        $historia->evaluacion = $request->evaluacion;
        $historia->concepto = $request->concepto;
        $historia->recomendaciones = $request->recomendaciones;
        $historia->estado = $request->estado;
        $historia->id_paciente = $request->id_paciente;
        $historia->save();
        $data = [
            'message' => ['type' => 'success', 'text' => 'Usuario modificado correctamente'],
            'data' => [$historia]
        ];
        return response()->json($data, Response::HTTP_OK);
    }
    public function updatePartial($id, Request $request)
    {
        $historia = Historia::find($id);
        if (!$historia) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'Usuario no encontrado']
            ];
            return response()->json($data, 404);
        }
        $validator = Validator::make($request->all(), [
            'id_profesional' => '',
            'informacion_relevante' => 'max:600',
            'hora' => 'date_format:H:i',
            'fecha' => 'date_format:Y-m-d',
            'consecutivo' => '',
            'estado' => 'max:40|in:pendiente,asistida',
            'antecedentes' => 'max:600',
            'evaluacion' => '',
            'concepto' => '',
            'recomendaciones' => '',
            'id_paciente' => ''
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'Error en la validación de los datos'],
                'errors' => $validator->errors()
            ];
            return response()->json($data, Response::HTTP_BAD_REQUEST);
        }
        if ($request->has('id_profesional')) {
            $historia->id_profesional = $request->id_profesional;
        }
        if ($request->has('informacion_relevante')) {
            $historia->informacion_relevante = $request->informacion_relevante;
        }
        if ($request->has('hora')) {
            $historia->hora = $request->hora;
        }
        if ($request->has('fecha')) {
            $historia->fecha = $request->fecha;
        }
        if ($request->has('consecutivo')) {
            $historia->consecutivo = $request->consecutivo;
        }
        if ($request->has('estado')) {
            $historia->estado = $request->estado;
        }
        if ($request->has('antecedentes')) {
            $historia->antecedentes = $request->antecedentes;
        }
        if ($request->has('evaluacion')) {
            $historia->evaluacion = $request->evaluacion;
        }
        if ($request->has('concepto')) {
            $historia->concepto = $request->concepto;
        }
        if ($request->has('recomendaciones')) {
            $historia->recomendaciones = $request->recomendaciones;
        }
        if ($request->has('id_paciente')) {
            $historia->id_paciente = $request->id_paciente;
        }
        $historia->save();
        $data = [
            'message' => ['type' => 'success', 'text' => 'Historia modificada correctamente'],
            'data' => [$historia]
        ];
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $historia = Historia::find($id);
        if (!$historia) {
            $data = [
                'message' => ['type' => 'error', 'text' => 'Historia no encontrada']
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND );
        }
        $historia->delete();
        $data = [
            'message' => ['type' => 'success', 'text' => 'Historia eliminada'],
        ];
        return response()->json($data, Response::HTTP_OK);
    }
}
