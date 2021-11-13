@extends('layouts.admin-app')

@section('title', 'Users')

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
                        <h4 class="mt-0 text-left">Edit User</h4>
                    </div>
                </div>

               <div class="row">
                        <div class="col-md-12">
                            <div class="card-body">
                                <form   method="post" 
                              action="{{ route('users.update',$user->id) }}">
                              <input type="hidden" name="_method" value="PUT">
                                  @csrf

                                    <!-- Current Password -->
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 mx-auto">
                                            <div class="form-group">
                                                <label class="text-dark" for="password">Name 
                                                </label>
                                                <input  name="name" value="{{ $user->name }}" type="text" class="form-control" placeholder="Role Name" required="">
                                            </div>
                                        </div>
                                    </div>
                                   
          
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 mx-auto">
                                            <div class="form-group">
                                                <label class="text-dark" for="password">{{ __('E-Mail Address') }} 
                                                </label>
                                                 <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required autocomplete="email">
                                            </div>
                                        </div>
                                    </div> 
                                    
                                     <div class="row">
                                        <div class="col-lg-5 col-md-6 mx-auto">
                                            <div class="form-group">
                                                <label class="text-dark" for="password">{{ __('Password') }} 
                                                </label>
                                                <input  name="password" type="password" class="form-control" value="{{ old('name') }}">
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 mx-auto">
                                            <div class="form-group">
                                                <label class="text-dark" for="password">{{ __('Confirm Password') }}
                                                </label>
                                                 <input type="password" class="form-control" name="password_confirmation" value="{{ old('email') }}">
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 mx-auto">
                                            <div class="form-group">
                                                <label class="text-dark" for="password">{{ __('User Role') }}
                                                </label>

                                                <select id="role" class="form-control" name="role" required>
                                                  <option>Select Role</option>
                                                @foreach($roles as $id => $role)
                                                    <option value="{{$id}}"
                                                     {{ @$selectedRole == $id ? 'selected' : '' }}>{{$role}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div> 

                                    <!-- Submit Button -->
                                    <div class="col-12 text-center">
                                        <button id="change-password-button" type="submit" class="btn btn-danger">Update User
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
