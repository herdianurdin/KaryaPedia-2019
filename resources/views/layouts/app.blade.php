<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('/favicon.png') }}" type="image/png">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/custom.js') }}" defer></script>

    <!-- Font Awesome -->
    <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        * {
            user-select: none;
            outline:0;
        }
        footer, nav {
            box-shadow: 0 .5px 6px rgba(0, 0, 0, .05);
        }
    </style>

    @if ((Request::is('/')) || (Request::is('kategori/*')) || (Request::is('cari')))
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    @endif

    @if ((Request::is('admin*')) && !(Request::is('admin/transaksi/detail/*')))
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @endif

    @if ((Request::is('keranjang')) || (Request::is('checkout/konfirmasi')) || (Request::is('transaksi/detail/*')) || (Request::is('admin/transaksi/detail/*')))
    <style>
        .img-fit{
            width: 150px
        }
        .table thead th {
            border-top: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
        }
        .table td, .table th {
            border-top: 0;
            border-bottom: 1px solid #dee2e6;
        }
        .pagination {
            justify-content: center;
            margin: 0;
        }
        .w-100 nav {
            box-shadow:none
        }
    </style>
    @endif
    @if (Request::is('transaksi'))
    <style>
        .table td, .table th {
            border-top: 0;
            border-bottom: 1px solid #dee2e6;
        }
        .pagination {
            justify-content: center;
            margin: 0;
        }
        .w-100 nav {
            box-shadow:none
        }
    </style>
    @endif
</head>
<body class="d-flex flex-column w-100 h-100 position-absolute">
        <nav class="navbar navbar-expand-md navbar-light bg-white">
            <div class="container-fluid mx-5">
                <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Daftar') }}</a>
                                </li>
                            @endif
                        @else

                            @if (request()->user()->hasRole('member'))
                                <li class="nav-item">
                                    <a href="/keranjang" class="nav-link"><span class="fa fa-shopping-cart"></span> 
                                    <span class="badge">@php
                                            $orders = DB::table('orders')
                                                    ->where('user_id', Auth::user()->id)
                                                    ->where('status', '0')->first();
                                            if ($orders) {
                                                echo DB::table('order_details')->where('order_id', $orders->id)
                                                    ->count();
                                            }
                                        @endphp</span>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu p-0" aria-labelledby="navbarDropdown">
                                    @if (request()->user()->hasRole('member'))
                                    <a class="dropdown-item px-3 py-2" href="/akun">Akun</a>
                                    <a class="dropdown-item px-3 py-2" href="/keranjang">Keranjang</a>
                                    <a class="dropdown-item px-3 py-2" href="/transaksi">Transaksi</a>
                                    @else
                                    <a class="dropdown-item px-3 py-2" href="/admin">Admin</a>
                                    @endif
                                    <a class="dropdown-item px-3 py-2" href="{{ route('logout') }}"
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
        <main class="container-fluid w-100 mx-auto mb-2 mt-4">
            @yield('content')
        </main>
        <footer class="mt-auto bg-white text-center p-2">Copyright © <span id="year"></span> {{ config('app.name', 'Laravel') }}</footer>
</body>
</html>
