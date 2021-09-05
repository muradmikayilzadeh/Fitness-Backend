<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClassroomResource;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ClassroomResource::collection(Classroom::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $classroom = Classroom::create([
            'title' => $request->title,
            'description' => $request->description,
            'class_code' => $this->generateClassCode(),
            'cover_photo' => $request->cover_photo,
            'trainer_id' => auth()->user()->id
        ]);

        return new ClassroomResource($classroom);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $classroom = Classroom::findOrFail($id);
        return new ClassroomResource($classroom);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $classroom = Classroom::findOrFail($id);

        // check if currently authenticated user is the owner of the classroom
        if ($request->user()->id !== $classroom->trainer_id) {
            return response()->json(['error' => 'You can only edit your own classrooms.'], 403);
        }

        $classroom->update([
            'title' => $request->title,
            'description' => $request->description,
            'cover_photo' => $request->cover_photo,
        ]);
//
        return new ClassroomResource($classroom);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $classroom = Classroom::findOrFail($id);
        $classroom->delete();
        return response()->json(null, 204);
    }

    protected function generateClassCode(){
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($permitted_chars), 0, 6);
    }
}
