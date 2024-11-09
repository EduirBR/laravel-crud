<?php

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOption\None;

class studentController extends Controller
{
    public function getStudents()
    {
        $students = Students::all();

        $resp = [
            'message' => 'No message',
            'data' => $students
        ];
        return response()->json($resp, 200);
    }

    public function addStudent(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:students',
            'phone' => 'required|integer',
            'language' => 'required',
        ]);
        if ($validate->fails()) {
            $data = [
                'message' => 'Error en el registro',
                'errors' => $validate->errors()
            ];
            return response()->json($data, 400);
        }
        $newStudent = Students::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'language' => $request->language,
            ]
        );
        if (!$newStudent) {
            return response()->json(
                [
                    'message' => 'Error registering the student',
                    'data' => null,
                ]
            );
        }
        $data = [
            'message' => 'Student registered successfully',
            'data' => $newStudent,
        ];
        return response()->json($data, 201);
    }

    public function getStudentByID($id)
    {
        $student = Students::find($id);
        if (!$student) {
            return response()->json(
                [
                    'message' => 'Not found',
                    'data' => null
                ],
                404
            );
        }
        $data = [
            'message' => 'no message',
            'data' => $student
        ];
        return response()->json($data, 200);
    }
}
