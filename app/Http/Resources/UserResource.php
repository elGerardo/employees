<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'full_name' => $this->name . ' ' . $this->last_name,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'company' => $this->company,
            'area' => $this->area,
            'department' => $this->department,
            'job_title' => $this->job_title,
            'picture_url' => $this->picture_url,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        return $data;
    }
}
