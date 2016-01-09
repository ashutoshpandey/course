<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Coboo | Listing Books</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.common_css')

    {{HTML::style(asset("/public/css/site/grid-list.css"))}}
    {{HTML::style(asset("/public/css/site/books.css"))}}

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"/>

    @include('includes.common_js_top')
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        @include('includes.header')
    </header>

    <section class='content'>

        <div class="container">

            <h3>Showing courses for: {{$course->name}}</h3>
            <br/><br/>

            @if($found)

            <div class="grid-info row">
                <div class="col-md-2">
                    <div class="subject-list">
                        @if(isset($subjects))

                            @foreach($subjects as $subject)

                                <div><label><input type="checkbox" name="subject" value="{{$subject['subject']}}"/> {{$subject['subject']}}</label></div>

                            @endforeach

                        @endif
                    </div>
                </div>

                <div class="col-md-10 book-list" rel="{{$course->id}}">

                    <span class="select-all">Select all books</span> <br/>

                    <ul id="content">

                        @foreach($books as $book)

                        <li class="data">
                            <div class="name-date">
                                <span class="name">{{$book->name}}</span>
                                <br/>
                                <i class="fa fa-inr"></i> <span class="price">{{$book->price}}</span>
                                <br/>
                                By <span class="author">{{$book->author}}</span> <br/><br/>
<!--                                <label><input type="checkbox" name="pick-book" value="{{$book->id}}"/> Pick this book </label>-->
                                @if($book->added=='y')
                                    <span class="added-to-bag" rel="{{$book->id}}">In bag</span>
                                @else
                                    <span class="add-to-bag" rel="{{$book->id}}">Add to bag</span>
                                @endif
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
{{HTML::script(asset("/public/js/site/books.js"))}}

</body>
</html>
