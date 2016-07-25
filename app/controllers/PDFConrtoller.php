<!--PDFConrtoller-->

<?php

class PDFConrtoller extends BaseController
{
    function __construct()
    {
        View::share('root', URL::to('/'));
    }




//adminInovice() function is use to generate pdf via hyper link in email
    public function adminInvoice($id){

        if (isset($id)) {

            $order = Order::find($id);

            if (isset($order)) {

                //  Session::put('order_id', $id);

                $orderItems = OrderItem::where('order_id', $order->id)->get();
                $couriers = Courier::where('status', 'active')->get();

                $pdf = PDF::loadView('pdf.adminInvoice', ['order'=>$order,'orderItems'=>$orderItems,'couriers'=>$couriers]);
//                return $pdf->download('invoice.pdf');
                return $pdf->stream();

            } else
                return Redirect::to('/');
        } else
            return Redirect::to('/');
    }

    

}