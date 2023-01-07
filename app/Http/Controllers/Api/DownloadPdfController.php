<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Shipping;
use App\Order;

class DownloadPdfController extends Controller
{
    public function download(Request $request) {
        $shipping = Shipping::find($request->shipping_id);

        $order = Order::find($shipping->order->id)->products;

        $subtotal = 0.00;
        $tax = 0.00;
        $total = 0.00;

        foreach ($order as $item) {
            $subtotal = $subtotal + $item->pivot['total'];
            $tax = $subtotal *.12;
            $total = $subtotal + $tax;
        }

        $pdf = Pdf::loadView('pdf.receipt', [
            'orders' => $order,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
        ]);

        return $pdf->download(''.now().'.pdf');
    }
}
