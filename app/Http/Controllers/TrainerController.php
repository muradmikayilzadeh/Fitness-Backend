<?php

namespace App\Http\Controllers;

use App\Http\Resources\AssignmentResource;
use App\Http\Resources\ClassroomResource;
use App\Models\Assignments;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Illuminate\Events\queueable;

class TrainerController extends Controller
{

    //Classroom methods

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


    // Assignment methods
    public function addWorkout(Request $request)
    {
        $new_workout = DB::table("assignment_workouts")->insert([
            'assignment_id' => $request->assignment_id,
            'workout_id' => $request->workout_id,
            'repeats' => $request->repeats
        ]);

        return response()->json(['message' => 'Workout added successfully'], 200);
    }

    public function removeWorkout(Request $request)
    {
        $workout = DB::table("assignment_workouts")->where([["assignment_id",$request->assignment_id],["workout_id",$request->workout_id]]);
        $workout->delete();
        return response()->json(['message' => 'Workout removed successfully'], 200);
    }
}
