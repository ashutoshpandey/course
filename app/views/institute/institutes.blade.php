<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Coboo | Listing institutes</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    {{HTML::style(asset("/public/css/site/fonts.css"))}}
    {{HTML::style(asset("/public/css/site/framework.css"))}}
    {{HTML::style(asset("/public/css/site/style.css"))}}
    {{HTML::style(asset("/public/css/site/institutes.css"))}}
    {{HTML::style(asset("/public/css/jquery-ui.css"))}}

    @include('includes.common_js_top')
</head>
<body>

    @include('includes.header')

    <section class='content'>

        <div class="row ">
            <div class="col-1 sm-hide">
                &nbsp;
            </div>
            <div class="col-7">
                <div class="search-bar listing row">
                    <div class="row">
                        <form id="form" method="post">
                            <div class="col-4">
                                <input type="text" data="cites" name="city" id="city" autocomplete="off" placeholder='Choose a city'/>
                            </div>
                            <div class="col-5">
                                <input type="text" data="institutes" name="keyword" id="keyword" autocomplete="off"
                                       placeholder='Choose an institute'/>
                            </div>
                            <div class="col-3">
                                <button type="submit"><span></span>Search</button>
                            </div>
                        </form>

                    </div>
                </div>

<!--
                <div class="sorts row">
                    <div class="az-sort sort col-3">
                        <div class="selected">
                            <p>SORT AZ</p>
                            <span class="drop-down-arrow"></span>
                        </div>
                        <div class="options">
                            <span class="option">Option1</span>
                            <span class="option">Option2</span>
                            <span class="option">Option3</span>
                        </div>
                    </div>
                    <div class="some-other-sorts sort col-4">
                        <div class="selected">
                            <p>Some other sorts</p>
                            <span class="drop-down-arrow"></span>
                        </div>
                        <div class="options">
                            <span class="option">Option1</span>
                            <span class="option">Option2</span>
                            <span class="option">Option3</span>
                        </div>
                    </div>
                </div>
-->
                <div class="row search-location">{{$city}}</div>

                @if(isset($institutes))
                <div class="institute-lists row">
                    @foreach($institutes as $institute)
                    <div class="institute row">
                        <div class="institute-logo">
                            {{HTML::image("public/images/institute-logo.jpg", "", array("class"=>"img-responsive"))}}
                        </div>
                        <div class="institute-details col-8">
                            <p class="name">{{$institute->name}}</p>

                            <p class="type">INTERMEDIATE</p>

                            <p class="address">{{$institute->address}}</p>
                        </div>
                        <div class="related-links col-4">
                            <button class="view-course">View course</button>
                            <a href="https://facebook.com/sharer?url" class="share">
                                <svg width="50px" height="15.151px">
                                    <use xlink:href="#facebook_colored"></use>
                                </svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                    No institutes found
                @endif
            </div>
            <div class="col-1 sm-hide">&nbsp;</div>
            <div class="col-3 trending">
                <h2>TREANDING</h2>
                <div class="row institutes">
                    <p class="block-title">SCHOOLS</p>

                    <div class="institute row">
                        <div class="institute-logo">
                            {{HTML::image("public/images/institute-logo.jpg", "", array("class"=>"img-responsive"))}}
                        </div>
                        <div class="institute-details row">
                            <p class="name">DELHI PUBLIC SCHOOL </p>
                            <p class="type">INTERMEDIATE</p>
                            <p class="address">STREET NO 2  PITAMPURA DELHI INDIA </p>
                        </div>
                    </div>
                </div>
                <div class="row institutes">
                    <p class="block-title">COURSE</p>
                    <div class="institute row">
                        <div class="institute-logo">
                            {{HTML::image("public/images/course-default.jpg", "", array("class"=>"img-responsive"))}}
                        </div>
                        <div class="institute-details row">
                            <p class="name">SEVENTH STANDARD BOOKS</p>
                            <p class="type">200 OFF ON FULL COURSE</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container institutes-list">

            @if(isset($institutes))

            <div class="grid-info row">
                <div class="col-md-12">
                    {{--<div class="top-menu">--}}
                        {{--<ul>--}}
                            {{--<li id="grid">{{ HTML::image('public/images/grid.png', 'grid-icon') }}</li>--}}
                            {{--<li id="list">{{ HTML::image('public/images/list.png', 'list-icon') }}</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    <div style="clear:both"></div>
                    <ul id="content">

                        @foreach($institutes as $institute)

                        <li class="data">
                            <div class="name-date">
                                <span class="name">{{$institute->name}}</span><span class="date">{{date('d-M-Y', strtotime($institute->establish_date))}}</span>
                            </div>
                            <div class="add-map">
                                <span class="add">{{$institute->address}}, {{$institute->location->city}}, {{$institute->location->state}}<br/>	<a target="_blank" href="{{$root}}/courses/{{$institute->id}}">View Courses</a> </span>
                                <span class="map">{{ HTML::image('public/images/map.jpg', 'map-icon') }}</span>
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

            @endif

        </div>

    </section>

    @include('includes.footer')
    {{HTML::script(asset("/public/js/site/institutes.js"))}}
    {{HTML::script(asset("/public/js/site/search.js"))}}

</body>
</html>
