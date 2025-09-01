{{-- SEO Meta Content --}}
@push('meta')
    <meta name="description" content="@lang('store::app.checkout.onepage.index.checkout')"/>

    <meta name="keywords" content="@lang('store::app.checkout.onepage.index.checkout')"/>
@endPush

<x-store::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    {{-- Page Title --}}
    <x-slot:title>
        @lang('store::app.checkout.onepage.index.checkout')
    </x-slot>

    {{-- Page Header --}}
    <div class="lex flex-wrap">
        <div class="w-full flex justify-between px-[60px] py-[17px] border border-t-0 border-b-[1px] border-l-0 border-r-0 max-lg:px-[30px] max-sm:px-[15px]">
            <div class="flex items-center gap-x-[54px] max-[1180px]:gap-x-[35px]">
                <a
                    href="{{ route('store.home.index') }}"
                    class="flex min-h-[30px]"
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
        </div>
    </div>

    <div class="container px-[60px] max-lg:px-[30px] max-sm:px-[15px]">
        {{-- Breadcrumbs --}}
        <x-store::breadcrumbs name="checkout"></x-store::breadcrumbs>

        <v-checkout>
            {{-- Shimmer Effect --}}
            <x-store::shimmer.checkout.onepage/>
        </v-checkout>
    </div>

    @pushOnce('scripts')
        <script type="text/x-template" id="v-checkout-template">
            <div class="grid grid-cols-[1fr_auto] gap-[30px] max-lg:grid-cols-[1fr]">
                <div    
                    class="overflow-y-auto"
                    ref="scrollBottom"
                >
                    @include('store::checkout.onepage.addresses.index')

                    @include('store::checkout.onepage.shipping')

                    @include('store::checkout.onepage.payment')

                </div>
                
                @include('store::checkout.onepage.summary')
            </div>
        </script>

        <script type="module">
            app.component('v-checkout', {
                template: '#v-checkout-template',

                data() {
                    return {
                        cart: {},

                        isCartLoading: true,
                    }
                },

                created() {
                    this.getOrderSummary();
                }, 

                methods: {
                    getOrderSummary() {
                        this.$axios.get("{{ route('store.checkout.onepage.summary') }}")
                            .then(response => {
                                this.cart = response.data.data;

                                this.isCartLoading = false;

                                let container = this.$refs.scrollBottom;

                                if (container) {
                                    container.scrollIntoView({
                                        behavior: 'smooth',
                                        block: 'end'
                                    });
                                }
                            })
                            .catch(error => console.log(error));
                    },
                },
            });
        </script>
    @endPushOnce
</x-store::layouts>
