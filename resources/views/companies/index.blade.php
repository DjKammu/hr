@extends('layouts.admin-app')

@section('title', 'Companies')

@section('content')
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
                        <h4 class="mt-0 text-left">Companies List</h4>
                    </div>
                    <div class="col-6 text-right">
                        <button type="button" class="btn btn-danger mt-0"  onclick="return window.location.href='companies/create'">Add Company
                        </button>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-6">
                       <select style="height: 26px;" onchange="return window.location.href = '?p='+this.value"> 
                      <option>Select Company Types</option>
                      @foreach($companyTypes as $type)
                         <option value="{{ $type->slug }}" {{ (@request()->p == $type->slug) ? 'selected' : ''}}> {{ $type->name }}</option>
                      @endforeach
                      </select>
                      <input type="text" name="s" value="{{ @request()->s }}" id="inputSearch" >
                      <button id="search">Search</button>
                    </div>
                    <div class="col-6 text-right">
                       <label>Per Page </label>
                      <select style="height: 26px;" name="per_page"  onchange="selectPerpage(this.value)"> 
                        <option value="">Per Page</option>
                        <option value="25" {{ (request()->per_page == 25) ? 'selected' : ''}}>25</option>
                        <option value="50" {{ (request()->per_page == 50) ? 'selected' : ''}}>50</option>
                        <option value="100" {{ (request()->per_page == 100) ? 'selected' : ''}}> 100</option>
                        <option value="150" {{ (request()->per_page == 150) ? 'selected' : ''}}>150</option>
                        </select>
                    </div>
                </div>
                <!-- Categories Table -->
                <div class="table-responsive">

                  <table id="subcontractors-table" class="table card-table dataTable no-footer" role="grid" aria-describedby="subcontractors-table_info">
                         <thead class="d-none">
                            <tr role="row">
                               <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;"></th>
                            </tr>
                         </thead>
                         <tbody class="row">
                          @foreach($companies as $company)
                            <tr class="text-center col-lg-4 col-sm-6 odd" style="display: flex; flex-wrap: wrap;" role="row">
                               <td>
                                  <a style="text-decoration: none; position: relative;" href="companies/{{ $company->id }}">
                                    <span class="cross"> 
                                     <form 
                                        method="post" 
                                        action="{{route('companies.destroy',$company->id)}}"> 
                                         @csrf
                                        {{ method_field('DELETE') }}

                                        <button 
                                          type="submit"
                                          onclick="return confirm('Are you sure?')"
                                          class="btn btn-neutral bg-transparent btn-icon" data-original-title="Delete Employee" title="Delete Employee "><i class="fa fa-trash text-danger"></i> </button>
                                      </form>
                                    </span>
                                     <div class="card card-user card-table-item" style="width: 100%; height: 100%;">
                                        <div class="card-body pb-0">
                                           <div class="author mt-1">
                                              <img class="avatar border-gray" src="{{ ($company->photo) ? url(\Storage::url($company->photo)) : asset('img/image_placeholder.png') }}">                        
                                              <h5 class="title mb-0">{{ $company->name }}</h5>
                                           </div>
                                        </div>
                                     </div>
                                  </a>
                               </td>
                            </tr>

                            @endforeach
                         </tbody>
                      </table>
                </div>

                {!! $companies->render() !!}
            </div>
        </div>
    </div>
</div>

@endsection

@section('pagescript')

<script type="text/javascript">

  $(document).ready(function(){

  $('#search').click(function(){
        var search = $('#inputSearch').val();

        if(!search){
         // alert('Please enter to search');
        }
        window.location.href = '?s='+search;
  });

  $(document).keyup(function(event) {
    if (event.keyCode === 13) {
        $("#search").click();
    }
});
  });

    function selectPerpage(perPage){
     var fullUrl = window.location.href;
     let isPerpage = '{{ Request::input("per_page")}}';

     if(!isPerpage){
       window.location.href = fullUrl+(fullUrl.includes('?')?'&':'?')+'per_page='+perPage;
     }
     else if(isPerpage != perPage){
       window.location.href = fullUrl.replace(isPerpage, perPage)
     }
  } 


</script>
<style type="text/css">
  
span.cross{
    position: absolute;
    z-index: 10;
    left: 30px;
    display: none;
}
tr a:hover span.cross{
  display: block;
}
button.btn.btn-neutral.bg-transparent.btn-icon{
  background-color: transparent !important;
}
td{
  width: 100%;
}
</style>
@endsection