<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class personal_access_token extends Model
{
    public function User(){
        return $this->belongsTo(User::class);
    }
}
