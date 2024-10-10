<?php

namespace App\Http\Resources;

use App\Models\FavoriteEstate;
use Illuminate\Http\Request;
use App\Traits\CurrencyTrait;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class EstateResource extends JsonResource
{
    use CurrencyTrait;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $type = $request->header('currency');
        $newPrice = $this->updateCurrency($type, $this->price);

        return [
            'id' => $this->id,
            'type' => $this->type,
            'property_category' => $this->property_category,
            'indicators' => $this->indicators,
            'name' => $this->name,
            'location' => $this->location,
            'description' => $this->description,
            'code' => $this->code,
            'space' => $this->space,
            'number_of_bedrooms' => $this->number_of_bedrooms,
            'number_of_bathrooms' => $this->number_of_bathrooms,
            'number_of_floors' => $this->number_of_floors,
            'number_of_parking_spaces' => $this->number_of_parking_spaces,
            'year_of_construction' => $this->year_of_construction,
            'geo_location' => json_decode($this->geo_location, true),
            'services' => json_decode($this->services, true),
            '3d_photo' => $this->{"3d_photo"},
            'blueprint' => $this->blueprint,
            'video_url' => $this->video_url,
            'price' => $newPrice,
            'rental_duration' => $this->rental_duration,
            'filters' => json_decode($this->filters, true),
            'user_id' => $this->user_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'photos' => json_decode($this->photos, true),
            'isFav' => FavoriteEstate::where('user_id', Auth::user()->id)
                ->where('estate_id', $this->id)
                ->first() ? true : false,
            'user'  => $this->user,
        ];
    }
}
