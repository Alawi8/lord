<?php

namespace Webkul\Lord\Http\Controllers;

class CartController extends Controller
{
    /**
     * Cart page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (! core()->getConfigData('sales.checkout.lordping_cart.cart_page')) {
            abort(404);
        }

        return view('lord::checkout.cart.index');
    }
}
