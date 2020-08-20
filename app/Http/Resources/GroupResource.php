<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $resource_array = [
                            'id' => $this->id,
                            'name' => $this->name,
                            'client_name' => $this->client_name,
                            'url' => $this->url,
                            'phone' => $this->phone,
                            'created_at' => $this->created_at->format('d/m/Y'),
                            'posts' => 0,
                            'comments' => 0,
                            'tags' => 0
                        ];

        return $resource_array;
    }
}
