<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'category_id',
    ];

    // Relacja: Kurs należy do jednej Kategorii
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relacja: Kurs może mieć wiele Tagów
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // Relacja: W kursie może uczestniczyć wielu Użytkowników
    public function participants()
    {
        return $this->belongsToMany(User::class);
    }
}
