<x-lord::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('lord::app.customers.account.profile.edit.edit-profile')
    </x-slot>

    <!-- Breadcrumbs -->
    @if ((core()->getConfigData('general.general.breadcrumbs.lord')))
        @section('breadcrumbs')
            <x-lord::breadcrumbs name="profile.edit" />
        @endSection
    @endif

    <div class="max-md:hidden">
        <x-lord::layouts.account.navigation />
    </div>

    <div class="mx-4 flex-auto max-md:mx-6 max-sm:mx-4">
        <div class="mb-8 flex items-center max-md:mb-5">
            <!-- Back Button -->
            <a
                class="grid md:hidden"
                href="{{ route('lord.customers.account.profile.index') }}"
            >
                <span class="icon-arrow-left rtl:icon-arrow-right text-2xl"></span>
            </a>

            <h2 class="text-2xl font-medium max-md:text-xl max-sm:text-base ltr:ml-2.5 md:ltr:ml-0 rtl:mr-2.5 md:rtl:mr-0">
                @lang('lord::app.customers.account.profile.edit.edit-profile')
            </h2>
        </div>
    
        {!! view_render_event('bagisto.lord.customers.account.profile.edit.before', ['customer' => $customer]) !!}

        <!-- Profile Edit Form -->
        <x-lord::form
            :action="route('lord.customers.account.profile.update')"
            enctype="multipart/form-data"
        >
            {!! view_render_event('bagisto.lord.customers.account.profile.edit_form_controls.before', ['customer' => $customer]) !!}
    
            <!-- Image -->
            <x-lord::form.control-group class="mt-4">
                <x-lord::form.control-group.control
                    type="image"
                    class="max-md:[&>*]:[&>*]:rounded-full mb-0 rounded-xl !p-0 text-gray-700 max-md:grid max-md:justify-center"
                    name="image[]"
                    :label="trans('Image')"
                    :is-multiple="false"
                    accepted-types="image/*"
                    :src="$customer->image_url"
                />

                <x-lord::form.control-group.error control-name="image[]" />
            </x-lord::form.control-group>

            {!! view_render_event('bagisto.lord.customers.account.profile.edit_form_controls.image.after') !!}

            <!-- First Name -->
            <x-lord::form.control-group>
                <x-lord::form.control-group.label class="required">
                    @lang('lord::app.customers.account.profile.edit.first-name')
                </x-lord::form.control-group.label>

                <x-lord::form.control-group.control
                    type="text"
                    name="first_name"
                    rules="required"
                    :value="old('first_name') ?? $customer->first_name"
                    :label="trans('lord::app.customers.account.profile.edit.first-name')"
                    :placeholder="trans('lord::app.customers.account.profile.edit.first-name')"
                />

                <x-lord::form.control-group.error control-name="first_name" />
            </x-lord::form.control-group>

            {!! view_render_event('bagisto.lord.customers.account.profile.edit_form_controls.first_name.after') !!}

            <!-- Last Name -->
            <x-lord::form.control-group>
                <x-lord::form.control-group.label class="required">
                    @lang('lord::app.customers.account.profile.edit.last-name')
                </x-lord::form.control-group.label>

                <x-lord::form.control-group.control
                    type="text"
                    name="last_name"
                    rules="required"
                    :value="old('last_name') ?? $customer->last_name"
                    :label="trans('lord::app.customers.account.profile.edit.last-name')"
                    :placeholder="trans('lord::app.customers.account.profile.edit.last-name')"
                />

                <x-lord::form.control-group.error control-name="last_name" />
            </x-lord::form.control-group>

            {!! view_render_event('bagisto.lord.customers.account.profile.edit_form_controls.last_name.after') !!}

            <!-- Email -->
            <x-lord::form.control-group>
                <x-lord::form.control-group.label class="required">
                    @lang('lord::app.customers.account.profile.edit.email')
                </x-lord::form.control-group.label>

                <x-lord::form.control-group.control
                    type="text"
                    name="email"
                    rules="required|email"
                    :value="old('email') ?? $customer->email"
                    :label="trans('lord::app.customers.account.profile.edit.email')"
                    :placeholder="trans('lord::app.customers.account.profile.edit.email')"
                />

                <x-lord::form.control-group.error control-name="email" />
            </x-lord::form.control-group>

            {!! view_render_event('bagisto.lord.customers.account.profile.edit_form_controls.email.after') !!}

            <!-- Phone -->
            <x-lord::form.control-group>
                <x-lord::form.control-group.label class="required">
                    @lang('lord::app.customers.account.profile.edit.phone')
                </x-lord::form.control-group.label>

                <x-lord::form.control-group.control
                    type="text"
                    name="phone"
                    rules="required|phone"
                    :value="old('phone') ?? $customer->phone"
                    :label="trans('lord::app.customers.account.profile.edit.phone')"
                    :placeholder="trans('lord::app.customers.account.profile.edit.phone')"
                />

                <x-lord::form.control-group.error control-name="phone" />
            </x-lord::form.control-group>

            {!! view_render_event('bagisto.lord.customers.account.profile.edit_form_controls.phone.after') !!}

            <!-- Gender -->
            <x-lord::form.control-group>
                <x-lord::form.control-group.label class="required">
                    @lang('lord::app.customers.account.profile.edit.gender')
                </x-lord::form.control-group.label>

                <x-lord::form.control-group.control
                    type="select"
                    class="mb-3"
                    name="gender"
                    rules="required"
                    :value="old('gender') ?? $customer->gender"
                    :aria-label="trans('lord::app.customers.account.profile.edit.select-gender')"
                    :label="trans('lord::app.customers.account.profile.edit.gender')"
                >
                    <option value="Other">
                        @lang('lord::app.customers.account.profile.edit.other')
                    </option>

                    <option value="Male">
                        @lang('lord::app.customers.account.profile.edit.male')
                    </option>

                    <option value="Female">
                        @lang('lord::app.customers.account.profile.edit.female')
                    </option>
                </x-lord::form.control-group.control>

                <x-lord::form.control-group.error control-name="gender" />
            </x-lord::form.control-group>

            {!! view_render_event('bagisto.lord.customers.account.profile.edit_form_controls.gender.after') !!}

            <!-- DOB -->
            <x-lord::form.control-group>
                <x-lord::form.control-group.label>
                    @lang('lord::app.customers.account.profile.edit.dob')
                </x-lord::form.control-group.label>

                <x-lord::form.control-group.control
                    type="date"
                    name="date_of_birth"
                    :value="old('date_of_birth') ?? $customer->date_of_birth"
                    :label="trans('lord::app.customers.account.profile.edit.dob')"
                    :placeholder="trans('lord::app.customers.account.profile.edit.dob')"
                />

                <x-lord::form.control-group.error control-name="date_of_birth" />
            </x-lord::form.control-group>

            {!! view_render_event('bagisto.lord.customers.account.profile.edit_form_controls.date_of_birth.after') !!}

            <!-- Current Password -->
            <x-lord::form.control-group>
                <x-lord::form.control-group.label>
                    @lang('lord::app.customers.account.profile.edit.current-password')
                </x-lord::form.control-group.label>

                <x-lord::form.control-group.control
                    type="password"
                    name="current_password"
                    value=""
                    :label="trans('lord::app.customers.account.profile.edit.current-password')"
                    :placeholder="trans('lord::app.customers.account.profile.edit.current-password')"
                />

                <x-lord::form.control-group.error control-name="current_password" />
            </x-lord::form.control-group>

            {!! view_render_event('bagisto.lord.customers.account.profile.edit_form_controls.old_password.after') !!}

            <!-- New Password -->
            <x-lord::form.control-group>
                <x-lord::form.control-group.label>
                    @lang('lord::app.customers.account.profile.edit.new-password')
                </x-lord::form.control-group.label>

                <x-lord::form.control-group.control
                    type="password"
                    name="new_password"
                    value=""
                    :label="trans('lord::app.customers.account.profile.edit.new-password')"
                    :placeholder="trans('lord::app.customers.account.profile.edit.new-password')"
                />

                <x-lord::form.control-group.error control-name="new_password" />
            </x-lord::form.control-group>

            {!! view_render_event('bagisto.lord.customers.account.profile.edit_form_controls.new_password.after') !!}

            <!-- New Password Confirmation -->
            <x-lord::form.control-group>
                <x-lord::form.control-group.label>
                    @lang('lord::app.customers.account.profile.edit.confirm-password')
                </x-lord::form.control-group.label>

                <x-lord::form.control-group.control
                    type="password"
                    name="new_password_confirmation"
                    rules="confirmed:@new_password"
                    value=""
                    :label="trans('lord::app.customers.account.profile.edit.confirm-password')"
                    :placeholder="trans('lord::app.customers.account.profile.edit.confirm-password')"
                />

                <x-lord::form.control-group.error control-name="new_password_confirmation" />
            </x-lord::form.control-group>

            {!! view_render_event('bagisto.lord.customers.account.profile.edit_form_controls.new_password_confirmation.after') !!}

            <div class="mb-4 flex select-none items-center gap-1.5">
                <input
                    type="checkbox"
                    name="subscribed_to_news_letter"
                    id="is-subscribed"
                    class="peer hidden"
                    @checked($customer->subscribed_to_news_letter)
                />

                <label
                    class="icon-uncheck peer-checked:icon-check-box cursor-pointer text-2xl text-navyBlue peer-checked:text-navyBlue"
                    for="is-subscribed"
                ></label>

                <label
                    class="cursor-pointer select-none text-base text-zinc-500 max-md:text-sm ltr:pl-0 rtl:pr-0"
                    for="is-subscribed"
                >
                    @lang('lord::app.customers.account.profile.edit.subscribe-to-newsletter')
                </label>
            </div>

            <button
                type="submit"
                class="primary-button m-0 block rounded-2xl px-11 py-3 text-center text-base max-md:w-full max-md:max-w-full max-md:rounded-lg max-md:py-1.5"
            >
                @lang('lord::app.customers.account.profile.edit.save')
            </button>

            {!! view_render_event('bagisto.lord.customers.account.profile.edit_form_controls.after', ['customer' => $customer]) !!}

        </x-lord::form>

        {!! view_render_event('bagisto.lord.customers.account.profile.edit.after', ['customer' => $customer]) !!}

    </div>
</x-lord::layouts.account>
