<!-- Page Layout -->
<x-lord::layouts>
    <!-- Page Title -->
    <x-slot:title>
        @lang('lord::app.home.contact.title')
    </x-slot>

    <div class="container mt-8 max-1180:px-5 max-md:mt-6 max-md:px-4">
        <!-- Form Container -->
		<div class="m-auto w-full max-w-[870px] rounded-xl border border-zinc-200 p-16 px-[90px] max-md:px-8 max-md:py-8 max-sm:border-none max-sm:p-0">
			<h1 class="font-dmserif text-4xl max-md:text-3xl max-sm:text-xl">
                @lang('lord::app.home.contact.title')
            </h1>

			<p class="mt-4 text-xl text-zinc-500 max-sm:mt-1 max-sm:text-sm">
                @lang('lord::app.home.contact.about')
            </p>

            <div class="mt-14 rounded max-sm:mt-8">
                <!-- Contact Form -->
                <x-lord::form :action="route('lord.home.contact_us.send_mail')">
                    <!-- Name -->
                    <x-lord::form.control-group>
                        <x-lord::form.control-group.label class="required">
                            @lang('lord::app.home.contact.name')
                        </x-lord::form.control-group.label>

                        <x-lord::form.control-group.control
                            type="text"
                            class="px-6 py-5 max-md:py-3 max-sm:py-3.5"
                            name="name"
                            rules="required"
                            :value="old('name')"
                            :label="trans('lord::app.home.contact.name')"
                            :placeholder="trans('lord::app.home.contact.name')"
                            :aria-label="trans('lord::app.home.contact.name')"
                            aria-required="true"
                        />

                        <x-lord::form.control-group.error control-name="name" />
                    </x-lord::form.control-group>

                    <!-- Email -->
                    <x-lord::form.control-group>
                        <x-lord::form.control-group.label class="required">
                            @lang('lord::app.home.contact.email')
                        </x-lord::form.control-group.label>

                        <x-lord::form.control-group.control
                            type="email"
                            class="px-6 py-5 max-md:py-3 max-sm:py-3.5"
                            name="email"
                            rules="required|email"
                            :value="old('email')"
                            :label="trans('lord::app.home.contact.email')"
                            :placeholder="trans('lord::app.home.contact.email')"
                            :aria-label="trans('lord::app.home.contact.email')"
                            aria-required="true"
                        />

                        <x-lord::form.control-group.error control-name="email" />
                    </x-lord::form.control-group>

                    <!-- Contact -->
                    <x-lord::form.control-group>
                        <x-lord::form.control-group.label>
                            @lang('lord::app.home.contact.phone-number')
                        </x-lord::form.control-group.label>

                        <x-lord::form.control-group.control
                            type="text"
                            class="px-6 py-5 max-md:py-3 max-sm:py-3.5"
                            name="contact"
                            rules="phone"
                            :value="old('contact')"
                            :label="trans('lord::app.home.contact.phone-number')"
                            :placeholder="trans('lord::app.home.contact.phone-number')"
                            :aria-label="trans('lord::app.home.contact.phone-number')"
                        />

                        <x-lord::form.control-group.error control-name="contact" />
                    </x-lord::form.control-group>

                    <!-- Message -->
                    <x-lord::form.control-group>
                        <x-lord::form.control-group.label class="required">
                            @lang('lord::app.home.contact.desc')
                        </x-lord::form.control-group.label>

                        <x-lord::form.control-group.control
                            type="textarea"
                            class="px-6 py-5 max-md:py-3 max-sm:py-3.5"
                            name="message"
                            rules="required"
                            :label="trans('lord::app.home.contact.message')"
                            :placeholder="trans('lord::app.home.contact.describe-here')"
                            :aria-label="trans('lord::app.home.contact.message')"
                            aria-required="true"
                            rows="10"
                        />

                        <x-lord::form.control-group.error control-name="message" />
                    </x-lord::form.control-group>

                    <!-- Re captcha -->
                    @if (core()->getConfigData('customer.captcha.credentials.status'))
                        <div class="mb-5 flex">
                            {!! \Webkul\Customer\Facades\Captcha::render() !!}
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <div class="mt-8 flex flex-wrap items-center gap-9 max-sm:justify-center max-sm:text-center">
                        <button
                            class="primary-button m-0 mx-auto block w-full max-w-[374px] rounded-2xl px-11 py-4 text-center text-base max-md:max-w-full max-md:rounded-lg max-md:py-3 max-sm:py-1.5 ltr:ml-0 rtl:mr-0"
                            type="submit"
                        >
                            @lang('lord::app.home.contact.submit')
                        </button>
                    </div>
                </x-lord::form>
            </div>
		</div>
    </div>

    @push('scripts')
        {!! \Webkul\Customer\Facades\Captcha::renderJS() !!}
    @endpush
</x-lord::layouts>
