{{-- SEO Meta Content --}}
@push('meta')
    <meta name="description" content="@lang('store::app.customers.signup-form.page-title')"/>

    <meta name="keywords" content="@lang('store::app.customers.signup-form.page-title')"/>
@endPush

<x-store::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    {{-- Page Title --}}
    <x-slot:title>
        @lang('store::app.customers.signup-form.page-title')
    </x-slot>

	<div class="container mt-20 max-1180:px-[20px]">
        {{-- Company Logo --}}
        <div class="flex gap-x-[54px] items-center max-[1180px]:gap-x-[35px]">
            <a
                href="{{ route('store.home.index') }}"
                class="m-[0_auto_20px_auto]"
                aria-label="Bagisto "
            >
                <img
                    src="{{ bagisto_asset('images/logo.svg') }}"
                    alt="Bagisto "
                    width="131"
                    height="29"
                >
            </a>
        </div>

        {{-- Form Container --}}
		<div
			class="w-full max-w-[870px] m-auto px-[90px] py-[60px] border border-[#E9E9E9] rounded-[12px] max-md:px-[30px] max-md:py-[30px]"
        >
			<h1 class="text-[40px] font-dmserif max-sm:text-[25px]">
                @lang('store::app.customers.signup-form.page-title')
            </h1>

			<p class="mt-[15px] text-[#6E6E6E] text-[20px] max-sm:text-[16px]">
                @lang('store::app.customers.signup-form.form-signup-text')
            </p>

            <div class="mt-[60px] rounded max-sm:mt-[30px]">
                <x-store::form :action="route('store.customers.register.store')">
                    {!! view_render_event('bagisto.store.customers.signup_form_controls.before') !!}

                    <x-store::form.control-group class="mb-4">
                        <x-store::form.control-group.label class="required">
                            @lang('store::app.customers.signup-form.first-name')
                        </x-store::form.control-group.label>

                        <x-store::form.control-group.control
                            type="text"
                            name="first_name"
                            class="!p-[20px_25px] rounded-lg"
                            :value="old('last_name')"
                            rules="required"
                            :label="trans('store::app.customers.signup-form.first-name')"
                            :placeholder="trans('store::app.customers.signup-form.first-name')"
                        >
                        </x-store::form.control-group.control>

                        <x-store::form.control-group.error
                            control-name="first_name"
                        >
                        </x-store::form.control-group.error>
                    </x-store::form.control-group>

                    {!! view_render_event('bagisto.store.customers.signup_form_controls.first_name.after') !!}

                    <x-store::form.control-group class="mb-4">
                        <x-store::form.control-group.label class="required">
                            @lang('store::app.customers.signup-form.last-name')
                        </x-store::form.control-group.label>

                        <x-store::form.control-group.control
                            type="text"
                            name="last_name"
                            class="!p-[20px_25px] rounded-lg"
                            :value="old('last_name')"
                            rules="required"
                            :label="trans('store::app.customers.signup-form.last-name')"
                            :placeholder="trans('store::app.customers.signup-form.last-name')"
                        >
                        </x-store::form.control-group.control>

                        <x-store::form.control-group.error
                            control-name="last_name"
                        >
                        </x-store::form.control-group.error>
                    </x-store::form.control-group>

                    {!! view_render_event('bagisto.store.customers.signup_form_controls.last_name.after') !!}

                    <x-store::form.control-group class="mb-4">
                        <x-store::form.control-group.label class="required">
                            @lang('store::app.customers.signup-form.email')
                        </x-store::form.control-group.label>

                        <x-store::form.control-group.control
                            type="email"
                            name="email"
                            class="!p-[20px_25px] rounded-lg"
                            :value="old('email')"
                            rules="required|email"
                            :label="trans('store::app.customers.signup-form.email')"
                            placeholder="email@example.com"
                        >
                        </x-store::form.control-group.control>

                        <x-store::form.control-group.error
                            control-name="email"
                        >
                        </x-store::form.control-group.error>
                    </x-store::form.control-group>

                    {!! view_render_event('bagisto.store.customers.signup_form_controls.email.after') !!}

                    <x-store::form.control-group class="mb-6">
                        <x-store::form.control-group.label class="required">
                            @lang('store::app.customers.signup-form.password')
                        </x-store::form.control-group.label>

                        <x-store::form.control-group.control
                            type="password"
                            name="password"
                            class="!p-[20px_25px] rounded-lg"
                            :value="old('password')"
                            rules="required|min:6"
                            ref="password"
                            :label="trans('store::app.customers.signup-form.password')"
                            :placeholder="trans('store::app.customers.signup-form.password')"
                        >
                        </x-store::form.control-group.control>

                        <x-store::form.control-group.error
                            control-name="password"
                        >
                        </x-store::form.control-group.error>
                    </x-store::form.control-group>

                    {!! view_render_event('bagisto.store.customers.signup_form_controls.password.after') !!}

                    <x-store::form.control-group class="mb-4">
                        <x-store::form.control-group.label>
                            @lang('store::app.customers.signup-form.confirm-pass')
                        </x-store::form.control-group.label>

                        <x-store::form.control-group.control
                            type="password"
                            name="password_confirmation"
                            class="!p-[20px_25px] rounded-lg"
                            value=""
                            rules="confirmed:@password"
                            :label="trans('store::app.customers.signup-form.password')"
                            :placeholder="trans('store::app.customers.signup-form.confirm-pass')"
                        >
                        </x-store::form.control-group.control>

                        <x-store::form.control-group.error
                            control-name="password_confirmation"
                        >
                        </x-store::form.control-group.error>
                    </x-store::form.control-group>

                    {!! view_render_event('bagisto.store.customers.signup_form_controls.password_confirmation.after') !!}


                    @if (core()->getConfigData('customer.captcha.credentials.status'))
                        <div class="flex mb-[20px]">
                            {!! Captcha::render() !!}
                        </div>
                    @endif

                    @if (core()->getConfigData('customer.settings.newsletter.subscription'))
                        <div class="flex gap-[6px] items-center select-none">
                            <input
                                type="checkbox"
                                name="is_subscribed"
                                id="is-subscribed"
                                class="hidden peer"
                                onchange="switchVisibility()"
                            />

                            <label
                                class="icon-uncheck text-[24px] text-navyBlue peer-checked:icon-check-box peer-checked:text-navyBlue cursor-pointer"
                                for="is-subscribed"
                            ></label>

                            <label
                                class="pl-0 text-[16] text-[#6E6E6E] max-sm:text-[12px] select-none cursor-pointer"
                                for="is-subscribed"
                            >
                                @lang('store::app.customers.signup-form.subscribe-to-newsletter')
                            </label>
                        </div>
                    @endif

                    {!! view_render_event('bagisto.store.customers.signup_form_controls.after') !!}

                    <div class="flex gap-[36px] flex-wrap items-center mt-[30px]">
                        <button
                            class="primary-button block w-full max-w-[374px] py-[16px] px-[43px] mx-auto m-0 ml-[0px] rounded-[18px] text-[16px] text-center"
                            type="submit"
                        >
                            @lang('store::app.customers.signup-form.button-title')
                        </button>

                        <div class="flex gap-[15px] flex-wrap">
                            {!! view_render_event('bagisto.store.customers.login_form_controls.before') !!}
                        </div>
                    </div>

                    {!! view_render_event('bagisto.store.customers.signup_form_controls.after') !!}

                </x-store::form>
            </div>

			<p class="mt-[20px] text-[#6E6E6E] font-medium">
                @lang('store::app.customers.signup-form.account-exists')

                <a class="text-navyBlue"
                    href="{{ route('store.customer.session.index') }}"
                >
                    @lang('store::app.customers.signup-form.sign-in-button')
                </a>
            </p>
		</div>

        <p class="mt-[30px] mb-[15px] text-center text-[#6E6E6E] text-xs">
            @lang('store::app.customers.signup-form.footer', ['current_year'=> date('Y') ])
        </p>
	</div>

    @push('scripts')
        {!! Captcha::renderJS() !!}
    @endpush
</x-store::layouts>
