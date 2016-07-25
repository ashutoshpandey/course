<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Coboo | Success</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.common_css')


    {{HTML::style(asset("/public/css/site/checkout-login.css"))}}
    {{HTML::style(asset("/public/css/site/order.css"))}}

    @include('includes.common_js_top')
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        @include('includes.header')
    </header>

    <section class='content'>

        <div class="container">
            <div class="row" style="margin-top: 120px">
                <div class="col-md-9">

                    <h3>Your transaction was successful</h3>
                </div>
            </div>
            <div class="row">

                <div class="grid-info row">
                    <div class="col-md-8">
                        <div class="row">
                            <div style="float:left">

                                <h1>
                                    Coboo
                                </h1>
                            </div>
                            <div style="float:right">

                                <h5>Date : {{date('Y-m-d',strtotime($order->created_at))}}</h5>
                                <h5>Transaction ID : {{$order->transaction_id;}}</h5>
                            </div>
                        </div>

                        <div class="row">
                            <table class="zui-table zui-table-zebra zui-table-horizontal">
                                <thead>
                                <tr>
                                    <td>Shipping information</td>
                                    <td>Billing information</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        Name
                                        <div class='form-data'>{{$order->shipping_name}}</div>
                                        <br/>
                                        Email
                                        <div class='form-data'>{{$order->email}}</div>
                                        <br/>
                                        Address
                                        <div class='form-data'>{{$order->shipping_address}}, <b>Landmark
                                                : </b> {{$order->shipping_land_mark}}</div>
                                        <br/>
                                        Location
                                        <div class='form-data'>
                                            {{$order->shipping_city}}, {{$order->shipping_state}},
                                            {{$order->shipping_country}}, {{$order->shipping_zip}}
                                        </div>
                                        <br/>
                                        Contact Number
                                        <div class='form-data'>{{$order->shipping_contact_number_1}}
                                            , {{$order->shipping_contact_number_2}}</div>
                                        <br/>
                                    </td>
                                    <td>
                                        Name
                                        <div class='form-data'>{{$order->billing_name}}</div>
                                        <br/>
                                        Email
                                        <div class='form-data'>{{$order->email}}</div>
                                        <br/>
                                        Address
                                        <div class='form-data'>{{$order->billing_address}}, <b>Landmark
                                                : </b> {{$order->billing_land_mark}}</div>
                                        <br/>
                                        Location
                                        <div class='form-data'>
                                            {{$order->billing_city}}, {{$order->billing_state}},
                                            {{$order->billing_country}}, {{$order->billing_zip}}
                                        </div>
                                        <br/>
                                        Contact Number :
                                        <div class='form-data'>{{$order->billing_contact_number_1}}
                                             {{$order->billing_contact_number_2}}</div>
                                        <br/>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div>
                    <table class="zui-table zui-table-zebra zui-table-horizontal">
                        <thead>
                        <tr>
                            <td>Description</td>
                            <td>Qty</td>
                            <td>Price</td>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($orderItems as $orderItem)
                            <tr>
                                <td>{{$orderItem->product->name}}</td>
                                <td>{{$orderItem->quantity}}</td>
                                <td>{{$orderItem->discounted_price}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td>Thank You</td>
                            <td>Total</td>
                            <td>{{$order->amount}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

</div>
<!-- ./wrapper -->

@include('includes.footer')
{{HTML::script(asset("/public/js/site/checkout-login.js"))}}
</body>
</html>
