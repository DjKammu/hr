<!-- Sidebar -->
<div class="sidebar" data-color="default" data-active-color="danger">

    <!-- Sidebar Logo -->
    <div class="logo">
        <a href="/" class="simple-text logo-mini">
            <div class="logo-image-small">
                <img src="{{ asset('img/favicon.png') }}">
            </div>
        </a>
        <a href="/" class="simple-text logo-normal">
           Human Resources
        </a>
    </div>

    <!-- Menu Starts -->
    <div class="sidebar-wrapper" style="overflow-x: hidden;">
        <div class="user">
            <div class="photo">
                <img src="{{ asset('images/profile-pictures/default.jpg') }}" />
            </div>
            <div class="info">
                <a data-toggle="collapse" href="#sideBarCollapse" class="collapsed">
                    <span>
                        HR ADMIN  <b class="caret"></b>
                    </span>
                </a>
                <div class="clearfix"></div>
                <div class="{{ !Request::is('profile') ? 'collapse' : '' }}" id="sideBarCollapse">
                    <ul class="nav">

                        <!-- Profile -->
                        <li class="{{ Request::is('profile') ? 'active' : '' }}">
                            <a href="{{ route('profile') }}">
                                <i class="fa fa-user"></i>
                                <span class="sidebar-normal">My Profile</span>
                            </a>
                        </li>

                        <!-- Logout -->
                        <li>
                            <a class="menz-edit mt-3" href="{{ route('logout') }}"
                             onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                               <i class="fa fa-sign-out"></i>
                                <span class="sidebar-normal">Logout</span>
                          </a>

                          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                              @csrf
                          </form>
                           
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">

            <!-- Dashboard -->
            <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <!-- <i class="nc-icon nc-bank"></i> -->
                    <i class="fa fa-home"></i>
                    <p>Dashboard</p>
                </a>
            </li>
             
            @can('view')
             
                  <!-- Property Types -->
             <li class="{{ Request::is('companies*') ? 'active' : '' }}">
                <a href="{{ route('companies.index') }}">
                    <i class="fa fa-building-o"></i>
                    <p>Companies</p>
                </a>
            </li>


             
            @endcan


             @can('view')

     
  <!-- Property Types -->
            <!--  <li class="{{ Request::is('documents*') ? 'active' : '' }}">
                <a href="{{ route('documents.search') }}">
                    <i class="nc-icon nc-bank"></i>
                    <i class="fa fa-search"></i>
                    <p>Search Documents</p>
                </a>
            </li>
 -->
            @endcan


            @can('view')

            <!-- Property Types -->
            <!--  <li class="{{ Request::is('document-types*') ? 'active' : '' }}">
                <a href="{{ route('document-types.index') }}">
                    <i class="nc-icon nc-bank"></i>
                    <i class="fa fa-file"></i>
                    <p>Document Types</p>
                </a>
            </li> -->

            @endcan


            @can('view')

            <!-- Property Types -->
           <!--   <li class="{{ Request::is('files*') ? 'active' : '' }}">
                <a href="{{ route('files.index') }}">
                    <i class="nc-icon nc-bank"></i>
                    <i class="fa fa-folder"></i>
                    <p>Files</p>
                </a>
            </li> -->

            @endcan

            @can('view')

            <!-- Property Types -->
             <li class="{{ Request::is('setup*') ? 'active' : '' }}">
                <a href="{{ route('setup') }}">
                    <!-- <i class="nc-icon nc-bank"></i> -->
                    <i class="fa fa-cog"></i>
                    <p>Setup</p>
                </a>
            </li>

            @endcan
           
              @can('add_users')
             <!-- Property Types -->
             <!-- <li class="{{ Request::is('roles*') ? 'active' : '' }}">
                <a href="{{ route('roles.index') }}">
                    <i class="nc-icon nc-bank"></i>
                    <i class="fa fa-user-circle"></i>
                    <p>Roles</p>
                </a>
            </li> -->
       
             <!-- Property Types -->
             <!-- <li class="{{ Request::is('users*') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}">
                    <i class="nc-icon nc-bank"></i>
                    <i class="fa fa-user"></i>
                    <p>Users</p>
                </a>
            </li> -->
            @endcan

        </ul>
    </div>
</div>        <!-- End Side Menu -->