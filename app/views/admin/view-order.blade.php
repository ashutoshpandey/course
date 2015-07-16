<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Administration | View Order</title>
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
                Order ID: #{{$order->id}}
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class='tab-container'>
                <div id='tab-create'>
                    <div id='form-container'>
                        <form id='form-update-location'>

                            <div class='col-2'>

                                <h3>Shipping information</h3>

                                <div class='form-row'>
                                    <div class='col-3'>Name</div>
                                    <div class='col-2'>{{$order->shipping_name}}</div>
                                    <div class='clear'></div>
                                </div>

                                <div class='form-row'>
                                    <div class='col-3'>Address</div>
                                    <div class='col-2'>{{$order->shipping_address}}<br/>Landmark: {{$order->shipping_land_mark}}</div>
                                    <div class='clear'></div>
                                </div>

                                <div class='form-row'>
                                    <div class='col-3'>Location</div>
                                    <div class='col-2'>
                                        {{$order->shipping_city}}, {{$order->shipping_state}}<br/>
                                        {{$order->shipping_country}}, {{$order->shipping_zip}}
                                    </div>
                                    <div class='clear'></div>
                                </div>

                                <div class='form-row'>
                                    <div class='col-3'>Contact number</div>
                                    <div class='col-2'>{{$order->shipping_contact_number_1}}<br/>{{$order->shipping_contact_number_2}}</div>
                                    <div class='clear'></div>
                                </div>

                            </div>

                            <div class='col-2'>

                                <h3>Billing information</h3>

                                <div class='form-row'>
                                    <div class='col-3'>Name</div>
                                    <div class='col-2'>{{$order->billing_name}}</div>
                                    <div class='clear'></div>
                                </div>

                                <div class='form-row'>
                                    <div class='col-3'>Address</div>
                                    <div class='col-2'>{{$order->billing_address}}<br/>Landmark: {{$order->billing_land_mark}}</div>
                                    <div class='clear'></div>
                                </div>

                                <div class='form-row'>
                                    <div class='col-3'>Location</div>
                                    <div class='col-2'>
                                        {{$order->billing_city}}, {{$order->billing_state}}<br/>
                                        {{$order->billing_country}}, {{$order->billing_zip}}
                                    </div>
                                    <div class='clear'></div>
                                </div>

                                <div class='form-row'>
                                    <div class='col-3'>Contact number</div>
                                    <div class='col-2'>{{$order->billing_contact_number_1}}<br/>{{$order->billing_contact_number_2}}</div>
                                    <div class='clear'></div>
                                </div>

                            </div>

                            <div class='clear'></div>
                        </form>
                    </div>
                </div>
            </div>

        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

@include('includes/common_js_bottom')
{{HTML::script(asset("/public/js/site/admin/view-location.js"))}}
</body>
</html>
