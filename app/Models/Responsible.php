<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsible extends Model
{
    use HasFactory;

    public $additional_attributes=["full_name"];

    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->last_name}";
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class,"client_responsible");
    }
}
