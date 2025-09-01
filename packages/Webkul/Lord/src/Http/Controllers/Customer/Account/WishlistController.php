<?php

namespace Webkul\Lord\Http\Controllers\Customer\Account;

use Webkul\Lord\Http\Controllers\Controller;

class WishlistController extends Controller
{
    /**
     * Displays the listing resources if the customer having items in wishlist.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (! core()->getConfigData('customer.settings.wishlist.wishlist_option')) {
            abort(404);
        }

        return view('lord::customers.account.wishlist.index');
    }
}
