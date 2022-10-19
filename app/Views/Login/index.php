<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= base_url('assets/images/menyambang/logo_fix.png') ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?= base_url('assets/images/menyambang/logo_fix.png') ?>" type="image/x-icon">
    <title>Menyambang.id</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/font-awesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/style.css">
    <link id="color" rel="stylesheet" href="<?= base_url('assets'); ?>/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/responsive.css">
    <style>
        .grecaptcha-badge {
            display: block;
            float: left;
        }

        .form-error {
            display: none;
        }
    </style>
</head>

<body>
    <!-- login page start-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6"><img class="bg-img-cover bg-center" src="<?= base_url('assets'); ?>/images/login/2.jpg" alt="looginpage"></div>
            <div class="col-xl-6 p-0">
                <div class="login-card">
                    <div>
                        <div class="row">
                            <a class="logo pull-left" style="text-align: left;" href="index.html">
                                <!-- <img class="img-fluid for-light" src="<?= $logo ?>" alt="looginpage" width="300px"> -->
                            </a>
                        </div>
                        <div class="login-main">
                            <form class="theme-form" id="form">
                                <input type="hidden" name="token_captcha" id="inp-captcha" />
                                <h4>LOGIN</h4>
                                <div class="form-group">
                                    <label class="col-form-label">Username</label>
                                    <input class="form-control" type="text" name="username" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" name="password" placeholder="Password">
                                        <!-- <div class="show-hide"><span class="show"> </span></div> -->
                                    </div>
                                </div>
                                <div class="alert alert-danger errorMessage" style="display: none"></div>
                                <div class="form-group mb-0">
                                    <button class="btn btn-primary btn-block w-100" id="login" type="submit">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- latest jquery-->
        <script src="<?= base_url('assets'); ?>/js/jquery-3.5.1.min.js"></script>
        <!-- Bootstrap js-->
        <script src="<?= base_url('assets'); ?>/js/bootstrap/bootstrap.bundle.min.js"></script>
        <!-- feather icon js-->
        <script src="<?= base_url('assets'); ?>/js/icons/feather-icon/feather.min.js"></script>
        <script src="<?= base_url('assets'); ?>/js/icons/feather-icon/feather-icon.js"></script>
        <!-- scrollbar js-->
        <!-- Sidebar jquery-->
        <script src="<?= base_url('assets'); ?>/js/config.js"></script>
        <!-- Plugins JS start-->
        <!-- Plugins JS Ends-->
        <!-- Theme js-->
        <script src="<?= base_url('assets'); ?>/js/script.js"></script>
        <!-- login js-->
        <!-- Plugin used-->
        <script src="https://www.google.com/recaptcha/api.js?render=6LcsuMIaAAAAAH3_jBw1wl3M15LIJBA0vbU4pBGc"></script>

        <script>
            $('#login').attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Loading...');
            grecaptcha.ready(function() {
                grecaptcha.execute('6LcsuMIaAAAAAH3_jBw1wl3M15LIJBA0vbU4pBGc', {
                    action: 'login'
                }).then(function(token) {
                    document.getElementById("inp-captcha").value = token;
                    $('#login').removeAttr('disabled').html('Login');
                });
            });

            $(document).ready(function() {

                $('#form').submit(function(e) {
                    e.preventDefault();

                    $.ajax({
                        type: "POST",
                        url: "<?= current_url() ?>",
                        data: $("#form").serialize(),
                        dataType: "JSON",
                        success: function(res) {
                            if (res.code == 200) {
                                window.location = res.data.redirect;
                            } else {
                                $('.errorMessage').show().html(res.message);
                                resetCaptcha();
                            }
                        },
                        beforeSend: function() {
                            $('#login').attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Loading...');
                        },
                        fail: function() {
                            Swal.fire('Error', "Server gagal merespon", 'error');
                            resetCaptcha();
                        },
                        complete: function() {
                            $('#login').removeAttr('disabled').html('Login');
                        }
                    });
                });
            });

            function resetCaptcha() {
                grecaptcha.execute('6LcsuMIaAAAAAH3_jBw1wl3M15LIJBA0vbU4pBGc', {
                    action: 'login'
                }).
                then(function(token) {
                    document.getElementById("inp-captcha").value = token;
                });
            }
        </script>
    </div>
</body>

</html>