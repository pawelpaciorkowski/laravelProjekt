<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory; // Jeśli dodajesz HasFactory

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name']; // Dodaj tę linię

    // Możesz również dodać tutaj relacje, jeśli tagi będą miały inne relacje niż z kursami
    // public function courses()
    // {
    //     return $this->belongsToMany(Course::class);
    // }
}
