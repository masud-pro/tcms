
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="title" content="{{ env("META_TITLE","Code Ecstasy Course Management System") }}">
    <meta name="description" content="{{ env("META_DESCRIPTION","Course Management System") }} is a Course Management System built by Code Ecstasy where you one can handle payments attendance course exams etc. Grab your copy now!">
    <meta name="author" content="https://codecstasy.com">
    <link rel="shortcut icon" href="{{ asset("images/favicon/favicon.png") }}" type="image/x-icon">
    <title>
        @yield("title") - {{ env("APP_NAME") }}
    </title>
    @stack("styles-before")
    
    <!-- Custom fonts for this template -->
    <link href="{{ asset("assets") }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset("assets") }}/css/select2.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom styles for this template-->
    <link href="{{ asset("assets") }}/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("css/style.css") }}">
    @stack("styles")
</head>

<body class="bg-gradient-primary">

    @livewire("register.subscriber-register")

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset("assets") }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset("js/ce-sidebar.js") }}"></script>
    <script src="{{ asset("assets") }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset("assets") }}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset("assets") }}/js/sb-admin-2.min.js"></script>
    <script src="{{ asset("assets") }}/js/select2.js"></script>

    <script>
        var $disabledResults = $(".js-example-disabled-results");
            $disabledResults.select2();
    </script>
    
    @stack("scripts")


</body>

</html>
