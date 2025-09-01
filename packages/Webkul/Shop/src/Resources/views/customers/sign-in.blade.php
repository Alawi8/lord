<!-- SEO Meta Content -->
@push('meta')
    <meta name="description" content="@lang('shop::app.customers.login-form.page-title')"/>
    <meta name="keywords" content="@lang('shop::app.customers.login-form.page-title')"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    
@endPush

@push('styles')
    <link rel="stylesheet" href="{{ bagisto_asset('css/app.css') }}">
@endpush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.login-form.page-title')
    </x-slot>
    
    <div class="container mt-20 max-1180:px-5 max-md:mt-12">
        {!! view_render_event('bagisto.shop.customers.login.logo.before') !!}

        <!-- Company Logo -->
        <div class="flex items-center gap-x-14 max-[1180px]:gap-x-9">
            <a
                href="{{ route('shop.home.index') }}"
                class="m-[0_auto_20px_auto]"
                aria-label="@lang('shop::app.customers.login-form.bagisto')"
            >
                <img
                    src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                    alt="{{ config('app.name') }}"
                    width="131"
                    height="29"
                >
            </a>
        </div>
        <!-- view render After -->
        {!! view_render_event('bagisto.shop.customers.login.logo.after') !!}

        <!-- Form Container -->
        <div class="m-auto w-full max-w-[870px] rounded-xl border border-zinc-200 p-16 px-[90px] max-md:px-8 max-md:py-8 max-sm:border-none max-sm:p-0">
            
            <!-- Navigation Tabs for Login Options -->
            <div class="mb-8 flex rounded-lg bg-gray-100 p-1">
                <button 
                    class="flex-1 rounded-md px-4 py-2 text-sm font-medium transition-colors duration-200 bg-white shadow-sm text-blue-600"
                    id="email-login-tab"
                    data-tab="email-login"
                >
                    <svg class="inline-block w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                    </svg>
                    @lang('shop::app.customers.login-form.email-login')
                </button>
                <button 
                    class="flex-1 rounded-md px-4 py-2 text-sm font-medium transition-colors duration-200 text-gray-500 hover:text-gray-700"
                    id="phone-login-tab"
                    data-tab="phone-login"
                >
                    <svg class="inline-block w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                    </svg>
                    @lang('shop::app.customers.login-form.phone-login')
                </button>
            </div>

            <!-- Email Login Form (Original) -->
            <div id="email-login-form" class="tab-content">
                <h1 class="font-dmserif text-4xl max-md:text-3xl max-sm:text-xl">
                    @lang('shop::app.customers.login-form.page-title')
                </h1>

                <p class="mt-4 text-xl text-zinc-500 max-sm:mt-0 max-sm:text-sm">
                    @lang('shop::app.customers.login-form.form-login-text')
                </p>

                {!! view_render_event('bagisto.shop.customers.login.before') !!}

                <div class="mt-14 rounded max-sm:mt-8">
                    <x-shop::form :action="route('shop.customer.session.create')">

                        {!! view_render_event('bagisto.shop.customers.login_form_controls.before') !!}

                        <!-- Email -->
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="required">
                                @lang('shop::app.customers.login-form.email')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="email"
                                class="px-6 py-4 max-md:py-3 max-sm:py-2"
                                name="email"
                                rules="required|email"
                                value=""
                                :label="trans('shop::app.customers.login-form.email')"
                                placeholder="email@example.com"
                                :aria-label="trans('shop::app.customers.login-form.email')"
                                aria-required="true"
                            />

                            <x-shop::form.control-group.error control-name="email" />
                        </x-shop::form.control-group>

                        <!-- Password -->
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="required">
                                @lang('shop::app.customers.login-form.password')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="password"
                                class="px-6 py-4 max-md:py-3 max-sm:py-2"
                                id="password"
                                name="password"
                                rules="required|min:6"
                                value=""
                                :label="trans('shop::app.customers.login-form.password')"
                                :placeholder="trans('shop::app.customers.login-form.password')"
                                :aria-label="trans('shop::app.customers.login-form.password')"
                                aria-required="true"
                            />

                            <x-shop::form.control-group.error control-name="password" />
                        </x-shop::form.control-group>

                        <div class="flex justify-between">
                            <div class="flex select-none items-center gap-1.5">
                                <input
                                    type="checkbox"
                                    id="show-password"
                                    class="peer hidden"
                                />

                                <label
                                    class="icon-uncheck peer-checked:icon-check-box cursor-pointer text-2xl text-navyBlue peer-checked:text-navyBlue max-sm:text-xl"
                                    for="show-password"
                                ></label>

                                <label
                                    class="cursor-pointer select-none text-base text-zinc-500 max-sm:text-sm ltr:pl-0 rtl:pr-0"
                                    for="show-password"
                                >
                                    @lang('shop::app.customers.login-form.show-password')
                                </label>
                            </div>

                            <div class="block">
                                <a
                                    href="{{ route('shop.customers.forgot_password.create') }}"
                                    class="cursor-pointer text-base text-black max-sm:text-sm"
                                >
                                    <span>
                                        @lang('shop::app.customers.login-form.forgot-pass')
                                    </span>
                                </a>
                            </div>
                        </div>

                        <!-- Captcha -->
                        @if (core()->getConfigData('customer.captcha.credentials.status'))
                            <div class="mt-5 flex">
                                {!! \Webkul\Customer\Facades\Captcha::render() !!}
                            </div>
                        @endif

                        <!-- Submit Button -->
                        <div class="mt-8 flex flex-wrap items-center gap-9 max-sm:justify-center max-sm:gap-5 max-sm:text-center">
                            <button
                                class="primary-button m-0 mx-auto block w-full max-w-[374px] rounded-2xl px-11 py-4 text-center text-base max-md:max-w-full max-md:rounded-lg max-md:py-3 max-sm:py-1.5 ltr:ml-0 rtl:mr-0"
                                type="submit"
                            >
                                @lang('shop::app.customers.login-form.button-title')
                            </button>
                        </div>

                        {!! view_render_event('bagisto.shop.customers.login_form_controls.after') !!}
                    </x-shop::form>
                </div>

                {!! view_render_event('bagisto.shop.customers.login.after') !!}

                <p class="mt-5 font-medium text-zinc-500 max-sm:text-center max-sm:text-sm">
                    @lang('shop::app.customers.login-form.new-customer')

                    <a
                        class="text-navyBlue"
                        href="{{ route('shop.customers.register.index') }}"
                    >
                        @lang('shop::app.customers.login-form.create-your-account')
                    </a>
                </p>
            </div>

            <!-- Phone Login Form (New) -->
            <div id="phone-login-form" class="tab-content hidden">
                <h1 class="font-dmserif text-4xl max-md:text-3xl max-sm:text-xl">
                    @lang('shop::app.customers.login-form.phone-login-title')
                </h1>

                <p class="mt-4 text-xl text-zinc-500 max-sm:mt-0 max-sm:text-sm">
                    @lang('shop::app.customers.login-form.phone-login-subtitle')
                </p>

                <div class="mt-14 rounded max-sm:mt-8">
                    <!-- Phone Input Form -->
                    <div id="phone-input-form">
                        <div class="mb-6">
                            <label class="mb-3 block text-xs font-medium text-zinc-500">
                                @lang('shop::app.customers.login-form.phone-number')
                                <span class="text-red-600">*</span>
                            </label>
                            
                            <!-- Country Code + Phone Number -->
                            <div class="flex gap-2">
                                <select id="country-code" class="country-select rounded-xl border border-zinc-200 px-3 py-4 text-base max-md:py-3 max-sm:py-2">
                                    <option value="+966" data-country="sa">🇸🇦 +966</option>
                                    <option value="+965" data-country="kw">🇰🇼 +965</option>
                                    <option value="+973" data-country="bh">🇧🇭 +973</option>
                                    <option value="+974" data-country="qa">🇶🇦 +974</option>
                                    <option value="+971" data-country="ae">🇦🇪 +971</option>
                                    <option value="+968" data-country="om">🇴🇲 +968</option>
                                </select>
                                
                                <input
                                    type="tel"
                                    id="phone-number"
                                    class="phone-input flex-1 rounded-xl border border-zinc-200 px-6 py-4 text-base text-zinc-800 transition-all duration-300 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 max-md:py-3 max-sm:py-2"
                                    placeholder="@lang('shop::app.customers.login-form.phone-placeholder')"
                                    maxlength="9"
                                    required
                                />
                            </div>
                            
                            <div class="mt-2 text-sm text-zinc-500">
                                <svg class="inline-block w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                @lang('shop::app.customers.login-form.phone-help')
                            </div>

                            <div id="phone-error" class="hidden mt-2 text-sm text-red-600"></div>
                        </div>

                        <button
                            type="button"
                            id="send-otp-button"
                            class="primary-button m-0 mx-auto block w-full max-w-[374px] rounded-2xl px-11 py-4 text-center text-base max-md:max-w-full max-md:rounded-lg max-md:py-3 max-sm:py-1.5 ltr:ml-0 rtl:mr-0"
                        >
                            <svg class="inline-block w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                            @lang('shop::app.customers.login-form.send-otp')
                        </button>
                    </div>

                    <!-- OTP Verification Form -->
                    <div id="otp-verification-form" class="hidden">
                        <div class="text-center mb-6">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-zinc-800 mb-2">@lang('shop::app.customers.login-form.otp-sent-title')</h3>
                            <p class="text-zinc-500 text-sm">@lang('shop::app.customers.login-form.otp-sent-subtitle')</p>
                        </div>

                        <div class="mb-6">
                            <label class="mb-3 block text-xs font-medium text-zinc-500">
                                @lang('shop::app.customers.login-form.otp-code')
                                <span class="text-red-600">*</span>
                            </label>
                            
                            <input
                                type="text"
                                id="otp-code"
                                class="otp-input w-full rounded-xl border border-zinc-200 px-6 py-4 text-base text-zinc-800 transition-all duration-300 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200 max-md:py-3 max-sm:py-2 text-center font-bold text-2xl tracking-widest"
                                placeholder="123456"
                                maxlength="6"
                                required
                            />
                            
                            <div class="mt-2 text-sm text-zinc-500">
                                @lang('shop::app.customers.login-form.otp-help')
                            </div>

                            <div id="otp-error" class="hidden mt-2 text-sm text-red-600"></div>
                        </div>

                        <div class="mt-8 flex flex-col gap-3">
                            <button
                                type="button"
                                id="verify-otp-button"
                                class="primary-button m-0 mx-auto block w-full max-w-[374px] rounded-2xl px-11 py-4 text-center text-base max-md:max-w-full max-md:rounded-lg max-md:py-3 max-sm:py-1.5 ltr:ml-0 rtl:mr-0"
                            >
                                <svg class="inline-block w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                @lang('shop::app.customers.login-form.verify-login')
                            </button>

                            <div class="text-center">
                                <button
                                    type="button"
                                    id="resend-otp-button"
                                    class="text-sm text-zinc-500 hover:text-zinc-700 transition-colors duration-200 hidden"
                                >
                                    @lang('shop::app.customers.login-form.resend-otp')
                                </button>
                                
                                <span id="resend-timer" class="text-sm text-zinc-400"></span>
                            </div>

                            <button
                                type="button"
                                id="back-to-phone-button"
                                class="mx-auto block text-center text-base text-zinc-500 hover:text-zinc-700 transition-colors duration-200"
                            >
                                @lang('shop::app.customers.login-form.back-to-phone')
                            </button>
                        </div>
                    </div>

                    <!-- Alert Messages -->
                    <div id="alert-message" class="hidden mt-4"></div>
                </div>

                <p class="mt-5 font-medium text-zinc-500 max-sm:text-center max-sm:text-sm">
                    @lang('shop::app.customers.login-form.no-account')

                    <a
                        class="text-navyBlue"
                        href="{{ route('shop.customers.register.index') }}"
                    >
                        @lang('shop::app.customers.login-form.create-account')
                    </a>
                </p>
            </div>
        </div>

        <p class="mb-4 mt-8 text-center text-xs text-zinc-500">
            @lang('shop::app.customers.login-form.footer', ['current_year'=> date('Y') ])
        </p>
    </div>

@push('scripts')
    {!! \Webkul\Customer\Facades\Captcha::renderJS() !!}    
    <!-- Password Visibility Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const showPasswordCheckbox = document.getElementById('show-password');
            const passwordField = document.getElementById('password');
            
            if (showPasswordCheckbox && passwordField) {
                showPasswordCheckbox.addEventListener('change', function() {
                    passwordField.type = this.checked ? 'text' : 'password';
                });
            }
        });
    </script>
@endpush
</x-shop::layouts>