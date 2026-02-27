<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubProjects extends Model
{
    protected $fillable = [
        'project_id',
        'header',
        'hero_section',
        'about_us',
        'review',
        'footer'
    ];

    protected $casts = [
        'header' => 'array',
        'hero_section' => 'array',
        'about_us' => 'array',
        'review' => 'array',
        'footer' => 'array',
    ];
}
