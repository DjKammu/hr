 <!-- Category Details -->
<div class="tab-pane" id="employees" role="tabpanel" 
aria-expanded="true">

<div class="row mb-2">
    <div class="col-6">
        <h4 class="mt-0 text-left"> {{ @$company->name }} - Employees</h4>
    </div>
</div>

 <form   method="post" 
          action="{{ route('companies.employees',$company->id) }}" enctype="multipart/form-data">
              @csrf
                
                <!-- Current Password -->
                    <div class="row">
                         <div class="col-lg-5 col-md-6 mx-auto">
                            <div class="form-group">
                                <label class="text-dark" for="password">Trades 
                                </label>
                                <select class="form-control" id="in-employees" name="employees[]" 
                                multiple=""> 
                                   @foreach($employees as $employee)
                                   <option value="{{ $employee->id }}"  {{ (in_array($employee->id , @$company->employees->pluck('id')->toArray())) ? 'selected' : ''}}>{{ $employee->first_name.' '.$employee->last_name}}
                                   </option>
                                  @endforeach

                                </select>
                            </div>
                        </div>
                       
                    </div>

                <!-- Submit Button -->
                <div class="col-12 text-center">
                    <button id="change-password-button" type="submit" class="btn btn-danger">Add Employee
                    </button>
                </div>

            </form>
          </div>
