<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    // use HasFactory;

    protected $fillable = ['link_id', 'user_agent', 'visited_at'];

    protected $dates = ['visited_at'];

    public $timestamps = false;
}
