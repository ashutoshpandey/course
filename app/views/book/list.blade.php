<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Coboo | Listing Books</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.common_css')

    {{HTML::style(asset("/public/css/site/home.css"))}}
    {{HTML::style(asset("/public/css/site/institutes.css"))}}
    {{HTML::style(asset("/public/css/site/grid-list.css"))}}

    @include('includes.common_js_top')
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        @include('includes.header')
    </header>

    <section class='content'>

        <div class="container book-list">

            @if(isset($books))

            <div class="grid-info row">
                <div class="col-md-12">
                    <div class="top-menu">
                        <ul>
                            <li id="grid">{{ HTML::image('public/images/grid.png', 'grid-icon') }}</li>
                            <li id="list">{{ HTML::image('public/images/list.png', 'list-icon') }}</li>
                        </ul>
                    </div>
                    <div style="clear:both"></div>
                    <ul id="content">

                        @foreach($books as $book)

                        <li class="data">
                            <div class="name-date">
                                <span class="name">{{$book->name}}</span></span>
                            </div>
                        </li>

                        @endforeach

                    </ul>

                    {{--<div id="popup_div">--}}
                        {{--Test the dialog--}}
                        {{--<br/>--}}
                        {{--<button id="btnClose">Close</button>--}}
                    {{--</div>--}}

                    <div id='page_navigation'></div>
                    <input type='hidden' id='current_page'/>
                    <input type='hidden' id='show_per_page'/>
                </div>
            </div>

            @else
                <h2>No books found</h2>
            @endif

        </div>

    </section>

</div>
<!-- ./wrapper -->

@include('includes.footer')
{{HTML::script(asset("/public/js/site/institutes.js"))}}
{{HTML::script(asset("/public/js/site/search.js"))}}

<script type="text/javascript">
    $("#search_button").click(showGrid);
</script>

</body>
</html>
