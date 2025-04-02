<?php

namespace App\Http\Resources\Api\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ID' => $this->id,
            'Title' => $this->title,
            'Content' => $this->when(Route::currentRouteName() == 'posts.show',$this->content),
            'Category ID' => $this->category_id,
            'Category Name' => $this->category->title,
            'Created' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'Updated' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
