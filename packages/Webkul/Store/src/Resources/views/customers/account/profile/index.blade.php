<x-store::layouts.account>
    {{-- Page Title --}}
    <x-slot:title>
        @lang('store::app.customers.account.profile.title')
    </x-slot>

    {{-- Breadcrumbs --}}
    @section('breadcrumbs')
        <x-store::breadcrumbs name="profile"></x-store::breadcrumbs>
    @endSection

    <div class="flex justify-between items-center">
        <h2 class="text-[26px] font-medium">
            @lang('store::app.customers.account.profile.title')
        </h2>

        <a
            href="{{ route('store.customers.account.profile.edit') }}"
            class="secondary-button py-[12px] px-[20px] border-[#E9E9E9] font-normal"
        >
            @lang('store::app.customers.account.profile.edit')
        </a>
    </div>

    {{-- Profile Information --}}
    <div class="grid grid-cols-1 gap-y-[25px] mt-[30px]">
        <div class="grid grid-cols-[2fr_3fr] w-full px-[30px] py-[12px] border-b-[1px] border-[#E9E9E9]">
            <p class="text-[14px] font-medium">
                @lang('store::app.customers.account.profile.first-name')
            </p>

            <p class="text-[14px] text-[#6E6E6E] font-medium">
                {{ $customer->first_name }}
            </p>
        </div>

        <div class="grid grid-cols-[2fr_3fr] w-full px-[30px] py-[12px] border-b-[1px] border-[#E9E9E9]">
            <p class="text-[14px] font-medium">
                @lang('store::app.customers.account.profile.last-name')
            </p>

            <p class="text-[14px] font-medium text-[#6E6E6E]">
                {{ $customer->last_name }}
            </p>
        </div>

        <div class="grid grid-cols-[2fr_3fr] w-full px-[30px] py-[12px] border-b-[1px] border-[#E9E9E9]">
            <p class="text-[14px] font-medium">
                @lang('store::app.customers.account.profile.gender')
            </p>

            <p class="text-[14px] text-[#6E6E6E] font-medium">
                {{ $customer->gender ?? '-'}}
            </p>
        </div>

        <div class="grid grid-cols-[2fr_3fr] w-full px-[30px] py-[12px] border-b-[1px] border-[#E9E9E9]">
            <p class="text-[14px] font-medium">
                @lang('store::app.customers.account.profile.dob')
            </p>

            <p class="text-[14px] text-[#6E6E6E] font-medium">
                {{ $customer->date_of_birth ?? '-' }}
            </p>
        </div>

        <div class="grid grid-cols-[2fr_3fr] w-full px-[30px] py-[12px] border-b-[1px] border-[#E9E9E9]">
            <p class="text-[14px] font-medium">
                @lang('store::app.customers.account.profile.email')
            </p>

            <p class="text-[14px] text-[#6E6E6E] font-medium">
                {{ $customer->email }}
            </p>
        </div>

        {!! view_render_event('bagisto.store.customers.account.profile.delete.before') !!}

        {{-- Profile Delete modal --}}
        <x-store::modal>
            <x-slot:toggle>
                <div
                    class="primary-button py-[11px] px-[43px] rounded-[18px]"
                >
                    @lang('store::app.customers.account.profile.delete-profile')
                </div>
            </x-slot:toggle>

            <x-slot:header>
                <h2 class="text-[25px] font-medium max-sm:text-[22px]">
                    @lang('store::app.customers.account.profile.enter-password')
                </h2>
            </x-slot:header>

            <x-slot:content>
                <x-store::form
                    action="{{ route('store.customers.account.profile.destroy') }}"
                >
                    <x-store::form.control-group>
                        <div class="p-[30px] bg-white">
                            <x-store::form.control-group.control
                                type="password"
                                name="password"
                                class="py-[20px] px-[25px]"
                                rules="required"
                                placeholder="Enter your password"
                            />

                            <x-store::form.control-group.error
                                class=" text-left"
                                control-name="password"
                            >
                            </x-store::form.control-group.error>
                        </div>
                    </x-store::form.control-group>

                    <div class="p-[30px] bg-white mt-[20px]">
                        <button
                            type="submit"
                            class="primary-button flex py-[11px] px-[43px] rounded-[18px] max-sm:text-[14px] max-sm:px-[25px]"
                        >
                            @lang('store::app.customers.account.profile.delete')
                        </button>
                    </div>
                </x-store::form>
            </x-slot:content>
        </x-store::modal>

        {!! view_render_event('bagisto.store.customers.account.profile.delete.after') !!}

    </div>
</x-store::layouts.account>
