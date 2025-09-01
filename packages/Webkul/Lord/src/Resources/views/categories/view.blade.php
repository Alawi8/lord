<!-- SEO Meta Content -->
@push('meta')
    <meta
        name="description"
        content="{{ trim($category->meta_description) != "" ? $category->meta_description : \Illuminate\Support\Str::limit(strip_tags($category->description), 120, '') }}"
    />

    <meta
        name="keywords"
        content="{{ $category->meta_keywords }}"
    />

    @if (core()->getConfigData('catalog.rich_snippets.categories.enable'))
        <script type="application/ld+json">
            {!! app('Webkul\Product\Helpers\SEO')->getCategoryJsonLd($category) !!}
        </script>
    @endif
@endPush

<x-lord::layouts>
    <!-- Page Title -->
    <x-slot:title>
        {{ trim($category->meta_title) != "" ? $category->meta_title : $category->name }}
    </x-slot>

    {!! view_render_event('bagisto.lord.categories.view.banner_path.before') !!}

    <!-- Hero Image -->
    @if ($category->banner_path)
        <div class="container mt-8 px-[60px] max-lg:px-8 max-md:mt-4 max-md:px-4">
            <div class="relative group overflow-hidden rounded-2xl shadow-2xl">
                <x-lord::media.images.lazy
                    class="aspect-[4/1] max-h-full max-w-full object-cover transition-transform duration-700 group-hover:scale-105"
                    src="{{ $category->banner_url }}"
                    alt="{{ $category->name }}"
                    width="1320"
                    height="300"
                />
                <!-- Overlay gradient -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                <!-- Category name overlay -->
                <div class="absolute bottom-6 left-8 text-white">
                    <h1 class="text-4xl font-bold mb-2 drop-shadow-lg max-md:text-2xl">{{ $category->name }}</h1>
                    @if($category->description)
                        <p class="text-lg opacity-90 max-w-2xl max-md:text-sm">{{ \Illuminate\Support\Str::limit(strip_tags($category->description), 100) }}</p>
                    @endif
                </div>
            </div>
        </div>
    @endif

    {!! view_render_event('bagisto.lord.categories.view.banner_path.after') !!}

    {!! view_render_event('bagisto.lord.categories.view.description.before') !!}

    @if (in_array($category->display_mode, [null, 'description_only', 'products_and_description']))
        @if ($category->description)
            <div class="container mt-8 px-[60px] max-lg:px-8 max-md:mt-6 max-md:px-4">
                <div class="prose prose-lg max-w-none bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl p-8 border border-gray-200 shadow-sm max-md:p-6 max-md:text-sm max-sm:text-xs">
                    {!! $category->description !!}
                </div>
            </div>
        @endif
    @endif

    {!! view_render_event('bagisto.lord.categories.view.description.after') !!}

    @if (in_array($category->display_mode, [null, 'products_only', 'products_and_description']))
        <!-- Category Vue Component -->
        <v-category>
            <!-- Category Shimmer Effect -->
            <x-lord::shimmer.categories.view />
        </v-category>
    @endif

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-category-template"
        >
            <div class="container px-[60px] max-lg:px-8 max-md:px-4">
                <div class="flex items-start gap-10 max-lg:gap-5 md:mt-10">
                    <!-- Product Listing Filters -->
                    @include('lord::categories.filters')

                    <!-- Product Listing Container -->
                    <div class="flex-1">
                        <!-- Desktop Product Listing Toolbar -->
                        <div class="max-md:hidden">
                            @include('lord::categories.toolbar')
                        </div>

                        <!-- Product List Card Container -->
                        <div
                            class="mt-8 grid grid-cols-1 gap-8"
                            v-if="(filters.toolbar.applied.mode ?? filters.toolbar.default.mode) === 'list'"
                        >
                            <!-- Product Card Shimmer Effect -->
                            <template v-if="isLoading">
                                <x-lord::shimmer.products.cards.list count="12" />
                            </template>

                            <!-- Product Card Listing -->
                            {!! view_render_event('bagisto.lord.categories.view.list.product_card.before') !!}

                            <template v-else>
                                <template v-if="products.length">
                                    <div class="space-y-6">
                                        <x-lord::products.card
                                            ::mode="'list'"
                                            v-for="product in products"
                                            class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-blue-200 transform hover:-translate-y-1"
                                        />
                                    </div>
                                </template>

                                <!-- Empty Products Container -->
                                <template v-else>
                                    <div class="m-auto grid w-full place-content-center items-center justify-items-center py-32 text-center">
                                        <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-full p-12 mb-8">
                                            <img
                                                class="max-md:h-[100px] max-md:w-[100px] opacity-70"
                                                src="{{ bagisto_asset('images/thank-you.png') }}"
                                                alt="@lang('lord::app.categories.view.empty')"
                                            />
                                        </div>

                                        <h3 class="text-2xl font-semibold text-gray-700 mb-2 max-md:text-lg">لا توجد منتجات</h3>
                                        <p class="text-lg text-gray-500 max-md:text-sm" role="heading">
                                            @lang('lord::app.categories.view.empty')
                                        </p>
                                    </div>
                                </template>
                            </template>

                            {!! view_render_event('bagisto.lord.categories.view.list.product_card.after') !!}
                        </div>

                        <!-- Product Grid Card Container -->
                        <div v-else class="mt-8 max-md:mt-5">
                            <!-- Product Card Shimmer Effect -->
                            <template v-if="isLoading">
                                <div class="grid grid-cols-3 gap-8 max-1060:grid-cols-2 max-md:justify-items-center max-md:gap-x-4">
                                    <x-lord::shimmer.products.cards.grid count="12" />
                                </div>
                            </template>

                            {!! view_render_event('bagisto.lord.categories.view.grid.product_card.before') !!}

                            <!-- Product Card Listing -->
                            <template v-else>
                                <template v-if="products.length">
                                    <div class="grid grid-cols-3 gap-8 max-1060:grid-cols-2 max-md:justify-items-center max-md:gap-6">
                                        <x-lord::products.card
                                            ::mode="'grid'"
                                            v-for="product in products"
                                            class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-blue-200 transform hover:-translate-y-2 overflow-hidden"
                                        />
                                    </div>
                                </template>

                                <!-- Empty Products Container -->
                                <template v-else>
                                    <div class="m-auto grid w-full place-content-center items-center justify-items-center py-32 text-center">
                                        <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-full p-12 mb-8 shadow-inner">
                                            <img
                                                class="max-md:h-[100px] max-md:w-[100px] opacity-70"
                                                src="{{ bagisto_asset('images/thank-you.png') }}"
                                                alt="@lang('lord::app.categories.view.empty')"
                                            />
                                        </div>

                                        <h3 class="text-2xl font-semibold text-gray-700 mb-2 max-md:text-lg">لا توجد منتجات</h3>
                                        <p class="text-lg text-gray-500 max-md:text-sm" role="heading">
                                            @lang('lord::app.categories.view.empty')
                                        </p>
                                        <div class="mt-6">
                                            <a href="{{ route('lord.home.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                                </svg>
                                                العودة للرئيسية
                                            </a>
                                        </div>
                                    </div>
                                </template>
                            </template>

                            {!! view_render_event('bagisto.lord.categories.view.grid.product_card.after') !!}
                        </div>

                        {!! view_render_event('bagisto.lord.categories.view.load_more_button.before') !!}

                        <!-- Load More Button -->
                        <div class="flex justify-center mt-16">
                            <button
                                class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-2xl hover:from-blue-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 hover:shadow-xl max-md:rounded-xl max-sm:mt-8 max-sm:px-6 max-sm:py-3 max-sm:text-sm"
                                @click="loadMoreProducts"
                                v-if="links.next && ! loader"
                            >
                                <span class="mr-2">@lang('lord::app.categories.view.load-more')</span>
                                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <button
                                v-else-if="links.next"
                                class="relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-gray-400 to-gray-500 text-white font-semibold rounded-2xl max-md:rounded-xl max-md:py-3 max-sm:mt-8 max-sm:px-6 max-sm:py-3"
                                disabled
                            >
                                <!-- Spinner -->
                                <svg class="animate-spin h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="mr-3">جاري التحميل...</span>
                            </button>
                        </div>

                        {!! view_render_event('bagisto.lord.categories.view.grid.load_more_button.after') !!}
                    </div>
                </div>
            </div>
        </script>

        <script type="module">
            app.component('v-category', {
                template: '#v-category-template',

                data() {
                    return {
                        isMobile: window.innerWidth <= 767,

                        isLoading: true,

                        isDrawerActive: {
                            toolbar: false,

                            filter: false,
                        },

                        filters: {
                            toolbar: {
                                default: {},

                                applied: {},
                            },

                            filter: {},
                        },

                        products: [],

                        links: {},

                        loader: false,
                    }
                },

                computed: {
                    queryParams() {
                        let queryParams = Object.assign({}, this.filters.filter, this.filters.toolbar.applied);

                        return this.removeJsonEmptyValues(queryParams);
                    },

                    queryString() {
                        return this.jsonToQueryString(this.queryParams);
                    },
                },

                watch: {
                    queryParams() {
                        this.getProducts();
                    },

                    queryString() {
                        window.history.pushState({}, '', '?' + this.queryString);
                    },
                },

                methods: {
                    setFilters(type, filters) {
                        this.filters[type] = filters;
                    },

                    clearFilters(type, filters) {
                        this.filters[type] = {};
                    },

                    getProducts() {
                        this.isDrawerActive = {
                            toolbar: false,

                            filter: false,
                        };

                        document.body.style.overflow ='scroll';

                        this.$axios.get("{{ route('lord.api.products.index', ['category_id' => $category->id]) }}", {
                            params: this.queryParams
                        })
                            .then(response => {
                                this.isLoading = false;

                                this.products = response.data.data;

                                this.links = response.data.links;
                            }).catch(error => {
                                console.log(error);
                            });
                    },

                    loadMoreProducts() {
                        if (! this.links.next) {
                            return;
                        }

                        this.loader = true;

                        this.$axios.get(this.links.next)
                            .then(response => {
                                this.loader = false;

                                this.products = [...this.products, ...response.data.data];

                                this.links = response.data.links;
                            }).catch(error => {
                                console.log(error);
                            });
                    },

                    removeJsonEmptyValues(params) {
                        Object.keys(params).forEach(function (key) {
                            if ((! params[key] && params[key] !== undefined)) {
                                delete params[key];
                            }

                            if (Array.isArray(params[key])) {
                                params[key] = params[key].join(',');
                            }
                        });

                        return params;
                    },

                    jsonToQueryString(params) {
                        let parameters = new URLSearchParams();

                        for (const key in params) {
                            parameters.append(key, params[key]);
                        }

                        return parameters.toString();
                    }
                },
            });
        </script>
    @endPushOnce
</x-lord::layouts>