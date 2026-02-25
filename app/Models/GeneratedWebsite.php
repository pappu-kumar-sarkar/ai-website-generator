<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneratedWebsite extends Model
{
    protected $fillable = [
        'business_type',
        'category',
        'design',
        'prompt',
        'ai_response'
    ];
}
