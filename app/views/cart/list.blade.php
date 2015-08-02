<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Coboo | Listing Courses</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.common_css')

    {{HTML::style(asset("/public/css/site/cart.css"))}}

    @include('includes.common_js_top')
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        @include('includes.header')
    </header>

    <section class='content'>

        <div class="container course-list">

            <h3>Showing your bag</h3>

            @if($found)

            <div class="grid-info row">
                <div class="col-md-8">
                    <ul id="content">

                        @foreach($cart as $cartItem)

                        <li class="data">
                            <div class="name-date">
                                <span class="name">{{$cartItem['name']}}</span></span>
                            </div>
                            <div class="add-map">
                                <span class="discounted-price">{{$cartItem['discounted_price']}}</span> <span class="original-price">{{$cartItem['price']}}</span><br/>	<span class="remove-bag-item" rel="{{$cartItem['id']}}">Remove</span>
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
                <h2>No courses found</h2>
            @endif

        </div>

    </section>

</div>
<!-- ./wrapper -->

@include('includes.footer')
{{HTML::script(asset("/public/js/site/cart.js"))}}

</body>
</html>
