<?php include_once('includes/crud.php');
$db = new Database();
$db->connect();
$db->sql("SET NAMES 'utf8'");
date_default_timezone_set('Asia/Kolkata');
include('includes/variables.php');
include_once('includes/custom-functions.php');
include_once('includes/functions.php');
$fn = new custom_functions;

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="icon" type="image/ico" href="dist/img/smart.jpeg">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/custom.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">


    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link href="dist/css/multiple-select.css" rel="stylesheet" />
    <!--<link rel="stylesheet" href="plugins/select2/select2.min.css">-->
    <!--	 <link rel="stylesheet" href="plugins/select2/select2.min.css">=
        <link rel="stylesheet" href="plugins/select2/select2.css">-->
    <!-- AdminLTE Skins. Choose a skin from the css/skins
            folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/print.css" type="text/css" media="print">
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
    <!-- Morris chart 
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" integrity="sha256-2kJr1Z0C1y5z0jnhr/mCu46J3R6Uud+qCQHA39i1eYo=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js" integrity="sha256-CgrKEb54KXipsoTitWV+7z/CVYrQ0ZagFB3JOvq2yjo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            var date = new Date();
            var currentMonth = date.getMonth() - 10;
            var currentDate = date.getDate();
            var currentYear = date.getFullYear() - 10;

            $('.datepicker').datepicker({
                minDate: new Date(currentYear, currentMonth, currentDate),
                dateFormat: 'yy-mm-dd',
            });
        });
    </script>
    <script language="javascript">
        function printpage() {
            window.print();
        }
    </script>
    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.1/bootstrap-table.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.1/extensions/filter-control/bootstrap-table-filter-control.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.4.1/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.4.1/jquery.fancybox.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css" integrity="sha256-tBxlolRHP9uMsEFKVk+hk//ekOlXOixLKvye5W2WR5c=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js" integrity="sha256-CtKylYan+AJuoH8jrMht1+1PMhMqrKnB8K5g012WN5I=" crossorigin="anonymous"></script>

      <!--styling input -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="reports.php" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">
                     <img src="dist/img/smart.jpeg" height="25px" width="25px" style="border-radius:15px;" alt="">
                </span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">
                    <h3>QR Card</h3>
                </span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="images/avatar.png" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?php echo $_SESSION['username'] ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="images/avatar.png" class="img-circle" alt="User Image">
                                        <p>
                                        <?php echo 'Refer Code - ' . $_SESSION['refer_code'] ?>
                                            <small><?php echo $_SESSION['email'] ?></small>
                                        </p>
                                    </li>
                                    <li class="user-footer">
                                        <!-- <div class="pull-left">
                                            <a href="admin-profile.php" class="btn btn-default btn-flat"> Edit Profile</a>
                                        </div> -->
                                        <div class="pull-right">
                                            <a href="logout.php" class="btn btn-default btn-flat">Log out</a>
                                        </div>
                                    </li>
                                    <!-- Menu Body -->
                                    <!-- Menu Footer-->
                                </ul>
                            </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
               
            <ul class="sidebar-menu">
                <li class="treeview">
                    <a href="reports.php">
                        <i class="fa fa-home" class="active"></i> <span>Home</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="users.php">
                    <i class="fa fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
             
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-money"></i>
                        <span>withdrawals</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="withdrawals.php"><i class="fa fa-money"></i>withdrawals</a></li>
                      
                    </ul>
                </li>
              <?php
                if($_SESSION['role'] == 'Super Admin'){?>
                <li class="treeview">
                    <a href="transactions.php">
                    <i class="fa fa-arrow-right"></i>
                       <span>Transactions</span>
                    </a>
                </li>
 
                 <li class="treeview">
                    <a href="#">
                        <i class="fa fa-calendar"></i>
                        <span>Plans</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="plan.php"><i class="fa fa-calendar"></i>Plan</a></li>
                        <li><a href="user_plan.php"><i class="fa fa-user"></i>User Plan</a></li>
                   </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-calendar"></i>
                        <span>Outsource Plans</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="outsource_plan.php"><i class="fa fa-calendar"></i>Outsource Plan</a></li>
                        <li><a href="outsource_user_plan.php"><i class="fa fa-user"></i>Outsource User Plan</a></li>
                   </ul>
                </li>

                <li class="treeview">
                    <a href="bank_details.php">
                    <i class="fa fa-bank"></i>
                        <span>Bank Details</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="notifications.php">
                    <i class="fa fa-bell"></i>
                       <span>Notifications</span>
                    </a>
                </li>
                  
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-gear"></i>
                        <span>Settings</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="settings.php"><i class="fa fa-gear"></i>Settings</a></li>
                        <li><a href="reward_settings.php"><i class="fa fa-gear"></i>Reward Settings</a></li>
                        <li><a href="code_settings.php"><i class="fa fa-gear"></i>Code Settings</a></li>
                        <li><a href="champion_settings.php"><i class="fa fa-trophy"></i>Champion Settings</a></li>
                        <li><a href="info_settings.php"><i class="fa fa-info"></i>Info Settings</a></li>

                    </ul>
                </li>

                <li class="treeview">
                    <a href="app-update.php">
                        <i class="fa fa-bullseye"></i>
                        <span>App Update</span>
                    </a>
                </li>

                <li class="treeview">
                    <a href="manage-devices.php">
                    <i class="fa fa-laptop"></i>
                       <span> Manage Devices</span>
                    </a>
                </li>
                
                  <li class="treeview">
                    <a href="faq.php">
                    <i class="fa fa-question"></i>
                       <span>Faq</span>
                    </a>
                </li>
                  <li class="treeview">
                    <a href="youtube_links.php">
                    <i class="fa fa-youtube"></i>
                       <span>Youtube Links</span>
                    </a>
                </li>
                <?php

                 }
                   ?>
                  <li class="treeview">
                    <a href="payments.php">
                    <i class="fa fa-money"></i>
                        <span>Payments</span>
                    </a>
                </li>
                <?php
                if($_SESSION['role'] == 'Super Admin'){?>
                <li class="treeview">
                    <a href="leaves.php">
                    <i class="fa fa-money"></i>
                        <span>Leaves</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="bulk_upload.php">
                    <i class="fa fa-file"></i>
                        <span>Bulk Upload</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="bulk_amount.php">
                    <i class="fa fa-file"></i>
                        <span>Bulk Amount</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="bulk_refund.php">
                    <i class="fa fa-file"></i>
                        <span>Bulk Refund</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="referrals.php">
                    <i class="fa fa-users"></i>
                        <span>Referrals</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="payment_screenshot.php">
                    <i class="fa fa-image"></i>
                        <span>Payment Screenshot</span>
                    </a>
                </li>

                <?php

}
?>
               
            </ul>
            </section>
            <!-- /.sidebar -->
        </aside>
</body>

</html>