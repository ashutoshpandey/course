<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Coboo | One stop destination for your course books</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.common_css')

    {{HTML::style(asset("/public/css/site/static/home.css"))}}
    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet"/>

    @include('includes.common_js_top')
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        @include('includes.header')
    </header>

    <section class='content'>


    <div class="search-bar-wrapper container">
        <div class="search-bar row">
            <form>
                <div style="position:relative;" class="col-md-3 col-sm-3 col-xs-12 no-space">
                    <div id="loc" class="location left">
                        <span class="palceholder"><i class="fa fa-map-marker" style="font-size:20px; display:inline-block"></i></span>
                        <span><input placeholder="Please type a city" id="city" class="dark" style="outline:none"></span>

                        <div id="reference-pane">
                        </div>
                        <span id="arw1" class="right arrow">{{ HTML::image('public/images/arrow.png', 'loc-icon') }}</span>

                    </div>
                </div>
                <div style="position:relative;" class="col-md-7 col-sm-7 col-xs-12 no-space">
                    <div class="keyword-container" >
                        <div class="search-box">
                            <span class="search-icon"><i class="fa fa-search" style="font-size:20px; display:inline-block"></i></span>
                            <input value="" placeholder="Search for institute" class="discover" id="keyword">
                        </div>
                        <div id="explore-by"></div>
                    </div>
                </div>
                <div style="position:relative;" class="col-md-2 col-sm-2 col-xs-12 no-space left">
                    <div class="search_btn" id="search_button">
                        Search
                    </div>
                </div>
                <input type="hidden" id="search-city"/>
            </form>
        </div>

    </div>




    </section>

</div>
<!-- ./wrapper -->

    @include('includes.footer')
    {{HTML::script(asset("/public/js/site/static/home.js"))}}
</body>
</html>
