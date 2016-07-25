<?php

/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 11-07-2016
 * Time: 11:14
 */
class PdfHelper
{
    public static function saveInvoice($id)
    {
        if (isset($id)) {

            $order = Order::find($id);

            if (isset($order)) {

                //  Session::put('order_id', $id);

                $orderItems = OrderItem::where('order_id', $order->id)->get();
                $couriers = Courier::where('status', 'active')->get();

                $pdf = PDF::loadView('pdf.adminInvoice', ['order' => $order, 'orderItems' => $orderItems, 'couriers' => $couriers]);


                $output = $pdf->output();
                $file_to_save = './public/uploads/pdf/order_' . $order->id . '.pdf';
                file_put_contents($file_to_save, $output);
                return true;

            } else
                return Redirect::to('/');
        } else
            return Redirect::to('/');
    }

    
}