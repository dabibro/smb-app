<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 11/10/2023
 * Time: 04:39 PM
 */

//use App\SMB\Auth;

//$auth = new Auth();
//$auth->ReturnDashboard();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>SMB Login - Sales Manage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="description"
          content="Business Management Solution for small and medium enterprise to track daily business activities."/>
    <meta name="author" content="SMB Solutions"/>
    <!-- Favicon icon -->
    <link rel="icon" href="<?php echo APP_ASSETS; ?>images/favicon.ico" type="image/x-icon">
    <!-- animation css -->
    <link rel="stylesheet" href="<?php echo APP_ASSETS; ?>plugins/animation/css/animate.min.css">
    <!-- vendor css -->
    <link rel="stylesheet" href="<?php echo APP_ASSETS; ?>css/style.css">
    <style>
        .form-control {
            border-radius: 0;
        }
    </style>
</head>

<body id="login-page">
<div class="auth-wrapper">
    <div class="auth-content">
        <div class="auth-bg">
            <span class="r"></span>
            <span class="r s"></span>
            <span class="r s"></span>
            <span class="r"></span>
        </div>
        <div class="card animated zoomIn">
            <div class="card-body">
                <div class="mb-3 animated bounce text-center">
                    <img src="<?php echo APP_ASSETS; ?>images/logo/smb-logo-round.png" width="98"
                         alt="branding logo">
                </div>
                <form method="post" action="<?php echo ADMIN_LOGIN; ?>" id="login-form" novalidate>
                    <h4 class="mb-4 text-center text-muted">Application Login</h4>
                    <div id="login-response"></div>
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                        <div class="invalid-feedback">* Enter your username</div>
                    </div>
                    <div class="input-group mb-4">
                        <input type="password" name="password" id="inputPassword" class="form-control"
                               placeholder="Password" required>
                        <div class="position-absolute" style="z-index: 999; right: 10px; top: 12px;">
                            <button class="border-0 bg-transparent" type="button"
                                    style="cursor:pointer; outline: none;"
                                    onclick="passwordToggle('inputPassword',this)">
                                <i class="feather icon-eye-off"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">* Enter your password</div>
                    </div>
                    <button class="btn btn-primary btn-block shadow-2 login-button no-radius">Login <i
                                class="feather icon-log-in m-0 ml-2"
                                style="line-height: inherit; position: relative; bottom: -1px"></i>
                    </button>
                </form>
            </div>
            <div class="text-center card-footer py-3" style="font-size: .6rem !important;">
                Copyright &copy; <?php echo date('Y', time()); ?>
                SMARTBIZNESS. All rights reserved.<span class="d-block"></span> Developed & Powered By <a
                        href="https://smb.ng" target="_blank" class="text-bold-800 grey darken-2">SMB Solutions</a>
            </div>
        </div>
    </div>
</div>

<!-- Required Js -->
<script src="<?php echo APP_ASSETS; ?>js/vendor-all.min.js"></script>
<script src="<?php echo APP_ASSETS; ?>plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo APP_ASSETS; ?>js/bootstrap.validator.js"></script>
<script src="<?php echo APP_ASSETS; ?>js/pages/login.js"></script>
</body>
</html>
