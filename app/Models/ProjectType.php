<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model
{
    use HasFactory;

    protected $perPage = 20;

    protected $fillable = [
     'name' , 'slug' ,'account_number'
    ];

    public function projects(){
    	return $this->hasMany(Project::class);
    }
}
