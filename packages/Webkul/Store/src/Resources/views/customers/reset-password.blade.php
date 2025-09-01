{{-- SEO Meta Content --}}
@push('meta')
    <meta name="description" content="@lang('store::app.customers.reset-password.title')"/>

    <meta name="keywords" content="@lang('store::app.customers.reset-password.title')"/>
@endPush

<x-store::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    {{-- Page Title --}}
    <x-slot:title>
        @lang('store::app.customers.reset-password.title')
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
                @lang('store::app.customers.reset-password.title')
            </h1>

            {!! view_render_event('bagisto.store.customers.reset_password.before') !!}

            <div class="mt-[60px] rounded max-sm:mt-[30px]">
                <x-store::form :action="route('store.customers.reset_password.store')" >
                    <x-store::form.control-group.control
                        type="hidden"
                        name="token"
                        :value="$token"
                    >
                    </x-store::form.control-group.control>

                    {!! view_render_event('bagisto.store.customers.reset_password_form_controls.before') !!}

                    <x-store::form.control-group class="mb-4">
                        <x-store::form.control-group.label class="required">
                            @lang('store::app.customers.reset-password.email')
                        </x-store::form.control-group.label>

                        <x-store::form.control-group.control
                            type="email"
                            name="email"
                            class="!p-[20px_25px] rounded-lg"
                            :value="old('email')"
                            id="email"
                            rules="required|email"
                            :label="trans('store::app.customers.reset-password.email')"
                            placeholder="email@example.com"
                        >
                        </x-store::form.control-group.control>

                        <x-store::form.control-group.error
                            control-name="email"
                        >
                        </x-store::form.control-group.error>
                    </x-store::form.control-group>

                    <x-store::form.control-group class="mb-6">
                        <x-store::form.control-group.label class="required">
                            @lang('store::app.customers.reset-password.password')
                        </x-store::form.control-group.label>

                        <x-store::form.control-group.control
                            type="password"
                            name="password"
                            class="!p-[20px_25px] rounded-lg"
                            value=""
                            ref="password"
                            rules="required|min:6"
                            :label="trans('store::app.customers.reset-password.password')"
                            :placeholder="trans('store::app.customers.reset-password.password')"
                        >
                        </x-store::form.control-group.control>

                        <x-store::form.control-group.error
                            control-name="password"
                        >
                        </x-store::form.control-group.error>
                    </x-store::form.control-group>

                    <x-store::form.control-group class="mb-6">
                        <x-store::form.control-group.label>
                            @lang('store::app.customers.reset-password.confirm-password')
                        </x-store::form.control-group.label>

                        <x-store::form.control-group.control
                            type="password"
                            name="password_confirmation"
                            class="!p-[20px_25px] rounded-lg"
                            value=""
                            rules="confirmed:@password"
                            :label="trans('store::app.customers.reset-password.confirm-password')"
                            :placeholder="trans('store::app.customers.reset-password.confirm-password')"
                        >
                        </x-store::form.control-group.control>

                        <x-store::form.control-group.error
                            control-name="password"
                        >
                        </x-store::form.control-group.error>
                    </x-store::form.control-group>

                    {!! view_render_event('bagisto.store.customers.reset_password_form_controls.after') !!}

                    <div class="flex gap-[36px] flex-wrap mt-[30px] items-center">
                        <button
                            class="primary-button block w-full max-w-[374px] py-[16px] px-[43px] m-0 ml-[0px] mx-auto rounded-[18px] text-[16px] text-center"
                            type="submit"
                        >
                            @lang('store::app.customers.reset-password.submit-btn-title')
                        </button>
                    </div>

                </x-store::form>
            </div>

            {!! view_render_event('bagisto.store.customers.reset_password.after') !!}

        </div>

        <p class="mt-[30px] mb-[15px] text-center text-[#6E6E6E] text-xs">
            @lang('store::app.customers.reset_password.footer', ['current_year'=> date('Y') ])
        </p>
    </div>
</x-store::layouts>
