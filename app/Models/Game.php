<?php

namespace App\Models;

use App\Contracts\Genreable;
use App\Traits\HasGenres;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model implements Genreable
{
    use HasFactory;
    use HasGenres;

    protected $fillable = [
        'name',
        'studio',
    ];
}
