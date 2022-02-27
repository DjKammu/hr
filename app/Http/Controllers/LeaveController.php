<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRule;
use App\Models\LeaveType;
use App\Models\Company;
use App\Models\Document;
use App\Models\Leave;
use Gate;


class LeaveController extends Controller
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

         $leaves = Leave::query();

         $leaves = $leaves->paginate((new Leave())->perPage); 
         
         return view('leaves.index',compact('leaves'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(Gate::denies('add')) {
               return abort('401');
         } 

         $companiesQry = Company::query(); 
         $companies = $companiesQry->get();

         $company = ($request->filled('c')) ? $companiesQry->where('id',$request->c)->first() 
                      : $companies->first();     

         $employees = @$company->employees()->get();  

         $leaveTypes = LeaveType::all(); 

        return view('leaves.create',compact('company','leaveTypes','companies','employees'));
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
              'company_id' => 'required|exists:companies,id',
              'employee_id' => 'required|exists:employees,id',
               'leave_type_id' => 'required|exists:leave_types,id',
        ]);
            

         $data['image'] = '';    

        if($request->hasFile('image')){
               $image = $request->file('image');
               $photoName = 'leave-'.time() . '.' . $image->getClientOriginalExtension();
              
               $data['image']  = $request->file('image')->storeAs(Document::LEAVES, $photoName, 
                'public');
        }

   
        Leave::create($data);

        return redirect('leaves')->with('message', 'Leave Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
          if(Gate::denies('edit')) {
               return abort('401');
          } 

         $leaveTypes = LeaveType::all(); 
         $companiesQry = Company::query(); 
         $companies = $companiesQry->get(); 

         $leave = Leave::find($id);

         $company = ($request->filled('c')) ? $companiesQry->where('id',$request->c)->first() 
                      : $leave->company()->first();

         $employees = (@$company->employees()->exists() ) ? @$company->employees()->get() : [];         

         return view('leaves.edit',compact('company','leaveTypes','companies','employees','leave'));
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
              'company_id' => 'required|exists:companies,id',
              'employee_id' => 'required|exists:employees,id',
              'leave_type_id' => 'required|exists:leave_types,id',
        ]);

         $leave = Leave::find($id);
        
         if(!$leave){
            return redirect()->back();
         }
          
        $data['image'] = $leave->image;    

        if($request->hasFile('image')){
               @unlink('storage/'.$leave->image);
               $image = $request->file('image');
               $photoName ='leave-'.time() . '.' . $image->getClientOriginalExtension();
              
               $data['image']  = $request->file('image')->storeAs(Document::LEAVES,
                $photoName, 'public');
        }
        
         
         $leave->update($data);

        return redirect('leaves')->with('message', 'Leave Updated Successfully!');
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

         $leave = Leave::find($id);

         $leave->delete();       

        return redirect()->back()->with('message', 'Leave Delete Successfully!');
    }
}
