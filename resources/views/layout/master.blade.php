<!DOCTYPE html>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel CRUD Operations - Sampel</title>


    <link rel="stylesheet" href={{ asset('plugins/admin-lte/css/adminlte.min.css') }}>
    <link rel="stylesheet" href={{ asset('plugins/jquery-ui/jquery-ui.min.css') }}>
    <link rel="stylesheet" href={{ asset('plugins/datatables/media/css/jquery.dataTables.min.css') }}>
    <link rel="stylesheet" href={{ asset('plugins/fontawesome/css/all.min.css') }}>
    <link rel="stylesheet" href={{ asset('plugins/sweetalert2/sweetalert2.min.css') }}>

    <style>
        .table>tbody>tr>td {
            vertical-align: middle;
            
        }

    </style>
</head>

<body>
    <div class="">
        <div class="">


            @yield('content')



        </div>
    </div>
    <script src='{{ asset('plugins/jquery/jquery.min.js') }}'></script>
    <script src='{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}'></script>
    <script src='{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}'></script>
    <script src='{{ asset('plugins/admin-lte/js/adminlte.min.js') }}'></script>
    <script src='{{ asset('plugins/datatables/media/js/jquery.dataTables.min.js') }}'></script>


    @yield('javascript')


</body>

</html>
