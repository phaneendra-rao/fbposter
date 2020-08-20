<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->type == 0)
        {
            $userType = 'Admin';
        }
        else if($this->type == 1)
        {
            $userType = 'Member Manager';
        }
        else if($this->type == 2)
        {
            $userType = 'Commenter';
        }

        $resource_array = [
                            'id' => $this->id,
                            'name' => $this->name,
                            'email' => $this->email,
                            'type' => $userType
                        ];

        return $resource_array;
    }
}
