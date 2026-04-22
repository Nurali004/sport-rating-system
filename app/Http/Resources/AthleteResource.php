<?php

namespace App\Http\Resources;

use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AthleteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Full Name' => $this->first_name. " ". $this->last_name,
            'Sport Turi' => new SportResource(Sport::find($this->sport_id))
        ];

    }
}
