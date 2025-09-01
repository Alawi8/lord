<x-lord::layouts
	:has-header="true"
	:has-feature="false"
	:has-footer="true"
>
    <!-- Page Title -->
    <x-slot:title>
		@lang('lord::app.checkout.success.thanks')
    </x-slot>

	<!-- Page content -->
	<div class="container mt-8 px-[60px] max-lg:px-8">
		<div class="grid place-items-center gap-y-5 max-md:gap-y-2.5">
			{{ view_render_event('bagisto.lord.checkout.success.image.before', ['order' => $order]) }}

			<img 
				class="max-md:h-[100px] max-md:w-[100px]"
				src="{{ bagisto_asset('images/thank-you.png') }}" 
				alt="@lang('lord::app.checkout.success.thanks')" 
				title="@lang('lord::app.checkout.success.thanks')"
			>

			{{ view_render_event('bagisto.lord.checkout.success.image.after', ['order' => $order]) }}

			<p class="text-xl max-md:text-sm">
				@if (auth()->guard('customer')->user())
					@lang('lord::app.checkout.success.order-id-info', [
						'order_id' => '<a class="text-blue-700" href="'.route('lord.customers.account.orders.view', $order->id).'">'.$order->increment_id.'</a>'
					])
				@else
					@lang('lord::app.checkout.success.order-id-info', ['order_id' => $order->increment_id]) 
				@endif
			</p>

			<p class="font-medium md:text-2xl">
				@lang('lord::app.checkout.success.thanks')
			</p>
			
			<p class="text-xl text-zinc-500 max-md:text-center max-md:text-xs">
				@if (! empty($order->checkout_message))
					{!! nl2br($order->checkout_message) !!}
				@else
					@lang('lord::app.checkout.success.info')
				@endif
			</p>

			{{ view_render_event('bagisto.lord.checkout.success.continue-lordping.before', ['order' => $order]) }}

			<a href="{{ route('lord.home.index') }}">
				<div class="w-max cursor-pointer rounded-2xl bg-navyBlue px-11 py-3 text-center text-base font-medium text-white max-md:rounded-lg max-md:px-6 max-md:py-1.5">
             		@lang('lord::app.checkout.cart.index.continue-lordping')
				</div> 
			</a>
			
			{{ view_render_event('bagisto.lord.checkout.success.continue-lordping.after', ['order' => $order]) }}
		</div>
	</div>
</x-lord::layouts>