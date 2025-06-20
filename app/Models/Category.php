<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Można dodać dla przyszłych seederów

class Category extends Model
{
    // use HasFactory; // Można dodać

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name']; // <-- DODAJ TĘ LINIĘ
}
