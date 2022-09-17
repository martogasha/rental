<!DOCTYPE html>
<html lang="en" class="h-100">


<!-- Mirrored from makaanlelo.com/tf_products_007/omah/laravel/demo/page-login by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 26 Aug 2022 15:22:53 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Rental | Page Login</title>
    <meta name="description" content="Some description for the page"/>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="public/images/favicon.png">
    <link href="public/css/style.css" rel="stylesheet">

</head>

<body class="h-100">
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="auth-form">
                                <div class="text-center mb-3">
                                    <a href="index.html"><img  src="public/images/logo-full.png" alt=""></a>
                                </div>
                                <h4 class="text-center mb-4">Sign in your account</h4>
                                @include('flash-message')
                                <form action="{{url('log')}}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label class="mb-1"><strong>Email</strong></label>
                                        <input type="email" class="form-control" name="email" placeholder="hello@example.com">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1"><strong>Password</strong></label>
                                        <input type="password" class="form-control" name="password" placeholder="Password">
                                    </div>
                                    <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox ml-1">
                                                <input type="checkbox" class="custom-control-input" id="basic_checkbox_1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="public/vendor/global/global.min.js" type="text/javascript"></script>
<script src="public/vendor/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="public/js/custom.min.js" type="text/javascript"></script>
<script src="public/js/deznav-init.js" type="text/javascript"></script>

<script id="DZScript" src="https://dzassets.s3.amazonaws.com/w3-global.js?btn_dir=right"></script>


<!--		<script src="https://makaanlelo.com/tf_products_007/omah/laravel/demo/js/custom.min.js" type="text/javascript"></script>
        <script src="https://makaanlelo.com/tf_products_007/omah/laravel/demo/js/deznav-init.js" type="text/javascript"></script> -->
<!--
 	--></body>


<!-- Mirrored from makaanlelo.com/tf_products_007/omah/laravel/demo/page-login by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 26 Aug 2022 15:22:56 GMT -->
</html>
