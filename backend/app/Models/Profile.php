<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    protected $fillable = [
        'user_id',
        'company_id',
    ];

    use HasFactory;

    public function profiles()
    {

        return $this->hasOne(User::class);
    }
}
