<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Log in | WiFinCloud</title>
        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="<?php echo $assets ?>css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $assets ?>css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $assets ?>css/core.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $assets ?>css/components.css" rel="stylesheet" type="text/css">
        <link href="<?php echo $assets ?>css/colors.css" rel="stylesheet" type="text/css">
        <!-- /global stylesheets -->
        <!-- Core JS files -->
        <script type="text/javascript" src="<?php echo $assets ?>js/plugins/loaders/pace.min.js"></script>
        <script type="text/javascript" src="<?php echo $assets ?>js/core/libraries/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $assets ?>js/core/libraries/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo $assets ?>js/plugins/loaders/blockui.min.js"></script>
        <!-- /core JS files -->
        <!-- Theme JS files -->
        <script type="text/javascript" src="<?php echo $assets ?>js/plugins/forms/styling/uniform.min.js"></script>
        <script type="text/javascript" src="<?php echo $assets ?>js/core/app.js"></script>
        <script type="text/javascript" src="<?php echo $assets ?>js/pages/login.js"></script>
        <!-- /theme JS files -->
    </head>

    <body class="login-container hold-transition <?php echo !isset($body_classes)?'login-page':$body_classes ?>">
        <!-- Page container -->
        <div class="page-container">
            <!-- Page content -->
            <div class="page-content">
                <!-- Main content -->
                <div class="content-wrapper">
                    <!-- Content area -->
                    <div class="content">