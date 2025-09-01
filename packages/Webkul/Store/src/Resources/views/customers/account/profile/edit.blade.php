<x-store::layouts.account>
    {{-- Page Title --}}
    <x-slot:title>
        @lang('store::app.customers.account.profile.edit-profile')
    </x-slot>

    {{-- Breadcrumbs --}}
    @section('breadcrumbs')
        <x-store::breadcrumbs name="profile.edit"></x-store::breadcrumbs>
    @endSection

    <h2 class="text-[26px] font-medium">
        @lang('store::app.customers.account.profile.edit-profile')
    </h2>

    {!! view_render_event('bagisto.store.customers.account.profile.edit.before', ['customer' => $customer]) !!}

    {{-- Profile Edit Form --}}
    <x-store::form
        :action="route('store.customers.account.profile.store')"
        class="rounded mt-[30px]"
        enctype="multipart/form-data"
    >

        {!! view_render_event('bagisto.store.customers.account.profile.edit_form_controls.before', ['customer' => $customer]) !!}

        <x-store::form.control-group class="mt-[15px]">
            <x-store::form.control-group.control
                type="image"
                name="image[]"
                class="!p-0 rounded-[12px] text-gray-700 mb-0"
                :label="trans('Image')"
                :is-multiple="false"
                accepted-types="image/*"
                :src="$customer->image_url"
            >
            </x-store::form.control-group.control>

            <x-store::form.control-group.error
                control-name="image[]"
            >
            </x-store::form.control-group.error>
        </x-store::form.control-group>

        {!! view_render_event('bagisto.store.customers.account.profile.edit_form_controls.image.after') !!}

        <x-store::form.control-group class="mb-4">
            <x-store::form.control-group.label class="required">
                @lang('store::app.customers.account.profile.first-name')
            </x-store::form.control-group.label>

            <x-store::form.control-group.control
                type="text"
                name="first_name"
                :value="old('first_name') ?? $customer->first_name"
                rules="required"
                :label="trans('store::app.customers.account.profile.first-name')"
                :placeholder="trans('store::app.customers.account.profile.first-name')"
            >
            </x-store::form.control-group.control>

            <x-store::form.control-group.error
                control-name="first_name"
            >
            </x-store::form.control-group.error>
        </x-store::form.control-group>

        {!! view_render_event('bagisto.store.customers.account.profile.edit_form_controls.first_name.after') !!}

        <x-store::form.control-group class="mb-4">
            <x-store::form.control-group.label class="required">
                @lang('store::app.customers.account.profile.last-name')
            </x-store::form.control-group.label>

            <x-store::form.control-group.control
                type="text"
                name="last_name"
                :value="old('last_name') ?? $customer->last_name"
                rules="required"
                :label="trans('store::app.customers.account.profile.last-name')"
                :placeholder="trans('store::app.customers.account.profile.last-name')"
            >
            </x-store::form.control-group.control>

            <x-store::form.control-group.error
                control-name="last_name"
            >
            </x-store::form.control-group.error>
        </x-store::form.control-group>

        {!! view_render_event('bagisto.store.customers.account.profile.edit_form_controls.last_name.after') !!}

        <x-store::form.control-group class="mb-4">
            <x-store::form.control-group.label class="required">
                @lang('store::app.customers.account.profile.email')
            </x-store::form.control-group.label>

            <x-store::form.control-group.control
                type="text"
                name="email"
                :value="old('email') ?? $customer->email"
                rules="required|email"
                :label="trans('store::app.customers.account.profile.email')"
                :placeholder="trans('store::app.customers.account.profile.email')"
            >
            </x-store::form.control-group.control>

            <x-store::form.control-group.error
                control-name="email"
            >
            </x-store::form.control-group.error>
        </x-store::form.control-group>

        {!! view_render_event('bagisto.store.customers.account.profile.edit_form_controls.email.after') !!}

        <x-store::form.control-group class="mb-4">
            <x-store::form.control-group.label class="required">
                @lang('store::app.customers.account.profile.phone')
            </x-store::form.control-group.label>

            <x-store::form.control-group.control
                type="text"
                name="phone"
                :value="old('phone') ?? $customer->phone"
                rules="required|phone"
                :label="trans('store::app.customers.account.profile.phone')"
                :placeholder="trans('store::app.customers.account.profile.phone')"
            >
            </x-store::form.control-group.control>

            <x-store::form.control-group.error
                control-name="phone"
            >
            </x-store::form.control-group.error>
        </x-store::form.control-group>

        {!! view_render_event('bagisto.store.customers.account.profile.edit_form_controls.phone.after') !!}

        <x-store::form.control-group class="mb-4">
            <x-store::form.control-group.label class="required">
                @lang('store::app.customers.account.profile.gender')
            </x-store::form.control-group.label>

            <x-store::form.control-group.control
                type="select"
                name="gender"
                :value="old('gender') ?? $customer->gender"
                class="mb-3"
                rules="required"
                aria-label="Select Gender"
                :label="trans('store::app.customers.account.profile.gender')"
            >
                <option value="Other">@lang('store::app.customers.account.profile.other')</option>
                <option value="Male">@lang('store::app.customers.account.profile.male')</option>
                <option value="Female">@lang('store::app.customers.account.profile.female')</option>
            </x-store::form.control-group.control>

            <x-store::form.control-group.error
                control-name="gender"
            >
            </x-store::form.control-group.error>
        </x-store::form.control-group>

        {!! view_render_event('bagisto.store.customers.account.profile.edit_form_controls.gender.after') !!}

        <x-store::form.control-group class="mb-4">
            <x-store::form.control-group.label>
                @lang('store::app.customers.account.profile.dob')
            </x-store::form.control-group.label>

            <x-store::form.control-group.control
                type="date"
                name="date_of_birth"
                :value="old('date_of_birth') ?? $customer->date_of_birth"
                :label="trans('store::app.customers.account.profile.dob')"
                :placeholder="trans('store::app.customers.account.profile.dob')"
            >
            </x-store::form.control-group.control>

            <x-store::form.control-group.error
                control-name="date_of_birth"
            >
            </x-store::form.control-group.error>
        </x-store::form.control-group>

        {!! view_render_event('bagisto.store.customers.account.profile.edit_form_controls.date_of_birth.after') !!}

        <x-store::form.control-group class="mb-4">
            <x-store::form.control-group.label>
                @lang('store::app.customers.account.profile.current-password')
            </x-store::form.control-group.label>

            <x-store::form.control-group.control
                type="password"
                name="current_password"
                value=""
                :label="trans('store::app.customers.account.profile.current-password')"
                :placeholder="trans('store::app.customers.account.profile.current-password')"
            >
            </x-store::form.control-group.control>

            <x-store::form.control-group.error
                control-name="current_password"
            >
            </x-store::form.control-group.error>
        </x-store::form.control-group>

        {!! view_render_event('bagisto.store.customers.account.profile.edit_form_controls.old_password.after') !!}

        <x-store::form.control-group class="mb-4">
            <x-store::form.control-group.label>
                @lang('store::app.customers.account.profile.new-password')
            </x-store::form.control-group.label>

            <x-store::form.control-group.control
                type="password"
                name="new_password"
                value=""
                :label="trans('store::app.customers.account.profile.new-password')"
                :placeholder="trans('store::app.customers.account.profile.new-password')"
            >
            </x-store::form.control-group.control>

            <x-store::form.control-group.error
                control-name="new_password"
            >
            </x-store::form.control-group.error>
        </x-store::form.control-group>

        {!! view_render_event('bagisto.store.customers.account.profile.edit_form_controls.new_password.after') !!}

        <x-store::form.control-group class="mb-4">
            <x-store::form.control-group.label>
                @lang('store::app.customers.account.profile.confirm-password')
            </x-store::form.control-group.label>

            <x-store::form.control-group.control
                type="password"
                name="new_password_confirmation"
                value=""
                rules="confirmed:@new_password"
                :label="trans('store::app.customers.account.profile.confirm-password')"
                :placeholder="trans('store::app.customers.account.profile.confirm-password')"
            >
            </x-store::form.control-group.control>

            <x-store::form.control-group.error
                control-name="new_password_confirmation"
            >
            </x-store::form.control-group.error>
        </x-store::form.control-group>

        {!! view_render_event('bagisto.store.customers.account.profile.edit_form_controls.new_password_confirmation.after') !!}

        <div class="select-none items-center flex gap-[6px] mb-4">
            <input
                type="checkbox"
                name="subscribed_to_news_letter"
                id="is-subscribed"
                class="hidden peer"
            />

            <label
                class="icon-uncheck text-[24px] text-navyBlue peer-checked:icon-check-box peer-checked:text-navyBlue cursor-pointer"
                for="is-subscribed"
            ></label>

            <label
                class="text-[16] text-[#6E6E6E] max-sm:text-[12px] pl-0 select-none cursor-pointer"
                for="is-subscribed"
            >
                @lang('store::app.customers.account.profile.subscribe-to-newsletter')
            </label>
        </div>

        <button
            type="submit"
            class="primary-button block m-0 w-max py-[11px] px-[43px] rounded-[18px] text-base text-center"
        >
            @lang('store::app.customers.account.profile.save')
        </button>

        {!! view_render_event('bagisto.store.customers.account.profile.edit_form_controls.after', ['customer' => $customer]) !!}

    </x-store::form>

    {!! view_render_event('bagisto.store.customers.account.profile.edit.after', ['customer' => $customer]) !!}
    
</x-store::layouts.account>
