<!DOCTYPE html>
<html lang="en">

<head>
    <title>Halaman Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/assetslogin/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <!-- <link rel="stylesheet" type="text/css" href="/assetslogin/fonts/font-awesome-4.7.0/css/font-awesome.min.css"> -->
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/assetslogin/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/assetslogin/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/assetslogin/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/assetslogin/css/util.css">
    <link rel="stylesheet" type="text/css" href="/assetslogin/css/main.css">
    <!--===============================================================================================-->
    <style>
        body {
            color: black;
            background: #d47677;
        }

        .form-control {
            min-height: 41px;
            background: #fff;
            box-shadow: none !important;
            border-color: #e3e3e3;
        }

        .login-form input[type="checkbox"] {
            position: relative;
            top: 1px;
        }
    </style>
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="/assetslogin/images/amicogambar.svg" alt="IMG">
                </div>

                <form class="login100-form validate-form" id="frm-login">
                    <div class="alert" id="msg-login" style="display: none;width: 100%; font-size: 12px;text-align: center; opacity: 0.6">
                    </div>
                    <span class="login100-form-title">
                        LANCAR JAYA EXPRESS
                    </span>
                    <p style=" font-size: 16px; text-align: center; color: black;">
                        Silakan Login <br> untuk menggunakan sistem
                    </p>

                    <div class="form-group">
                        <input type="text" class="form-control" name="val_username" placeholder="Username" required="required">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="val_password" placeholder="Password" required="required">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
                    </div>
                    <div class="bottom-action clearfix">
                        <label class="float-left form-check-label"><input type="checkbox"> Ingat Saya</label>
                        <a href="#" class="float-right">Lupa Password?</a>
                    </div>

                    <div class="text-center p-t-136">
                        <a class="txt2" href="#">

                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>




    <!--===============================================================================================-->
    <script src="/assetslogin/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="/assetslogin/vendor/bootstrap/js/popper.js"></script>
    <script src="/assetslogin/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="/assetslogin/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="/assetslogin/vendor/tilt/tilt.jquery.min.js"></script>
    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>
    <!--===============================================================================================-->
    <script src="/assetslogin/js/main.js"></script>
    <script type="text/javascript">
        $('#frm-login').submit(function(e){
            e.preventDefault();
            $.ajax({
                type:'POST',
                url:`<?=base_url() ?>/api/login`,
                data:$(this).serialize(),
                dataType:'json',
                success:function(r){
                    // alert(r);
                    $('#msg-login').text(r.message);
                    $('#msg-login').css('display','inline-block');
                    if (r.status==200) {
                        $('#msg-login').removeClass('alert-danger');
                        $('#msg-login').addClass('alert-success');
                        location.href=`<?=base_url() ?>`;
                    }else{
                        $('#msg-login').removeClass('alert-success');
                        $('#msg-login').addClass('alert-danger');
                    }
                }
            });
        });
    </script>
</body>

</html>