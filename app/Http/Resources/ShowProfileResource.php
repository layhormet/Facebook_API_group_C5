<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image_id' => $this ->image_id,
            'image' => $this->image->image_url ?? '',
            'bio' => $this ->bio,
            'user' => $this->user,
            
      
        ];
    }
}
