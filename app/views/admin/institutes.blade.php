<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Administration | Institutes</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.admin.common_css')

    {{HTML::style(asset("/public/css/AdminLTE.css"))}}
    {{HTML::style(asset("/public/css/admin-skins/_all-skins.min.css"))}}

    @include('includes.admin.common_js_top')
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

<header class="main-header">
<!-- Logo -->
<a href="index2.html" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>A</b>LT</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Admin</b>LTE</span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
<!-- Sidebar toggle button-->
<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
</a>

<div class="navbar-custom-menu">
<ul class="nav navbar-nav">

<!-- User Account: style can be found in dropdown.less -->
<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <span class="hidden-xs">{{$name}}</span>
    </a>
</li>
</ul>
</div>
</nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    @include('includes.admin.menu')
    <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage Institutes
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class='tab-container'>
            <ul class='tabs'>
                <li><a href='#tab-list'>List</a></li>
                <li><a href='#tab-create'>Create</a></li>
                <li><a href='#tab-edit'>Edit</a></li>
            </ul>
            <div id='tab-list'>
                <div id='institute-list'></div>
            </div>
            <div id='tab-create'>
                <div id='form-container'>
                    <form id='form-create-institute'>
                        <div class='form-row'>
                            <div class='form-label'>Name</div>
                            <div class='form-data'>
                                <input type='text' name='name'/>
                            </div>
                            <div class='form-label'>Establish Date</div>
                            <div class='form-data'>
                                <input type='text' name='establish_date'/>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>Address</div>
                            <div class='form-data'>
                                <textarea name='address'></textarea>
                            </div>
                            <div class='form-label'>City</div>
                            <div class='form-data'>
                                <input type='text' name='city'/>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>State</div>
                            <div class='form-data'>
                                <input type='text' name='state'/>
                            </div>
                            <div class='form-label'>Country</div>
                            <div class='form-data'>
                                <input type='text' name='country'/>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>Zip</div>
                            <div class='form-data'>
                                <input type='text' name='zip'/>
                            </div>
                            <div class='form-label'>Landmark</div>
                            <div class='form-data'>
                                <input type='text' name='land_mark'/>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>Contact number 1</div>
                            <div class='form-data'>
                                <input type='text' name='contact_number_1'/>
                            </div>
                            <div class='form-label'>Contact number 2</div>
                            <div class='form-data'>
                                <input type='text' name='contact_number_2'/>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>Latitude / Longitude</div>
                            <div class='form-data'>
                                <input type='text' name='latitude' class='half'/><input type='text' name='longitude' class='half'/>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>&nbsp;</div>
                            <div class='form-data'>
                                <input type='button' name='btn-create' value="Create Institute" class='half'/> <span class='message'></span>
                            </div>
                            <div class='clear'></div>
                        </div>
                    </form>
                </div>
            </div>
            <div id='tab-edit'>
                <div id='form-container'></div>
            </div>
        </div>

    </section><!-- /.content -->

</div><!-- /.content-wrapper -->

</div><!-- ./wrapper -->

@include('includes/common_js_bottom')
{{HTML::script(asset("/public/js/site/admin/institutes.js"))}}
<script type="text/javascript">
    $(function(){
        $(".institutes").addClass('active');
    });
</script>
</body>
</html>
