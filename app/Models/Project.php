<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'description', 'web_platform', 'is_published', 'project_for', 'duration_project', 'type_id'];

    // Assegno la relazione con i types
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
