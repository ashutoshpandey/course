<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Coboo | My Order</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.common_css')

    {{HTML::style(asset("/public/css/site/order.css"))}}

    @include('includes.common_js_top')
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        @include('includes.header')
    </header>

    <section class='content'>

        <div class="container cart">

            @if($found)

                <h3>Showing your order</h3>

                <div class="grid-info row">
                    <div class="col-md-8">
                        <div>
                            <div style="float:left">
                                <h1>
                                    {{$orderItem->product->name}}
                                </h1>
                            </div>
                            <div style="float:right">
                                @foreach($order as $value)
                                    <h5>Date : {{date('Y-m-d',strtotime($value->created_at))}}</h5>
                                    <h5>Transaction ID : {{$value->transaction_id;}}</h5>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <table class="zui-table zui-table-zebra zui-table-horizontal">
                                <thead>
                                <tr>
                                    <td>Shipping information</td>
                                    <td>Billing information</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order as $order)
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
                                                , {{$order->billing_contact_number_2}}</div>
                                            <br/>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            @else
                <br/>

                <h3>You Have No Orders</h3>

                <br/>

                <a class="go-to-home" href="{{$root}}">Go to home</a>
            @endif

        </div>

    </section>

</div>
<!-- ./wrapper -->

@include('includes.footer')
</body>
</html>
