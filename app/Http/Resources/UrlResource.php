<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UrlResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $property = $this->resource['type'];
        $this->resource['result'][$property];

        return ['url' =>  $this->resource['result'][$property], 'type' => $property];
    }
}
