<html>
<head>
    <meta charset="UTF-8">
    <title>Coboo | Invoice</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
        }
    </style>
</head>
<body>
<section>
    <center>
        <h1>Invoice</h1>
    </center>
</section>
<div>
    <div style="float:left">
        <h1>Coboo</h1>
    </div>
    <div style="float:right">
        <h5>Date : {{date('Y-m-d',strtotime($order->created_at))}}</h5>
        <h5>Transaction ID : {{$order->transaction_id;}}</h5>
    </div>
</div>
<div>
    <table style="width: 100%">
        <thead>
        <tr>
            <td>Shipping information</td>
            <td>Billing information</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                Name  <div class='form-data'>{{$order->shipping_name}}</div> <br/>
                Email  <div class='form-data'>{{$order->email}}</div> <br/>
                Address  <div class='form-data'>{{$order->shipping_address}}, <b>Landmark : </b> {{$order->shipping_land_mark}}</div> <br/>
                Location  <div class='form-data'>
                    {{$order->shipping_city}}, {{$order->shipping_state}},
                    {{$order->shipping_country}}, {{$order->shipping_zip}}
                </div> <br/>
                Contact Number  <div class='form-data'>{{$order->shipping_contact_number_1}}, {{$order->shipping_contact_number_2}}</div> <br/>
            </td>
            <td>
                Name  <div class='form-data'>{{$order->billing_name}}</div> <br/>
                Email  <div class='form-data'>{{$order->email}}</div> <br/>
                Address  <div class='form-data'>{{$order->billing_address}}, <b>Landmark : </b> {{$order->billing_land_mark}}</div> <br/>
                Location  <div class='form-data'>
                    {{$order->billing_city}}, {{$order->billing_state}},
                    {{$order->billing_country}}, {{$order->billing_zip}}
                </div> <br/>
                Contact Number : <div class='form-data'>{{$order->billing_contact_number_1}}, {{$order->billing_contact_number_2}}</div> <br/>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<br />
<br />
<div>
    <table style="width: 100%">
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
</body>
</html>
