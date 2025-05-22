<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        $data = [
            'status'=>'200',
            'students'=> $students,
        ];

   return response()->json($data,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'name' =>'required',
            'email'=> 'required',
            'phone'=>'required',

        ]);
        if ($validator->fails())
        {
            $data = [
                'status' => '422',
                'message' => $validator->messages()

            ];
            return response()->json($data,422);
        }
        else {

            $student = new Student;
            $student->name = $request->name;
            $student->email = $request->email;
            $student->phone = $request->phone;
            $student->save();
            $data = [
                'status'=> '200',
                'message'=>'data uploaded successfully'


              ];
            return response()->json($data,200);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //  $validator = Validator::make($request->all(),
        // [
        //     'name' =>'required',
        //     'email'=> 'required',
        //     'phone'=>'required',

        // ]);
        // if ($validator->fails())
        // {
        //     $data = [
        //         'status' => '422',
        //         'message' => $validator->messages()

        //     ];
        //     return response()->json($data,422);
        // }
        // else {

        //     $student = Student::find($id);
        //     $student->name = $request->name;
        //     $student->email = $request->email;
        //     $student->phone = $request->phone;
        //     $student->save();
        //     $data = [
        //         'status'=> '200',
        //         'message'=>'data uploaded successfully'


        //       ];
        //     return response()->json($data,200);
        // }
     $student = Student::find($id);
if (!$student) {
    return response()->json([
        'message' => 'Student not found',
        'status' => false,
    ], 404);
}

$validator = Validator::make($request->all(), [
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:students,email,'.$id,
    'phone' => 'required|string|max:20',
]);

if ($validator->fails()) {
    return response()->json([
        'message' => 'Validation failed',
        'errors' => $validator->errors(),
        'status' => false,
    ], 422);
}

try {
    $student->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
    ]);

    return response()->json([
        'message' => 'Student updated successfully',
        'data' => $student,
        'status' => true,
    ], 200);

} catch (\Exception $e) {
    return response()->json([
        'message' => 'Error updating student',
        'error' => $e->getMessage(),
        'status' => false,
    ], 500);
}


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
