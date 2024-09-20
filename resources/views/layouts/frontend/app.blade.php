<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="locale" content="{{ app()->getLocale() }}" />
    <meta name="viewport" content="width=1920, user-scalable=0" />
    {{-- <meta name="viewport" content="width=1920, initial-scale=0.5, maximum-scale=1"> --}}
    <meta name="csrf-token" value="{{ csrf_token() }}" />
    <title>GOSU</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ mix('/images/logo/GOSU_icon.png') }}">

    <style>
        body::-webkit-scrollbar {
            width: 1px;
            height: 1px;
        }

        body::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            background-color: #60A8AC;
            border-radius: 10px;
        }

        body::-webkit-scrollbar-thumb {
            background: #60A8AC;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div id="app">
    </div>
    <script src="{{ mix('js/frontend/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backend/js/ckfinder/ckfinder.js') }}"></script>
</body>

</html>
