<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassroomResource;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    //Classroom methods

    public function getAllClasses()
    {
        return ClassroomResource::collection(auth()->user()->classrooms);
    }

    public function getClass($id)
    {
        $hasClassroom = auth()->user()->classrooms()->where([["student_id",auth()->user()->id],["classroom_id",$id]])->exists();
        if ($hasClassroom != 1) {
            return response()->json(['error' => 'Permission denied'], 403);
        }
        $classroom = Classroom::findOrFail($id);
        return new ClassroomResource($classroom);
    }

    public function joinStudent(Request $request)
    {
        $classroom =  Classroom::where("class_code",$request->class_code)->get()->first();
        $relation = DB::table("classroom_students")->where([["classroom_id",$classroom->id],["student_id",auth()->user()->id]])->exists();
        if($relation != 1){
            DB::table("classroom_students")->insert([
                "classroom_id" => $classroom->id,
                "student_id" => auth()->user()->id
            ]);
            return response()->json(['message' => 'Joined to the classroom successfully'], 200);
        }else{
            return response()->json(['error' => 'Already joined to the classroom'], 403);
        }
    }

    public function leaveClass($classroom_id)
    {
        $relation = DB::table("classroom_students")->where([["classroom_id",$classroom_id],["student_id",auth()->user()->id]]);
        $relation->delete();
        return response()->json(['message' => 'Left classroom successfully'], 200);
    }
}
