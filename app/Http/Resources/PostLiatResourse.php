<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostLiatResourse extends JsonResource
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
            'content' => $this->content,
            'image' => $this->image,
            'video' => $this->video,
            'user' => $this->user,
            'like' => $this->getAllLike,
            'likes_count' => $this->countLike(),
        ];
    }
}
