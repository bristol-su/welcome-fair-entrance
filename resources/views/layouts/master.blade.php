<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Welcome Fair') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links {
            margin-bottom: 25px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
{{--<div class="flex-center position-ref full-height">--}}


<div id="app">


    <main class="py-4">

        <div class="content" id="content">
            @auth
            <div class="title m-b-md">
                Welcome Fair 2019
            </div>

            <div class="links">
                <a href="{{url('/dashboard')}}">Dashboard</a>
                <a href="{{url('/scan')}}">All Scans</a>
                <a href="{{url('/scan/create')}}">Scanning</a>
                <a href="{{url('/lookup')}}">Manual Entry</a>
                <a href="{{url('/demographics')}}">Demographics</a>
            </div>
            <hr/>
            @endauth
            @yield('content')
        </div>
    </main>
</div>

</body>
@include('templates.javascript')
<script type="text/javascript" src="{{asset('/js/dashboard.js')}}"></script>
</html>
