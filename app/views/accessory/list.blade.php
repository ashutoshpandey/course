<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Coboo | Listing Accessories</title>
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


        @include('includes.header')

    <section class='content'>

        <div class="container">
            <h3>Showing {{$course->institute->name}} accessory for  :  {{$course->name}}</h3>
            <br/><br/>
            @if($found)

                <div class="grid-info row">

                    <div class="col-md-12 book-list" rel="{{$course->id}}">

                        {{--<span class="select-all">Select all books</span> <span class="add-all-to-bag hidden">Add All Books to Bag</span><br/>--}}


                        <ul id="content">
                            @foreach($accessories as $accessory)

                                <li class="data">
                                    <div class="name-date">
                                        <div class="row product-list">
                                            <div class="col-md-6">
                                                {{--<span><input type="checkbox" name="check-item" value="{{$book->id}}"/></span>--}}

                                                <span class="name">{{$accessory->name}}</span>
                                                <br/>
                                                <i class="fa fa-inr"></i> <span class="price">{{$accessory->price}}</span>
                                                <br/>
                                                {{--<label><input type="checkbox" name="pick-book" value="{{$book->id}}"/> Pick this book </label>--}}

                                                    <span class="add-to-bag" rel="{{$accessory->id}}">Add to bag</span>
                                            </div>
                                            <div class="col-md-6">
                                                <?php $image_path=$root."/public/uploads/accessory/".$course->id."/".$accessory->picture_1?>
                                                <span class=""><img class="img-thumbnail"
                                                                    style="height: 100px;width: 150px"
                                                                    src="<?php echo (!empty($accessory->picture_1))? $image_path:$root.'/public/uploads/book-images/no_image.jpg'?>"></span>
                                            </div>
                                        </div>

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
                <h2>No accessory found</h2>
            @endif

        </div>

    </section>

</div>
<!-- ./wrapper -->

@include('includes.footer')
{{HTML::script(asset("/public/js/site/accessory.js"))}}
</body>
</html>
