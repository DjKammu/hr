<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $perPage = 9;

    protected $fillable = [
     'name' ,'address_1' , 'address_2' ,
      'city','state' , 'country',
      'zip_code','notes' ,'photo',
      'company_type_id'
    ];

    public function company_type(){
    	return $this->belongsTo(CompanyType::class);
    }
    
    public function documents(){
      return $this->hasMany(Document::class);
    }
}
