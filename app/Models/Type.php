<?php

namespace App\Models;
// Non ho bisogno di importate Il modello Projects perchè si trova nella stessa cartella(Models) di Type.
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    // Assegno la relazione con i projects
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
