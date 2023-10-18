<!-- Favicon icon -->
<link rel="icon" href="<?php echo APP_ASSETS ?>images/favicon.ico" type="image/x-icon">
<!-- fontawesome icon -->
<link rel="stylesheet" href="<?php echo APP_ASSETS ?>fonts/fontawesome/css/fontawesome-all.min.css">
<!-- animation css -->
<link rel="stylesheet" href="<?php echo APP_ASSETS ?>plugins/animation/css/animate.min.css">

<!-- datatable css -->
<?php if (!empty($datatable)): ?>
    <link rel="stylesheet"
          href="<?php echo APP_ASSETS ?>plugins/datatable/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
          href="<?php echo APP_ASSETS ?>plugins/datatable/Buttons-1.5.2/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet"
          href="<?php echo APP_ASSETS ?>plugins/datatable/Responsive-2.2.2/css/responsive.bootstrap4.min.css">
<?php endif; ?>

<!-- vendor css -->
<link rel="stylesheet" href="<?php echo APP_ASSETS ?>css/style.css">

<!-- BEGIN Custom CSS-->
<link rel="stylesheet" type="text/css" href="<?php echo APP_ASSETS ?>css/custom.css">
<!-- END Custom CSS-->