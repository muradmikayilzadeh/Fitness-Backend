<?php

namespace App\Http\Controllers;

use App\Http\Resources\AssignmentResource;
use App\Models\Assignments;
use App\Models\Classroom;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$classroom_id)
    {
        $classroom = Classroom::findOrFail($classroom_id);
        if(auth()->user()->id == $classroom->trainer_id){
            $assignment = Assignments::create([
                'title' => $request->title,
                'description' => $request->description,
                'classroom_id' => $classroom_id,
                'deadline' => $request->deadline,
            ]);
        }


        return new AssignmentResource($assignment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assignment = Assignments::findOrFail($id);
        return new AssignmentResource($assignment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $assignment = Assignments::findOrFail($id);
        $assignment->delete();
        return response()->json(null, 204);
    }
}
