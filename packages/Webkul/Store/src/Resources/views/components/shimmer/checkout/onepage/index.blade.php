<div class="grid grid-cols-[1fr_auto] gap-[30px] max-lg:grid-cols-[1fr]">
    <div>
        {{-- Billing Address Shimmer --}}
        <x-store::shimmer.checkout.onepage.address/>

        {{-- Shipping Method Shimmer --}}
        <x-store::shimmer.checkout.onepage.shipping-method/>

        {{-- Payment Method Shimmer --}}
        <x-store::shimmer.checkout.onepage.payment-method/>
    </div>

    <x-store::shimmer.checkout.onepage.cart-summary/>
</div>
