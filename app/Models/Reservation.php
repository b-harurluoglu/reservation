<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    public function scopeAvailable($query, $startDate, $endDate) 
    {
        return $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($query) use($startDate, $endDate) {  
                        $query->where('start_date', '<', $startDate)
                                ->where('end_date', '>', $endDate);
                    });
    }
}
