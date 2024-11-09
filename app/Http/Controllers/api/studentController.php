<?php

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use App\Models\Students;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOption\None;

class studentController extends Controller
{
    // get all the students
    public function getStudents(): JsonResponse
    {
        $students = Students::all();

        $resp = [
            'message' => 'No message',
            'data' => $students
        ];
        return response()->json($resp, 200);
    }

    public function addStudent(Request $request): JsonResponse
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

    public function getStudentByID($id): JsonResponse
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

    public function deleteStudent($id): JsonResponse
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
        $student->delete();
        $data = [
            'message' => 'student deleted',
            'data' => []
        ];
        return response()->json($data, 200);
    }

    public function updateStudent(Request $request, $id): JsonResponse
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
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'email' => 'required|email|unique:students',
                'phone' => 'required|integer',
                'language' => 'required',
            ]
        );
        if ($validate->fails()) {
            $data = [
                'message' => 'Error en el registro',
                'errors' => $validate->errors()
            ];
            return response()->json($data, 400);
        }
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->language = $request->language;
        $student->save();
        $data = [
            'data' => $student,
            'message' => sprintf('Student %s updated successfully', $student->name)
        ];
        return response()->json($data, 200);
    }


    public function partialUpdateStudent(Request $request, $id): JsonResponse
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
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'max:255',
                'email' => 'unique:students',
                'phone' => 'integer',
                'language' => '',
            ]
        );
        if ($validate->fails()) {
            $data = [
                'message' => 'Error en el registro',
                'errors' => $validate->errors()
            ];
            return response()->json($data, 400);
        }
        if ($request->has('name')) {
            $student->name = $request->name;
        }
        if ($request->has('email')) {

            $student->email = $request->email;
        }
        if ($request->has('phone')) {

            $student->phone = $request->phone;
        }
        if ($request->has('language')) {

            $student->language = $request->language;
        }
        $student->save();
        $data = [
            'data' => $student,
            'message' => sprintf('Student %s updated successfully', $student->name)
        ];
        return response()->json($data, 200);
    }
}
