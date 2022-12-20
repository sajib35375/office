<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // role and user many to many relationship 1 Role has many user
    public function users(){
        return $this -> belongsToMany(User::class);
    }
}
