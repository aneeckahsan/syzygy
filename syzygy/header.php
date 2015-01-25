<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SMS Dozes</title>

<!--MY CONSTANTS and COMMON JS FILES-->
<script type="text/javascript" src="js/constants.js"></script>
<script type="text/javascript" src="js/common.js"></script>

<!--Bootstrap-->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/sb-admin.css" rel="stylesheet">
<link href="css/plugins/morris.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="livetable/style.css" />
<script type="text/javascript" src="livetable/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="livetable/script.js"></script>
<!--PICKLIST-->
<!--<script type="text/javascript" src="js/picklist.js"></script>>
<<script src="script/jquery.tools.1.2.6.full.min.js"></script>
<script type="text/javascript" src="/script/jquery.watermarkinput.js"></script>>
<link href="css/style2.css" rel="stylesheet" type="text/css" media="all,handheld" />
<link href="css/jquery-ui-timepicker-addon.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/admin.css" rel="stylesheet" type="text/css" media="all,handheld" />
<link rel="stylesheet" media="screen" type="text/css" href="css/datepicker.css" />
<script src="library/bootbox.min.js"></script>
<link rel="stylesheet" href="development-bundle/themes/cupertino/jquery.ui.all.css">
<script src="js/jquery-1.8.0.js"></script>
<script src="development-bundle/ui/jquery.ui.core.js"></script>	
<script src="development-bundle/ui/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="development-bundle/demos/demos.css">

<script type="text/javascript" src="js/datepicker.js"></script>
<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="js/ajax-validation.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script-->

<!--timepicker------->
<!--script type="text/javascript" src="Lib/timepicker/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="Lib/timepicker/jquery.timepicker.css" /-->

</head>

<body>

<div id="wrapper">
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">SMS Marketing</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>MD. Mohsin</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>MD. Mohsin</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>Md. Mohsin</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Md. Mohsin <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="index.html"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="charts.html"><i class="fa fa-fw fa-bar-chart-o"></i> Charts</a>
                    </li>
                    <li class="max">
                        <a href="javascript:;" data-toggle="collapse" data-target="#dem"><i class="fa fa-fw fa-arrows-v"></i> Administration <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="dem" class="collapse">
                            <li>
                                <a href="http://localhost/syzygy/index.php?FORM=forms/frmContactGroup.php">Contact Group</a>
                            </li>
                            <li>
                                <a href="#">Customer List</a>
                            </li>
                            <li>
                                <a href="http://localhost/syzygy/Template.php">Template</a>
                            </li>
                            <li>
                                <a href="http://localhost/syzygy/index.php?FORM=forms/frmUserManagement.php">User Management</a>
                            </li>

                        </ul>
                    </li>
                    <!-- <li>
                        <a href="tables.html"><i class="fa fa-fw fa-table"></i> Tables</a>
                    </li>
                    <li>
                        <a href="forms.html"><i class="fa fa-fw fa-edit"></i> Forms</a>
                    </li> -->
                    <li class="max">
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-lastfm fa-arrows-v"></i> Account <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="http://localhost/syzygy/index.php?FORM=forms/frmOnlineRecharge.php">Online Recharge</a>
                            </li>
                            <li>
                                <a href="http://localhost/syzygy/index.php?FORM=forms/frmDashboardUser.php">Summary</a>
                            </li>
                        </ul>
                    </li>
                    <li class="max">
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo-4"><i class="fa fa-bicycle"></i> Service <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo-4" class="collapse">
                            <li>
                                <a href="http://localhost/syzygy/index.php?FORM=forms/frmsinglesms.php">Single SMS</a>
                            </li>
                            <li>
                                <a href="http://localhost/syzygy/index.php?FORM=forms/frmbulksms.php">Bulk SMS</a>
                            </li>
                            <li>
                                <a href="http://localhost/syzygy/index.php?FORM=forms/frmCampaignManagement.php">Campaign</a>
                            </li>
                            <li>
                                <a href="http://localhost/syzygy/index.php?FORM=forms/frmViewSchedules.php">View Campaigns</a>
                            </li>
                        </ul>
                    </li>
                    <li class="max">
                        <a href="javascript:;" data-toggle="collapse" data-target="#de"><i class="fa fa-fw fa-arrows-v"></i> Reports <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="de" class="collapse">
                            <li>
                                <a href="http://localhost/syzygy/index.php?FORM=forms/frmviewhistory.php">SMS History</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>