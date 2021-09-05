<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignments extends Model
{
    use HasFactory;

    protected $fillable = ['title','description','deadline','classroom_id'];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function workouts()
    {
        return $this->belongsToMany(Workout::class, 'assignment_workouts', 'assignment_id', 'workout_id');
    }
}
