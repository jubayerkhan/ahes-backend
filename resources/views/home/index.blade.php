<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Home | AHES</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet"
        integrity="" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link href="home/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="">
    <div class="wrapper">
        <!--header-->
        @include('component.header')
        <!--header end-->
        <!--banner-->
        @include('component.banner')
        <!--banner end-->
        <!--know us-->
        @include('component.know')
        <!--know us end-->
        <!--service-->
        @include('component.service')
        <!--service end-->
        <!-- why section -->
        @include('component.why')
        <!-- why section end -->
        <!-- study australia section -->
        @include('component.study-australia')
        <!-- study australia section end -->
        <!-- testimonial section -->
        @include('component.testimonial')
        <!-- testimonial section end -->
        <!-- subscription section -->
        @include('component.subscription')
        <!-- subscription section end -->
        <!-- footer -->
        <!-- @include('component.footer') -->
        <!-- footer end -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="home/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="home/js/chosen.jquery.js"></script>
    <script type="text/javascript" src="home/js/grids.js"></script>
    <script type="text/javascript" src="home/js/custom.js"></script>

</body>

</html>