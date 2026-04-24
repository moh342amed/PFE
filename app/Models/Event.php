<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'description', 'type', 'speaker_name', 'location', 'total_seats', 'available_seats', 'date_time', 'has_certificate', 'background_type', 'background_path'])]
class Event extends Model
{
    protected function casts(): array
    {
        return [
            'date_time' => 'datetime',
            'has_certificate' => 'boolean',
        ];
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
