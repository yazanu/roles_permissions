<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    @php
    
        $role_permissions = \App\Permission::where('permissions.role_id', auth()->user()->role_id)
        ->pluck('permissions.route_name')->toArray();
        
        $user_link = '';
        $product_link = '';
        $report_link = '';

        if(in_array("user.index", $role_permissions)!=null){
            $user_link = "users";
        }elseif(in_array("user.create", $role_permissions)!=null){
            $user_link = "users/create";
        }

        if(in_array("product.index", $role_permissions)!=null){
            $product_link = "products";
        }

        if(in_array("report.daily", $role_permissions)!=null){
            $report_link = "report-daily";
        }elseif(in_array("report.weekly", $role_permissions)!=null){
            $report_link = "report-weekly";
        }elseif(in_array("report.monthly", $role_permissions)!=null){
            $report_link = "report-monthly";
        }elseif(in_array("report.overall", $role_permissions)!=null){
            $report_link = "report-overall";
        }
    @endphp
    
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            @if (in_array("user.index", $role_permissions) || in_array("user.create", $role_permissions))
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Users
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="/users">
                                            User Lists
                                        </a>
                                        @if (in_array("permission.index", $role_permissions) || in_array("permission.edit", $role_permissions))
                                            @if (auth()->user()->role_id == 1)
                                            <a class="dropdown-item" href="/permissions">
                                                Roles & Permissions
                                            </a>
                                            @endif
                                        @endif
                                    </div>
                                </li>
                            @endif
                            @if (in_array("product.index", $role_permissions) || in_array("product.create", $role_permissions))
                                <li class="nav-item">
                                  <a href="{{url($product_link)}}" class="nav-link">Product</a> 
                                </li> 
                            @endif

                            @if (in_array("report.daily", $role_permissions) || in_array("report.weekly", $role_permissions) || in_array("report.monthly", $role_permissions) || in_array("report.report.overall", $role_permissions))
                                <li class="nav-item">
                                  <a href="{{url($report_link)}}" class="nav-link">Report</a> 
                                </li> 
                            @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
