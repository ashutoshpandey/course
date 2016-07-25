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

                <h3>Showing your orders</h3>

                <div class="grid-info row">
                    <div class="col-md-8">

                        <table class="zui-table zui-table-zebra zui-table-horizontal">
                            <thead>
                            <tr>
                                <th>Product Details</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($orderItems as $item)
                                @foreach($item as $orderItem)

                                    <tr>
                                        <td>{{$orderItem->product->name}}</td>
                                        <td>{{$orderItem->created_at}}</td>
                                        <td>{{$orderItem['status']}}</td>
                                        <td><a class="view-order-item" href="{{$root}}/view-order-item/{{$orderItem['id']}}">View</a></td>
                                    </tr>

                                @endforeach
                            @endforeach

                            </tbody>
                        </table>

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
