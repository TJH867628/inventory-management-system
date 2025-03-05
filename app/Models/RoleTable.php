<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleTable extends Model
{
    use HasFactory;
    protected $table = 'roles';

    protected $fillable = ['id','name']; // Allow mass assignment

    // Define relationship with users
    public function users()
    {
        return $this->hasMany(User::class);
    }
}