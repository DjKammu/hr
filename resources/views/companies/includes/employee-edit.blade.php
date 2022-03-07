@extends('layouts.admin-app')

@section('title', 'Trade')

@section('content')

@include('includes.back')

      <!-- Start Main View -->
  <div class="card p-2">
    <div class="row">
        <div class="col-md-12">
              <!-- Start Main View -->
            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show">
                  <strong>Success!</strong> {{ session()->get('message') }}
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
              </div>
            @endif

             @if ($errors->any())
               <div class="alert alert-warning alert-dismissible fade show">
                 <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Error!</strong>  
                   {{implode(',',$errors->all() )}}
                </div>
             @endif

            <div class="card-body">
              <div class="row mb-2">
                    <div class="col-6">
                        <h4 class="mt-0 text-left">{{ @$company->name }} - Edit Employee</h4>
                    </div>
                </div>

               <div class="row">
                        <div class="col-md-12">
                            <div class="card-body">
                                <form   method="post" 
                                action="{{ route('companies.employees.update',['id' => $company->id, 'eid' => $employee->id ]) }}" enctype="multipart/form-data">
                                    @csrf
                                      
                                      <!-- Current Password -->
                                          <div class="row">
                                               <div class="col-lg-5 col-md-6 mx-auto">
                                                  <div class="form-group">
                                                      <label class="text-dark" for="password">
                                                        Employees 
                                                      </label>
                                                      <select class="form-control" id="in-employees" name="employees"> 
                                                      
                                                         <option value="{{ $employee->id }}">{{ $employee->first_name.' '.$employee->last_name}}
                                                         </option>
                                                      </select>
                                                  </div>
                                              </div>
                                              </div>

                                            <div class="row">
                                              <div class="col-lg-5 col-md-6 mx-auto">
                                                <div class="form-group">
                                                  <label class="text-dark" for="password">
                                                    Date of Joining 
                                                  </label>
                                                  <input  name="date_of_joining" value="{{ $employee->pivot->date_of_joining }}" type="text" class=" form-control date" placeholder=" Date of Joining ">
                                                </div>
                                              </div>
                                             
                                          </div> 

                                          <div class="row">
                                              <div class="col-lg-5 col-md-6 mx-auto">
                                                <div class="form-group">
                                                  <label class="text-dark" for="password">
                                                    Termination Date
                                                  </label>
                                                  <input value="{{ $employee->pivot->termination_date }}" name="termination_date"  type="text" class=" form-control date" placeholder="Termination Date">
                                                </div>
                                              </div>
                                             
                                          </div>

                                      <!-- Submit Button -->
                                      <div class="col-12 text-center">
                                          <button id="change-password-button" type="submit" class="btn btn-danger">Update Employee
                                          </button>
                                      </div>

                                  </form>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('pagescript')

<script type="text/javascript">

$('.date').datetimepicker({
    format: 'Y-M-D'
});

</script>
@endsection
