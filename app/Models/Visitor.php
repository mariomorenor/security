<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    public $additional_attributes = ["full_name_dni"];

    public function getFullNameDniAttribute()
    {
        return "$this->dni - $this->name $this->last_name" ;
    }
}
