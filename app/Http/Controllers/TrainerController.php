<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassroomResource;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainerController extends Controller
{
    public function getAllClasses()
    {
        return ClassroomResource::collection(Classroom::where("trainer_id",auth()->user()->id)->get());
    }

    public function getClass($id)
    {
        $classroom = Classroom::findOrFail($id);
        if (auth()->user()->id !== $classroom->trainer_id) {
            return response()->json(['error' => 'Permission denied'], 403);
        }
        return new ClassroomResource($classroom);
    }

    public function removeStudentFromClassroom($classroom_id, $student_id)
    {
        $classroom = Classroom::findOrFail($classroom_id);
        if(auth()->user()->id == $classroom->trainer_id){
            $relation = DB::table("classroom_students")->where([["classroom_id",$classroom->id],["student_id",$student_id]]);
            $relation->delete();
            return response()->json(['message' => 'Student removed successfully'], 200);
        }else{
            return response()->json(['error' => 'Permission denied'], 403);
        }
    }
}
