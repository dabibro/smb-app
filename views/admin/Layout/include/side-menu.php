<nav class="pcoded-navbar navbar-collapsed">
    <div class="navbar-wrapper">
        <div class="navbar-brand header-logo">
            <a href="<?php echo DASHBOARD; ?>" class="b-brand">
                <div class="b-bg">
                    <i class="feather icon-package"></i>
                </div>
                <span class="b-title">SMB Solution</span>
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="javascript:"><span></span></a>
        </div>
        <div class="navbar-content scroll-div">
            <ul class="nav pcoded-inner-navbar">
                <li class="nav-item pcoded-menu-caption">
                    <label>Navigation</label>
                </li>
                <li class="nav-item active">
                    <a href="<?php echo DASHBOARD; ?>" class="nav-link "><span class="pcoded-micon"><i
                                    class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                </li>
                <?php echo $App->Menus(); ?>
            </ul>
        </div>
    </div>
</nav>