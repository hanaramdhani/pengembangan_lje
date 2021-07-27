<!DOCTYPE html>
<html lang="en">

<head>
    <title>Halaman Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="/assetslogin/images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/assetslogin/pluggin/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/assetslogin/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/assetslogin/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/assetslogin/pluggin/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/assetslogin/pluggin/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/assetslogin/pluggin/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/assetslogin/pluggin/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/assetslogin/pluggin/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/assetslogin/css/util.css">
    <link rel="stylesheet" type="text/css" href="/assetslogin/css/main.css">
    <!--===============================================================================================-->
    <link rel="shortcut icon" href="/assets/dist/img/lancar-jaya.png" type="image/x-icon">

    <link rel="stylesheet" href="/assets/plugins/sweetalert2/sweetalert2.min.css">
</head>

<body style="background-color: #666666;">

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form px-5" id="frm-login">
                    <div class="alert" id="msg-login" style="display: none;width: 100%;text-align: center; opacity: 0.6">
                    </div>
                    <div class="text-center mt-5 mb-3">
                        <img src="/assets/dist/img/lancar-jaya.png" alt="" style="width: 170px; height: auto;">
                    </div>
                    <h1 class="login100-form-title font-weight-bold mb-5" style="color: #9C1B00;">
                        LANCAR JAYA EXPRESS
                    </h1>



                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="text" name="val_username" required="required">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Username</span>
                    </div>
                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="password" name="val_password" required="required">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Password</span>
                    </div>

                    <!-- <div class="flex-sb-m w-full p-t-3 p-b-32">
                        <div class="contact100-form-checkbox">
                            <input class="input-checkbox100 form-check-label" id="ckb1" type="checkbox" name="remember-me">
                            <label class="label-checkbox100 form-check-label" for="ckb1" style="color: black;">
                                Ingat Saya
                            </label>
                        </div>

                    </div> -->


                    <div class="container-login100-form-btn mb-2">
                        <button type="submit" class="btn btn-danger btn-lg btn-block font-weight-bold py-3" id="login-btn">
                            LOGIN
                        </button>
                    </div>


                    <div class="text-center mt-5 pt-5">
                        &copy; <?= date('Y') ?> <a href="https://www.solidtechs.com">CV. SolidTech</a>. All Rights Reserved
                    </div>




                </form>

                <div class="login100-more" style="background-image: url('/assetslogin/images/bg-01.svg');">
                </div>

            </div>

        </div>

    </div>





    <!--===============================================================================================-->
    <script src="/assetslogin/pluggin/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="/assetslogin/pluggin/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="/assetslogin/pluggin/bootstrap/js/popper.js"></script>
    <script src="/assetslogin/pluggin/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="/assetslogin/pluggin/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="/assetslogin/pluggin/daterangepicker/moment.min.js"></script>
    <script src="/assetslogin/pluggin/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="/assetslogin/pluggin/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="/assetslogin/js/main.js"></script>

    <script src="/assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- <script>
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script> -->
    <!--===============================================================================================-->
    <script src="/assetslogin/js/main.js"></script>
    <script type="text/javascript">
        $('#frm-login').submit(function(e) {
            e.preventDefault();
            let loginBtn = $('#login-btn');
            loginBtn.prop('disabled', true)
            loginBtn.html('Sedang Proses...')
            $.ajax({
                type: 'POST',
                url: `<?= base_url() ?>/api/login`,
                data: $(this).serialize(),
                dataType: 'json',
                success: function(r) {
                    if (r.status == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil login',
                            html: 'Sedang mengalihkan...',
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                        })
                        location.href = `<?= base_url() ?>`;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: `${r.message}`,
                            showConfirmButton: true,
                        })

                        loginBtn.prop('disabled', false)
                        loginBtn.html('LOGIN')
                    }
                }
            });
        });
    </script>

</body>

</html>