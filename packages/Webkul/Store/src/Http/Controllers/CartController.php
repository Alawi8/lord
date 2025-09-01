<?php

namespace Webkul\Store\Http\Controllers;

class CartController extends Controller
{
    /**
     * Cart page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('store::checkout.cart.index');
    }
}
