<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Selam</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    </head>
    <body>
    <div id="app">
        <fixture-component>
        </fixture-component>
    </div> <!-- /container -->
    <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
