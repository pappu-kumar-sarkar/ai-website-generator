<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'user_prompt'
    ];

    public function subProject()
    {
        return $this->hasOne(SubProjects::class);
    }
}
