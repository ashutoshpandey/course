<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Coboo | One stop destination for your course books</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.common_css')

    @include('includes.common_js_top')
</head>
<body>

    @include('includes.header')

    <section>
        @include('includes.search')
    </section>

    <section>
        @include('includes.footer')
    </section>
    {{HTML::script(asset("/public/js/site/search.js"))}}

</body>
</html>
