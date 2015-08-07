<?php

// $hash_string = "$key|$txnid|$amount|$productinfo|$firstname|$email|||||||||||$SALT";
// $hash_value = hash("sha512",$hash_string);

// Merchant key here as provided by Payu
$MERCHANT_KEY = "gtKFFx";

// Merchant Salt as provided by Payu
$SALT = "eCwWELxi";

// End point - change to https://secure.payu.in for LIVE mode
$PAYU_BASE_URL = "https://test.payu.in";

$action = '';

$surl = "http://helpmyskills.com/coboo/transactionsuccess";
$furl = "http://helpmyskills.com/coboo/transactionfailure";
$curl = "http://helpmyskills.com/coboo/transactioncancelled";
$service_provider = "";

/*
$posted = array();
if(!empty($_POST)) {
    //print_r($_POST);
  foreach($_POST as $key => $value) {    
    $posted[$key] = $value; 
	
  }
}
*/

$posted = array();

$posted["txnid"] = $order->id;
$posted["firstname"] = $order->shipping_name;
$posted["key"] = $MERCHANT_KEY;
$posted["amount"] = $order->net_amount;
$posted["email"] = $order->email;
$posted["phone"] = $order->shipping_contact_number_1;
$posted["surl"] = $surl;
$posted["furl"] = $furl;
$posted["productinfo"] = $product_json;
$posted["service_provider"] = "payu_paisa";
$posted["city"] = $order->shipping_city;
$posted["state"] = $order->shipping_state;
$posted["zipcode"] = $order->shipping_zip;
$posted["country"] = $order->shipping_country;

$formError = 0;

if(empty($posted['txnid'])) {
    // Generate random transaction id
    $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
    $txnid = $posted['txnid'];
}

$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if(empty($posted['hash']) && sizeof($posted) > 0) {

    if(
            empty($posted['key'])
            || empty($posted['txnid'])
            || empty($posted['amount'])
            || empty($posted['firstname'])
            || empty($posted['email'])
            || empty($posted['phone'])
            || empty($posted['productinfo'])
            || empty($posted['surl'])
            || empty($posted['furl'])
            || empty($posted['service_provider'])
    ) {
        $formError = 1;
    } else {
        //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
        $hashVarsSeq = explode('|', $hashSequence);
        $hash_string = '';
        foreach($hashVarsSeq as $hash_var) {
            $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
            $hash_string .= '|';
        }

        $hash_string .= $SALT;

        $hash = strtolower(hash('sha512', $hash_string));
        $action = $PAYU_BASE_URL . '/_payment';
    }
} elseif(!empty($posted['hash'])) {
    $hash = $posted['hash'];
    $action = $PAYU_BASE_URL . '/_payment';
}
?>
<html>
<head>
    <script>
        var hash = '<?php echo $hash ?>';
        function submitPayuForm() {
            if(hash == '') {
                return;
            }
            var payuForm = document.forms.payuForm;
            payuForm.submit();
        }
    </script>
</head>
<body onload="submitPayuForm()">

<div style="width: 500px; margin:auto; margin-top: 100px">
    <div style="width:375px; float: left; font-size: 24px; font-family: 'arial'; padding-top: 15px;">Transferring for online payment</div>
    <div style="width:100px; float: left">{{HTML::image(asset('public/images/loader.gif'))}}</div>
    <div class="clear"></div>
</div>

<div style="visibility:hidden">

    <h2>PayU Form</h2>
    <br/>
    <?php if($formError) { ?>
    <span style="color:red">Please fill all mandatory fields.</span>
    <br/>
    <br/>
    <?php } ?>
    <form action="<?php echo $action; ?>" method="post" name="payuForm">
        <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
        <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
        <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
        <table>
            <tr>
                <td><b>Mandatory Parameters</b></td>
            </tr>
            <tr>
                <td>Amount: </td>
                <td><input name="amount" value="<?php echo (empty($posted['amount'])) ? '' : $posted['amount'] ?>" /></td>
                <td>First Name: </td>
                <td><input name="firstname" id="firstname" value="<?php echo (empty($posted['firstname'])) ? '' : $posted['firstname']; ?>" /></td>
            </tr>
            <tr>
                <td>Email: </td>
                <td><input name="email" id="email" value="<?php echo (empty($posted['email'])) ? '' : $posted['email']; ?>" /></td>
                <td>Phone: </td>
                <td><input name="phone" value="<?php echo (empty($posted['phone'])) ? '' : $posted['phone']; ?>" /></td>
            </tr>
            <tr>
                <td>Product Info: </td>
                <td colspan="3"><textarea name="productinfo"><?php echo (empty($posted['productinfo'])) ? '' : $posted['productinfo'] ?></textarea></td>
            </tr>
            <tr>
                <td>Success URI: </td>
                <td colspan="3"><input name="surl" value="<?php echo (empty($posted['surl'])) ? '' : $posted['surl'] ?>" size="64" /></td>
            </tr>
            <tr>
                <td>Failure URI: </td>
                <td colspan="3"><input name="furl" value="<?php echo (empty($posted['furl'])) ? '' : $posted['furl'] ?>" size="64" /></td>
            </tr>

            <tr>
                <td>Service Provider: </td>
                <td colspan="3"><input name="service_provider" value="<?php echo (empty($posted['service_provider'])) ? '' : $posted['service_provider'] ?>" size="64" /></td>
            </tr>

            <tr>
                <td><b>Optional Parameters</b></td>
            </tr>
            <tr>
                <td>Last Name: </td>
                <td><input name="lastname" id="lastname" value="<?php echo (empty($posted['lastname'])) ? '' : $posted['lastname']; ?>" /></td>
                <td>Cancel URI: </td>
                <td><input name="curl" value="" /></td>
            </tr>
            <tr>
                <td>Address1: </td>
                <td><input name="address1" value="<?php echo (empty($posted['address1'])) ? '' : $posted['address1']; ?>" /></td>
                <td>Address2: </td>
                <td><input name="address2" value="<?php echo (empty($posted['address2'])) ? '' : $posted['address2']; ?>" /></td>
            </tr>
            <tr>
                <td>City: </td>
                <td><input name="city" value="<?php echo (empty($posted['city'])) ? '' : $posted['city']; ?>" /></td>
                <td>State: </td>
                <td><input name="state" value="<?php echo (empty($posted['state'])) ? '' : $posted['state']; ?>" /></td>
            </tr>
            <tr>
                <td>Country: </td>
                <td><input name="country" value="<?php echo (empty($posted['country'])) ? '' : $posted['country']; ?>" /></td>
                <td>Zipcode: </td>
                <td><input name="zipcode" value="<?php echo (empty($posted['zipcode'])) ? '' : $posted['zipcode']; ?>" /></td>
            </tr>
            <tr>
                <td>UDF1: </td>
                <td><input name="udf1" value="<?php echo (empty($posted['udf1'])) ? '' : $posted['udf1']; ?>" /></td>
                <td>UDF2: </td>
                <td><input name="udf2" value="<?php echo (empty($posted['udf2'])) ? '' : $posted['udf2']; ?>" /></td>
            </tr>
            <tr>
                <td>UDF3: </td>
                <td><input name="udf3" value="<?php echo (empty($posted['udf3'])) ? '' : $posted['udf3']; ?>" /></td>
                <td>UDF4: </td>
                <td><input name="udf4" value="<?php echo (empty($posted['udf4'])) ? '' : $posted['udf4']; ?>" /></td>
            </tr>
            <tr>
                <td>UDF5: </td>
                <td><input name="udf5" value="<?php echo (empty($posted['udf5'])) ? '' : $posted['udf5']; ?>" /></td>
                <td>PG: </td>
                <td><input name="pg" value="<?php echo (empty($posted['pg'])) ? '' : $posted['pg']; ?>" /></td>
            </tr>
            <tr>
                <?php if(!$hash) { ?>
                <td colspan="4"><input type="submit" value="Submit" /></td>
                <?php } ?>
            </tr>
        </table>
    </form>

</div>

</body>
</html>