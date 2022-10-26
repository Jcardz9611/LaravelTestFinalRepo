<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Jinter App</title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
@if(Auth::check() && Auth::user()->role==1)
<div id="top-nav-bar" catalog="1" login="1" role="1">
    <top-nav-bar></top-nav-bar>
</div>
@elseif (Auth::check() && Auth::user()->role==2)
<div id="top-nav-bar" catalog="1" login="1" role="2">
    <top-nav-bar></top-nav-bar>
</div>
@else
<div id="top-nav-bar" catalog="1" login="0">
    <top-nav-bar></top-nav-bar>
</div>
@endif

@if(Auth::check() )
<div id="app" catalog="1" login="1">
    <front-page></front-page>
</div>
@else
<div id="app" catalog="1" login="0">
    <front-page></front-page>
</div>
@endif
<footer class="footer py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; JinterApp {{ date('Y') }}</p>
    </div>
</footer>

@vite('resources/js/app.js')
</body>
</html>