 <div class="tab-pane" id="employees" role="tabpanel" aria-expanded="true">
                           
    <div class="row mb-2">
        <div class="col-6">
            <h4 class="mt-0 text-left">{{ @$company->name }} - Employees List </h4>
        </div>
        <div class="col-6 text-right">

            <button type="button" class="btn btn-danger mt-0"  onclick="return window.location.href='{{ route("companies.employees.create",['id' => request()->company ])  }}'">Add Employee
            </button>
        </div>

    </div>
  

    <!-- Categories Table -->
    <div class="table-responsive">

       <table id="project-types-table" class="table table-hover text-center">
                        <thead>
                        <tr class="text-danger">
                            <th>Acc. No.</th>
                            <th>Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                          @foreach($employees as $k => $employee)
                         <tr>
                           <td> {{ $k + 1 }}</td>
                           <td>{{ $employee->last_name.' '.$employee->first_name}} {{ ($employee->dob) ? '('.$employee->dob.')' : ''}}</td>
                          <td>        
                            <button onclick="return window.location.href='{{ request()->company }}/employees/{{$employee->id}}'" rel="tooltip" class="btn btn-neutral bg-transparent btn-icon" data-original-title="Edit Company Type" title="Edit Company Type"> <i class="fa fa-edit text-success"></i> </button> 
                          </td>
                          <td>
                             <form 
                              method="post" 
                              action="{{route('companies.employees.destroy',['id' => request()->company,'eid' => $employee->id])}}"> 
                               @csrf
                              {{ method_field('DELETE') }}
          
                              <button 
                                type="submit"
                                onclick="return confirm('Are you sure?')"
                                class="btn btn-neutral bg-transparent btn-icon" data-original-title="Delete Trade" title="Delete"><i class="fa fa-trash text-danger"></i> </button>
                            </form>
                           </td>
                         </tr> 
                         @endforeach
                        <!-- Project Types Go Here -->
                        </tbody>
                    </table>

    </div>

</div>