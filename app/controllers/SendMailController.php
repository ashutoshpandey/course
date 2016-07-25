<?php

class SendMailController extends BaseController
{
    function __construct(){
        View::share('root', URL::to('/'));

        $user_id = Session::get('user_id');
        if(isset($user_id)){
            $name = Session::get('name');

            View::share('name', $name);
            View::share('logged', true);
        }
        else
            View::share('logged', false);
    }

//invoiceMail() function  is used to send mail with hyper link to generate invoice pdf
    /*    public function invoiceMail($id){

            $adminId = Session::get('admin_id');
            if (!isset($adminId))
                return Redirect::to('/');

            if (isset($id)) {

                $order = Order::find($id);

                if (isset($order)) {

                    Mail::send('emails.invoiceCopy',['order'=>$order],function($message) use ($order){
                        $message->to($order->email,'Coboo');
                        $message->from('mayur.sonawaneintaj@gmail.com');
                        $message ->subject('Invoice Copy');
                    });
                    return json_encode(array('message'=>'done'));
                } else
                    return json_encode(array('message'=>'invalid'));
            } else
                return json_encode(array('message'=>'invalid'));
        }*/

//invoiceMailAttachment() function  is to send invoice as a attachment in mail
    public function invoiceMail($id)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        if (isset($id)) {

            $order = Order::find($id);

            if (isset($order)) {
                $pdf = PdfHelper::saveInvoice($id);
                $pathToFile='./public/uploads/pdf/order_'.$order->id.'.pdf';
                if ($pdf) {
                    Mail::send('emails.invoiceCopy', ['order' => $order], function ($message) use ($order,$pathToFile) {
                        $message->to($order->email, 'Coboo');
                        $message->from('mayur.sonawaneintaj@gmail.com');
                        $message->subject('Invoice Copy');
                        $message->attach($pathToFile);
                    });
                    return json_encode(array('message' => 'done'));
                }
            } else
                return json_encode(array('message' => 'invalid'));
        } else
            return json_encode(array('message' => 'invalid'));
    }


    public function adminSendMail(){
        return View::make('emails.sendMail');
    }


    public static function userInvoiceMail($id)
    {


        if (isset($id)) {

            $order = Order::find($id);

            if (isset($order)) {
                $pdf = PdfHelper::saveInvoice($id);
                $pathToFile = './public/uploads/pdf/order_' . $order->id . '.pdf';
                if ($pdf) {
                    Mail::send('emails.invoiceCopy', ['order' => $order], function ($message) use ($order, $pathToFile) {
                        $message->to($order->email, 'Coboo');
                        $message->from('mayur.sonawaneintaj@gmail.com');
                        $message->subject('Invoice Copy');
                        $message->attach($pathToFile);
                    });
                    return true;
                }
            } else
                return false;
        } else
            return false;
    }

}