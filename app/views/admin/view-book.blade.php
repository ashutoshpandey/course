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

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Book: {{$book->name}}
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class='tab-container'>
                <div id='tab-create'>
                    <div id='form-container'>

                            <form target="ifr" id='form-update-book' enctype="multipart/form-data" method="post" action="{{$root}}/update-book" onsubmit="return updateBook()">
                            <div class='form-row'>
                                <div class='form-label'>Name</div>
                                <div class='form-data'>
                                    <input type='text' name='name' value='{{$book->name}}'/>
                                </div>
                                <div class='form-label'>Publication</div>
                                <div class='form-data'>
                                    <input type='text' name='publication' value='{{$book->publication}}'/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Subject</div>
                                <div class='form-data'>
                                    <input type='text' name='subject' value='{{$book->subject}}'/>
                                </div>
                                <div class='form-label'>Author</div>
                                <div class='form-data'>
                                    <input type='text' name='author' value='{{$book->author}}'/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Price</div>
                                <div class='form-data'>
                                    <input type='text' name='price' value='{{$book->price}}'/>
                                </div>
                                <div class='form-label'>Discounted Price</div>
                                <div class='form-data'>
                                    <input type='text' name='discounted_price' value='{{$book->discounted_price}}'/>
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
                                    <script type="text/javascript">
                                        $("select[name='book_type']").val("{{$book->book_type}}");
                                    </script>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Picture 1</div>
                                <div class='form-data'>
                                    <input type='file' name='picture_1'/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>Picture 2</div>
                                <div class='form-data'>
                                    <input type='file' name='picture_2'/>
                                </div>
                                <div class='clear'></div>
                            </div>
                            <div class='form-row'>
                                <div class='form-label'>&nbsp;</div>
                                <div class='form-data'>
                                    <input type='submit' name='btn-update' value="Update Book" class='half'/> <span class='message'></span>
                                </div>
                                <div class='clear'></div>
                            </div>
                        </form>
                        <iframe name="ifr" id="ifr" style="visibility: hidden; height: 1px; width: 1px"></iframe>
                    </div>
                </div>
            </div>

        </section><!-- /.content -->

    </div><!-- /.content-wrapper -->

</div><!-- ./wrapper -->

@include('includes/common_js_bottom')
{{HTML::script(asset("/public/js/site/admin/view-product.js"))}}
</body>
</html>
