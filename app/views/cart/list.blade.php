<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Coboo | Listing Courses</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('includes.common_css')

    {{HTML::style(asset("/public/css/site/cart.css"))}}

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

                <h3>Showing your bag</h3>

                <div class="grid-info row">
                    <div class="col-md-8">

                        <table class="zui-table zui-table-zebra zui-table-horizontal">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($cart as $cartItem)

                                <?php
                                if(isset($cartItem['bookId']) && !empty($cartItem['bookId'])){
                                    $id=$cartItem['bookId'];
                                }elseif(isset($cartItem['accessoryId']) && !empty($cartItem['accessoryId'])){
                                    $id=$cartItem['accessoryId'];
                                }else{
                                    $id='';
                                }
                                ?>
                                <tr>
                                    <td>{{$cartItem['name']}}</td>
                                    <td><span class="discounted-price">{{$cartItem['discounted_price']}}</span> <span
                                                class="original-price">{{$cartItem['price']}}</span></td>
                                    <td>
                                        <input type="text" maxlength="2" name="quantity"
                                               id="quantity_{{$id}}" value="{{$cartItem['quantity']}}"
                                               size="1" onfocus="saveQty(this,'{{$id}}')">
                                        <span class="save-bag-qty hidden" id="save-bag-qty_{{$id}}"
                                              onclick="updateQty({{$id}})">save</span>
                                    </td>
                                    <td><span class="remove-bag-item" rel="{{$cartItem['id']}}">Remove</span></td>
                                </tr>

                            @endforeach

                            </tbody>
                        </table>

                        <br/><br/>

                        <div>
                            <span class='payment'>Payment</span>
                        </div>
                    </div>
                </div>

            @else
                <br/>

                <h3>Your bag is empty</h3>

                <br/>

                <a class="go-to-home" href="{{$root}}">Go to home</a>
            @endif

        </div>

    </section>

</div>
<!-- ./wrapper -->

@include('includes.footer')
{{HTML::script(asset("/public/js/site/cart.js"))}}

</body>
</html>
