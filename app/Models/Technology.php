<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    use HasFactory;

    // Assegno la relazione con i progetti
    public function progects()
    {
        return $this->belongstoMany(Project::class);
    }
}
