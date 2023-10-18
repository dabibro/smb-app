<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 11/10/2023
 * Time: 07:26 PM
 */

use App\Controller\AppController;
use App\SMB\Auth;

$App = new AppController();

$Auth = new Auth();
$Auth->CheckAuth();

$auth = $Auth->AuthUser();

?>
<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
<head>
    <?php include 'require/meta.php' ?>
    <title>SMB Solutions Dashboard - Sales Manager</title>
    <?php include 'require/links.php' ?>
</head>
<body>
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
<?php include 'include/side-menu.php' ?>
<?php include 'include/nav.php' ?>
<div class="pcoded-main-container bg-white">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->
                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div style="position:relative; padding: 10%; margin-bottom: 5%" class="text-center hidden"
                         id="content-loader">
                        <div class="loader-container">
                            <div class="loader"></div>
                        </div>
                    </div>
                    <div class="">
                        <div id="AjaxResponses"></div>
                        <div id="main-content" class="">
                            <?php
                            if (file_exists($content)) {
                                require_once $content;
                            } else {
                                require VIEWS . 'shared/404.html';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'include/footer.php' ?>
<?php include 'include/modals.html' ?>
<?php include 'require/scripts.php' ?>
</body>
</html>
