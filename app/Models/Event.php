<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'title', 'description', 'date', 
        'location', 'price', 'stock', 'poster_path'
    ];

    // Menandakan atribut: 1 Event terpaut pada satu Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}


