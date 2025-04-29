<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParticipantResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        $data['created_at'] = $this->created_at->diffForHumans();
        $data['updated_at'] = $this->updated_at->format('Y-m-d');
        return $data;
    }
}
