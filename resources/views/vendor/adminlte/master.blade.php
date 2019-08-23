<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 2'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/Ionicons/css/ionicons.min.css') }}">
    {{--easyautocomplete--}}
    <link rel="stylesheet" href="{{ asset('custom/easyautocomplete/css/easy-autocomplete.min.css') }}">

    {{-- Date picker    --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">

    {{-- icheck --}}
    {{--    <link rel="stylesheet" href="{{ asset('custom/icheck/css/all.css') }}">--}}
    @if(config('adminlte.plugins.select2'))
    <!-- Select2 -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css">
    @endif

<!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}">
    <style>
        .redErrorInput{
            background-color:red;
        }
    </style>
    @if(config('adminlte.plugins.datatables'))
    <!-- DataTables with bootstrap 3 style -->
        <link rel="stylesheet" href="//cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.css">
        <style>
            .help-block {
                color: red;
            }

        </style>
        @endif

    @yield('adminlte_css')

    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>

        <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>

        <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>

        <script src="{{ asset('js/numeric.js') }}"></script>

        {{--easyautocomplete--}}
        <script src="{{ asset('custom/easyautocomplete/js/jquery.easy-autocomplete.min.js') }}"></script>

    {{--icheck--}}
    {{--<script src="{{ asset('custom/icheck/js/icheck.min.js') }}"></script>--}}
    <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition @yield('body_class')">

@yield('body')


@if(config('adminlte.plugins.select2'))
    <!-- Select2 -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
@endif

@if(config('adminlte.plugins.datatables'))
    <!-- DataTables with bootstrap 3 renderer -->
    <script src="//cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.js"></script>
@endif

@if(config('adminlte.plugins.chartjs'))
    <!-- ChartJS -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
@endif

@yield('adminlte_js')

<script>
    //Date picker
    $('#datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    })
    $('#datepicker1').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    })
    $(function () {
         //Initialize Select2 Elements
        $('.select2').select2()


    })
    // //iCheck for checkbox and radio inputs
    // $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
    //     checkboxClass: 'icheckbox_minimal-blue',
    //     radioClass   : 'iradio_minimal-blue'
    // })
    // //Red color scheme for iCheck
    // $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
    //     checkboxClass: 'icheckbox_minimal-red',
    //     radioClass   : 'iradio_minimal-red'
    // })
    // //Flat red color scheme for iCheck
    // $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
    //     checkboxClass: 'icheckbox_flat-green',
    //     radioClass   : 'iradio_flat-green'
    // })
    $('.collapse').collapse();


</script>
</body>
</html>
