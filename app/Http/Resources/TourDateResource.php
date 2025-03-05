<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourDateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...parent::toArray($request),
            'pricing_lists' => PricingListResource::collection($this->whenLoaded('pricing_lists'))
        ];
        // array_merge([
        //     
        // ], 
    }
}
