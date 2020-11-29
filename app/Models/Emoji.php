<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emoji extends Model
{
    protected $guarded = [];

    protected $table = "emojis";

    public function representations()
    {
        return $this->hasMany(Representation::class);
    }
}
