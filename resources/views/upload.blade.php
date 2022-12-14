<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Jinter App</title>
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
@if(Auth::check() && Auth::user()->role==1)
<div id="top-nav-bar" catalog="2" role="1" login="1">
    <top-nav-bar ></top-nav-bar>
</div>
@else (Auth::check() && Auth::user()->role==2)
<div id="top-nav-bar" catalog="2" role="2">
    <top-nav-bar ></top-nav-bar>
</div>
@endif
<div id="upload">
    <upload></upload>
</div>

@vite('resources/js/app.js')
</body>
</html>