<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhyPoint extends Model
{
    protected $table = 'why_points';
    protected $fillable = ['title', 'icon', 'description', 'is_active'];
}
