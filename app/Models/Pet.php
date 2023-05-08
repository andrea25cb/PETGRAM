<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $deleted = ['deleted_at'];


    protected $fillable = ['name', 'photo', 'description', 'species', 'adopted', 'age', 'gender'];


    // Define the relationship with the Adoption model
    public function adoptions()
    {
        return $this->hasMany(Adoption::class);
    }
}
