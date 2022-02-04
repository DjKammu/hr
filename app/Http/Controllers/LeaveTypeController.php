<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveType;
use App\Models\Document;
use Gate;


class LeaveTypeController extends Controller
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

         $leaveTypes = LeaveType::orderBy('account_number');

         $leaveTypes = $leaveTypes->paginate((new LeaveType())->perPage); 
         
         return view('leave_types.index',compact('leaveTypes'));
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

        return view('leave_types.create');
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
              'name' => 'required|unique:leave_types',
              'account_number' => 'required|unique:leave_types',
        ]);

        $data['slug'] = \Str::slug($request->name);
            
        LeaveType::create($data);

        return redirect('leave-types')->with('message', 'Leave Type Created Successfully!');
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

         $type = LeaveType::find($id);
         return view('leave_types.edit',compact('type'));
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
              'name' => 'required|unique:leave_types,name,'.$id,
              'account_number' => 'required|unique:leave_types,account_number,'.$id,
        ]);

        $data['slug'] = \Str::slug($request->name);
         
         $type = LeaveType::find($id);
         $slug = $data['slug'];
         $oldSlug = $type->slug;
        
         if(!$type){
            return redirect()->back();
         }
          

         $type->update($data);

        return redirect('leave-types')->with('message', 'Leave Type Updated Successfully!');
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

         $leaveType = LeaveType::find($id);
         // $path = public_path().'/'. Document::PROJECT.'/'; 
         // @\File::copyDirectory($path.$project_type->slug, $path.Document::ARCHIEVED);
         // @\File::deleteDirectory($path.$project_type->slug);

         $leaveType->delete();       

        return redirect()->back()->with('message', 'Leave Type Delete Successfully!');
    }
}
