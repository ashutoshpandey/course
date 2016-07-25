<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Invoice Copy</h2>

<div>
    <h3>Dear, {{$order->shipping_name}}</h3>
</div>
<div>
    <b>Thank you for your bussiness</b>.This mail is to notify you about your invoice copy from Coboo.
</div>
<div>
    <h4>Please find below your attached Invoice Copy</h4>
    {{--<h4>Please Click on this link <a href="{{ URL::to('admin-generate-invoice',$order->id) }}" target="_blank">Click Here</a>.</h4>--}}
</div>
</body>
</html>