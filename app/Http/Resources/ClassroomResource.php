<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassroomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $response = [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'class_code' => $this->class_code,
            'cover_photo' => $this->cover_photo,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'trainer' => $this->trainer->name,
        ];

        if(isset(auth()->user()->id) && $this->trainer_id == auth()->user()->id){
            $response['students'] = $this->students;
        }

        return $response;
    }
}
