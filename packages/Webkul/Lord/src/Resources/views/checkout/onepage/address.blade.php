{!! view_render_event('bagisto.lord.checkout.onepage.address.before') !!}

<!-- Accordion Blade Component -->
<x-lord::accordion class="mb-7 mt-8 overflow-hidden rounded-xl !border-b-0 max-md:mb-0 max-md:mt-0 max-md:rounded-lg max-md:!border-none max-md:!bg-gray-100">
    <!-- Accordion Header Component Slot -->
    <x-slot:header class="!p-0 max-md:!mb-0 max-md:rounded-t-md max-md:!p-3 max-md:text-sm max-md:font-medium max-sm:!p-2">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-medium max-md:text-base">
                @lang('lord::app.checkout.onepage.address.title')
            </h2>
        </div>
    </x-slot>

    <!-- Accordion Content Component Slot -->
    <x-slot:content class="mt-8 !p-0 max-md:mt-0 max-md:rounded-t-none max-md:border max-md:border-t-0 max-md:!p-4">
        <!-- If the customer is guest -->
        <template v-if="cart.is_guest">
            @include('lord::checkout.onepage.address.guest')
        </template>

        <!-- If the customer is logged in -->
        <template v-else>
            @include('lord::checkout.onepage.address.customer')
        </template>
    </x-slot:content>
</x-lord::accordion>

{!! view_render_event('bagisto.lord.checkout.onepage.address.after') !!}