<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentType;
use App\Models\Document;
use App\Models\CompanyType;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Proposal;
use App\Models\Category;
use App\Models\Vendor;
use Gate;


class CompanyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         if(Gate::denies('view')) {
               return abort('401');
         } 

         $companies = Company::query();

         if(request()->filled('s')){
            $searchTerm = request()->s;
            $companies->where('first_name', 'LIKE', "%{$searchTerm}%") 
            ->orWhere('social_society_number', 'LIKE', "%{$searchTerm}%")
            ->orWhere('phone_number_1', 'LIKE', "%{$searchTerm}%")
            ->orWhere('phone_number_2', 'LIKE', "%{$searchTerm}%")
            ->orWhere('eamil_address', 'LIKE', "%{$searchTerm}%")
            ->orWhere('middle_name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('last_name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('address_1', 'LIKE', "%{$searchTerm}%")
            ->orWhere('address_2', 'LIKE', "%{$searchTerm}%")
            ->orWhere('zip_code', 'LIKE', "%{$searchTerm}%")
            ->orWhere('country', 'LIKE', "%{$searchTerm}%")
            ->orWhere('city', 'LIKE', "%{$searchTerm}%")
            ->orWhere('state', 'LIKE', "%{$searchTerm}%")
            ->orWhere('notes', 'LIKE', "%{$searchTerm}%");
         }  

         if(request()->filled('p')){
            $p = request()->p;
            $companies->whereHas('company_type', function($q) use ($p){
                $q->where('slug', $p);
            });
         } 
         
         $companyTypes = CompanyType::all(); 

         $perPage = request()->filled('per_page') ? request()->per_page : (new Company())->perPage;

         $companies = $companies->paginate($perPage);

         return view('companies.index',compact('companies','companyTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('add')) {
               return abort('401');
         } 

           $companyTypes = CompanyType::all(); 

        return view('companies.create',compact('companyTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          if(Gate::denies('add')) {
               return abort('401');
        } 

        $data = $request->except('_token');

        $request->validate([
              'name' => 'required|unique:companies,name',
              'company_type_id' => 'required|exists:company_types,id'
        ]);

        $slug = \Str::slug($request->name);

        $data['photo'] = '';    

        if($request->hasFile('photo')){
               $photo = $request->file('photo');
               $photoName = $slug.'-'.time() . '.' . $photo->getClientOriginalExtension();
              
               $data['photo']  = $request->file('photo')->storeAs(Document::COMPANIES, $photoName, 'public');
        }

        $company = Company::create($data);

        $company_type = $company->company_type;

        $path = public_path().'/'.Document::COMPANY.'/' . $company_type->slug.'/'.$slug;
        \File::makeDirectory($path, $mode = 0777, true, true);

        return redirect('companies')->with('message', 'Company Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
          if(Gate::denies('edit')) {
               return abort('401');
          } 

         $company = Company::find($id);
         $companyTypes = CompanyType::all();

         $documentTypes = DocumentType::all();
         $employees = Employee::all();
         $documents = $company->documents();


        //   if(request()->filled('payment_subcontractor')){
        //         $subcontractor = request()->payment_subcontractor;
        //         $payments->where('subcontractor_id', $subcontractor);
        //  } 

        //  if(request()->filled('payment_vendor')){
        //         $payment_vendor = request()->payment_vendor;
        //         $payments->where('vendor_id', $payment_vendor);
        //  } 

        //  if(request()->filled('payment_trade')){
        //         $payment_trade = request()->payment_trade;
        //         $payments->where('trade_id', $payment_trade);
        //  } 

        //  if(request()->filled('payment_status')){
        //         $payment_status = request()->payment_status;
        //         $payments->where('status', $payment_status);
        //  } 
        
        //  $orderBy = 'date';  
        //  $order ='DESC' ;
                    
        // if(request()->filled('order')){
        //     $orderBy = request()->filled('orderby') ? ( !in_array(request()->orderby, 
        //         ['date','invoice_number'] ) ? 'date' : request()->orderby ) : 'date';
            
        //     $order = !in_array(\Str::lower(request()->order), ['desc','asc'])  ? 'ASC' 
        //      : request()->order;
        // }

        //  $payments = $payments->orderBy($orderBy, $order)->get();

        //  if(request()->filled('s')){
        //     $searchTerm = request()->s;
        //     $documents->where('name', 'LIKE', "%{$searchTerm}%") 
        //     ->orWhere('slug', 'LIKE', "%{$searchTerm}%");
        //  }  

        //  if(request()->filled('document_type')){
        //         $document_type = request()->document_type;
        //         $documents->whereHas('document_type', function($q) use ($document_type){
        //             $q->where('slug', $document_type);
        //         });
        //  }

        //  if(request()->filled('vendor')){
        //         $vendor = request()->vendor;
        //         $documents->where('vendor_id', $vendor);
        //  } 
        
    
        //   if(request()->filled('subcontractor')){
        //         $subcontractor = request()->subcontractor;
        //         $documents->where('subcontractor_id', $subcontractor);
        //  } 

        
        //  $trade = @$trades->first()->id;
        
        //  if(request()->filled('trade')){
        //         $trade = request()->trade;  
        //  } 
        
        //  $awarded = @$project->proposals()->IsAwarded()->exists();

        //  $proposalQuery = @$project->proposals();

        //  $awardedProposals = $proposalQuery->IsAwarded()->get();

        //  $paymentTrades = @$awardedProposals->map(function($prpsl){
        //          return $prpsl->trade;
        //  })->unique();

        //  $paymentSubcontractors = @$awardedProposals->map(function($prpsl){
        //          return $prpsl->subcontractor;
        //  })->unique();
         
        //  if(request()->filled('proposal_trade')){
        //         $proposal_trade = request()->proposal_trade;
        //         $proposalsIds = @$project->proposals()->trade($proposal_trade)->pluck('id');
        //         $documents->whereIn('proposal_id', $proposalsIds);
        //  }
    
        //  $allProposals = @$project->proposals()->get();
        //  $proposals = @$project->proposals()->trade($trade)->get();
              
         $perPage = request()->filled('per_page') ? request()->per_page : (new Company())->perPage;

         $documents = $documents->with('document_type')
                    ->paginate($perPage);


        $documents->filter(function($doc){

            $company = @$doc->company;

            $company_slug = \Str::slug($company->name);

            $document_type = @$doc->document_type->slug;

            $company_type_slug = @$company->company_type->slug;

            $folderPath = Document::COMPANY."/";

            $company_type_slug = ($company_type_slug) ? $company_type_slug : Document::ARCHIEVED;

            $folderPath .= "$company_type_slug/$company_slug/$document_type/";
            
            // if($doc->proposal_id){
            //      $proposal = Proposal::find($doc->proposal_id);
            //      $trade_slug = @\Str::slug($proposal->trade->name);
            //      $folderPath = ($doc->document_type->name == DocumentType::INVOICE) ? Document::INVOICES."/" : Document::PROPOSALS."/";
            //      $folderPath .= "$project_slug/$trade_slug/";
            // }

            $files = $doc->files();

            $file =  ($files->count() == 1) ? $files->pluck('file')->first() : '';

            $doc->file = ($file  ? asset($folderPath.$file) : '') ;

            return $doc->file;
           
         });
       

        //   $proposals->filter(function($proposal){

        //     $project = @$proposal->project;

        //     $project_slug = \Str::slug($project->name);

        //     $trade_slug = @\Str::slug($proposal->trade->name);

        //     $project_type_slug = @$project->project_type->slug;

        //     $folderPath = Document::PROPOSALS."/";

        //     $folderPath .= "$project_slug/$trade_slug/";
            
        //     $files = $proposal->files;

        //     $files = @array_filter(explode(',',$files));

        //     $filesArr = [];
            
        //     if(!empty($files)){
        //        foreach (@$files as $key => $file) {
        //            $filesArr[] = asset($folderPath.$file);
        //         }  
        //     } 

        //     $proposal->files = @($filesArr) ? @implode(',',$filesArr) : '' ;

        //     return $proposal->files;
           
        //  });


        //   $payments->filter(function($payment){

        //     $project = @$payment->project;

        //     $project_slug = \Str::slug($project->name);

        //     $trade_slug = @\Str::slug($payment->trade->name);

        //     $project_type_slug = @$project->project_type->slug;

        //     $folderPath = Document::INVOICES."/";

        //     $folderPath .= "$project_slug/$trade_slug/";
        
        //     $payment->file = @($payment->file) ? asset($folderPath.$payment->file) : '' ;

        //     $payment->remaining = (new PaymentController)->proposalDueAmount($payment->proposal,$payment->id);

        //     return $payment->file;
           
        //  });

         // $catids = @($trades->pluck('category_id'))->unique();

         // $categories = Category::whereIn('id',$catids)->get(); 

         // $subcontractorsCount = @$project->proposals()
         //                          ->withCount('subcontractor')
         //                         ->orderBy('subcontractor_count', 'DESC')
         //                          ->pluck('subcontractor_count')->max(); 

         return view('companies.edit',compact('company','companyTypes','documentTypes','employees','documents'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Gate::denies('update')) {
               return abort('401');
        } 

       $data = $request->except('_token');

       $request->validate([
              'name' => 'required|unique:companies,name,'.$id,
              'company_type_id' => 'required|exists:company_types,id'
        ]);
     
        $slug = \Str::slug($request->name);
         
        $company = Company::find($id);
        $oldSlug = \Str::slug($company->name);

        if(!$company){
            return redirect()->back();
        }

        $data['photo'] = $company->photo;    

        if($request->hasFile('photo')){
               @unlink('storage/'.$company->photo);
               $photo = $request->file('photo');
               $photoName = $slug.'-'.time() . '.' . $photo->getClientOriginalExtension();
              
               $data['photo']  = $request->file('photo')->storeAs(Document::COMPANIES, $photoName, 'public');
        }
        
        $oldCompany_type = CompanyType::find($company->company_type_id);
        $company_type = CompanyType::find($request->company_type_id);

        if(!$oldCompany_type){

                $public_path = public_path().'/'.Document::COMPANY.'/';
                $folderPath =  $company_type->slug.'/'.$oldSlug;
                $oldFolderPath = Document::ARCHIEVED.'/'.$oldSlug; 
               \File::copyDirectory($public_path.$oldFolderPath,$public_path.$folderPath); 
               \File::deleteDirectory($public_path.$oldFolderPath);
               
               if($slug  != $oldSlug){
                  $path = public_path().'/'.Document::COMPANY.'/'.@$company_type->slug.'/';
                  @rename($path.$oldSlug, $path.$slug); 
               }

        }
        elseif((@$oldCompany_type->id != $request->company_type_id) || 
            ($slug != $oldSlug)){
             
             if($slug  != $oldSlug){
                 $path = public_path().'/'.Document::COMPANY.'/'.@$oldCompany_type->slug.'/';
                 @rename($path.$oldSlug, $path.$slug); 
             }


             if(@$oldCompany_type->id != $request->company_type_id)
             { 
               $path = public_path().'/'.Document::PROJECT.'/';
               $projectDir  = ($slug  != $oldSlug) ? $slug : $oldSlug;
                \File::copyDirectory($path.@$oldCompany_type->slug.'/'.$projectDir,
                 $path.$project_type->slug.'/'.$oldCompany_type); 
               \File::deleteDirectory($path.@$oldCompany_type->slug.'/'.$projectDir);
             }
        }

         $company->update($data);

        return redirect('companies')->with('message', 'Company Updated Successfully!');
    }


    public function addEmployees(Request $request, $id)
    {
        if(Gate::denies('update')) {
               return abort('401');
        } 

        $data = $request->except('_token');

        $company = Company::find($id);

        if(!$company){
            return redirect()->back();
        }
        
        $company->employees()->sync($request->employees); 

        return redirect(route('companies.show',['company' => $id]).'#employees')->with('message', 'Employee Successfully!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         if(Gate::denies('delete')) {
               return abort('401');
          } 

         $company = Company::find($id);
         $company_slug = \Str::slug($company->name);
         $company_type = @$company->company_type;

         $company_type_slug = @$company_type->slug;

         $public_path = public_path().'/';

         $folderPath = Document::COMPANY."/";

         $company_type_slug = ($company_type_slug) ? $company_type_slug : Document::ARCHIEVED; 

         $folderPath .= "$company_type_slug/$company_slug";

         $path = $public_path.'/'.$folderPath;


         $aPath = public_path().'/'.Document::COMPANY.'/'.Document::ARCHIEVED.'/'.Document::COMPANIES; 
         
         @\File::makeDirectory($aPath, $mode = 0777, true, true);

         @\File::copyDirectory($path, $aPath.'/'.$project_slug);

         @\File::deleteDirectory($path);

         @unlink('storage/'.$company->photo);

         $company->delete();

        return redirect()->back()->with('message', 'Company Delete Successfully!');
    }
}
