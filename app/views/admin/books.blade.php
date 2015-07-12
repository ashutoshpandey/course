<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Administration | Books</title>
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
        <h1>
            Manage Books
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
            </ul>
            <div id='tab-list'>
                <div id='book-list'></div>
            </div>
            <div id='tab-create'>
                <div id='form-container'>
                    <form id='form-create-book'>
                        <div class='form-row'>
                            <div class='form-label'>Name</div>
                            <div class='form-data'>
                                <input type='text' name='name'/>
                            </div>
                            <div class='form-label'>Publish Date</div>
                            <div class='form-data'>
                                <input type='text' name='publish_date'/>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>Subject</div>
                            <div class='form-data'>
                                <input type='text' name='subject'/>
                            </div>
                            <div class='form-label'>Author</div>
                            <div class='form-data'>
                                <input type='text' name='author'/>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>Price</div>
                            <div class='form-data'>
                                <input type='text' name='price'/>
                            </div>
                            <div class='form-label'>Discounted Price</div>
                            <div class='form-data'>
                                <input type='text' name='discounted_price'/>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>Book type</div>
                            <div class='form-data'>
                                <select name='book_type'>
                                    <option>Course</option>
                                    <option>Supplementary</option>
                                </select>
                            </div>
                            <div class='clear'></div>
                        </div>
                        <div class='form-row'>
                            <div class='form-label'>&nbsp;</div>
                            <div class='form-data'>
                                <input type='button' name='btn-create' value="Create Book" class='half'/> <span class='message'></span>
                            </div>
                            <div class='clear'></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section><!-- /.content -->

</div><!-- /.content-wrapper -->

</div><!-- ./wrapper -->
@include('includes/common_js_bottom')
{{HTML::script(asset("/public/js/site/admin/books.js"))}}
</body>
</html>
