<x-store::layouts.account>
    {{-- Page Title --}}
    <x-slot:title>
        @lang('store::app.customers.account.orders.title')
    </x-slot>

    {{-- Breadcrumbs --}}
    @section('breadcrumbs')
        <x-store::breadcrumbs name="orders"></x-store::breadcrumbs>
    @endSection

    <div class="flex justify-between items-center">
        <div class="">
            <h2 class="text-[26px] font-medium">
                @lang('store::app.customers.account.orders.title')
            </h2>
        </div>
    </div>

    {!! view_render_event('bagisto.store.customers.account.orders.list.before') !!}

    <x-store::datagrid :src="route('store.customers.account.orders.index')"></x-store::datagrid>
    
    {!! view_render_event('bagisto.store.customers.account.orders.list.after') !!}

</x-store::layouts.account>
