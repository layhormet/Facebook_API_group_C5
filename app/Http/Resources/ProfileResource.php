<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'user_id' => $this->user_id,
            'image_id'=>$this->image_id,
            'bio' => $this->bio,
            'image' => $this->image->image_url ?? '',
            'user' => $this->user->name ?? '',
            'created_at' => $this->created_at->format('d-m-Y'),
         
        ];
    }
}
