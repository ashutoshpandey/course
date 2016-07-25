<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Administration | Courses</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.admin.common_css')

    {{HTML::style(asset("/public/css/AdminLTE.css"))}}
    {{HTML::style(asset("/public/css/admin-skins/_all-skins.min.css"))}}

    @include('includes.admin.common_js_top')
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

    @include('includes.admin.header')

    @include('includes.admin.menu')

            <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1 style="text-transform: capitalize">
                Send Mails
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class='tab-container'>
                <div id='tab-create'>
                    <div id='form-container'>
                        <form id='form-send-mail'>
                            <div class='form-row'>
                                <div class='form-label'>To</div>
                                <div class='form-data'>
                                    <input type="email" name="to" class="full"/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Subject</div>
                                <div class='form-data'>
                                    <input type="text" name="subject" class="full"/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Message</div>
                                <div class='form-data'>
                                    <textarea name="message"></textarea>
                                </div>
                                <div class='clear'></div>
                            </div>

                            <div class='form-row'>
                                <div class='form-label'>Upload</div>
                                <div class='form-data'>
                                    <input type="file" name="uploadfile">
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>&nbsp;</div>
                                <div class='form-data-full'>
                                    <input type='button' name='btn-create' value="Send Mail" class='half'/> <span
                                            class='message'></span>
                                </div>
                                <div class='clear'></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

</div>

@include('includes/common_js_bottom')
{{HTML::script(asset("/public/js/site/admin/locations.js"))}}


</body>
</html>
