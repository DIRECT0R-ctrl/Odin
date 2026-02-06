<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Link;

class Tag extends Model
{
    protected $fillable = [
        'name'
    ];
    public function links()
    {
        return $this->belongsToMany(Link::class);
    }
}
