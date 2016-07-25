<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Coboo | Listing institutes</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.common_css')

    {{HTML::style(asset("/public/css/site/institutes.css"))}}

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
                                <input type="hidden" id="search-city" name="c"/>
                            </div>
                        </form>

                    </div>
                </div>
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

                            <p class="established">Established: {{date('d-M-Y', strtotime($institute->establish_date))}}</p>
                            <p class="address">{{$institute->address}}</p>
                        </div>
                        <div class="related-links col-4">
                            <a href="{{$root}}/courses/{{$institute->id}}" class="view-course">View courses</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                    @if($status=="search")
                        No institutes found
                    @endif
                @endif
            </div>
            <div class="col-1 sm-hide">&nbsp;</div>
            <div class="col-3 trending">
                <h2>TREANDING</h2>
                <div class="row institutes">
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

    </section>

    @include('includes.footer')
    {{HTML::script(asset("/public/js/site/institutes.js"))}}
    {{HTML::script(asset("/public/js/site/search.js"))}}

</body>
</html>
