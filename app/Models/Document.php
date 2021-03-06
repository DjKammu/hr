<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

     CONST ARCHIEVED = 'archived';
     CONST DOCUMENTS = 'documents';
     CONST PROJECTS  = 'projects';
     CONST PROPOSALS = 'proposals';
     CONST INVOICES  = 'invoices';
     CONST PROJECT   = 'project';

     CONST EMPLOYEES  = 'employees';
     CONST LEAVES     = 'leaves';

    CONST COMPANIES  = 'companies';
    CONST COMPANY    = 'company';

     protected $fillable = [
     'name' , 'slug' ,'account_number',
     'file','property_id','tenant_id',
     'document_type_id','vendor_id',
     'subcontractor_id', 'proposal_id',
     'payment_id'
    ];


    public function document_type(){

        return $this->belongsTo(DocumentType::class);
    }

    public function company(){
    	return $this->belongsTo(Company::class);
    }

    

    public function files(){
        return $this->hasMany(DocumentFile::class);
    }

    public function scopePropertyIds($query,$ids){
         return $query->whereIn('property_id',$ids);
    }

    public function scopeIsProposal($query,$id){
         return $query->where('proposal_id',$id);
    }
}
