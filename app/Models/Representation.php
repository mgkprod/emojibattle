<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Representation extends Model
{
    protected $guarded = [];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function emoji()
    {
        return $this->belongsTo(Emoji::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
