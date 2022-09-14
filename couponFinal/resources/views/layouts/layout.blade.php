<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="//unpkg.com/alpinejs" defer></script>
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css"> --}}
</head>
<body>

    @if (session('success'))
<div x-data ="{show: true}" x-init="setTimeout(() =>show = false, 3000 )" x-show="show" class="alert alert-success">
    {{ session('success') }}
</div>
@elseif(session('fail'))
<div x-data ="{show: true}" x-init="setTimeout(() =>show = false,  3000 )" x-show="show" class="alert alert-danger">
  {{ session('fail') }}
</div>
@endif

    @yield('content')

    <script src="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('/dist/js/scripts.js')}}"></script>
 
 {{-- <script src="{{url('js/script.js')}}"></script> --}}
</body>
</html>