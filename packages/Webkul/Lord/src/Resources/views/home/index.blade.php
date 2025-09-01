@php
    $channel = core()->getCurrentChannel();
@endphp

<!-- SEO Meta Content -->
@push ('meta')
    <meta
        name="title"
        content="{{ $channel->home_seo['meta_title'] ?? '' }}"
    />

    <meta
        name="description"
        content="{{ $channel->home_seo['meta_description'] ?? '' }}"
    />

    <meta
        name="keywords"
        content="{{ $channel->home_seo['meta_keywords'] ?? '' }}"
    />
@endPush

<x-lord::layouts>
    <!-- Page Title -->
    <x-slot:title>
        {{  $channel->home_seo['meta_title'] ?? '' }}
    </x-slot>
    
    <!-- Loop over the theme customization -->
    @foreach ($customizations as $customization)
        @php ($data = $customization->options) @endphp

        <!-- Static content -->
        @switch ($customization->type)
            @case ($customization::IMAGE_CAROUSEL)
                <!-- Image Carousel -->
                <x-lord::carousel
                    :options="$data"
                    aria-label="{{ trans('lord::app.home.index.image-carousel') }}"
                />

                @break
            @case ($customization::STATIC_CONTENT)
                <!-- push style -->
                @if (! empty($data['css']))
                    @push ('styles')
                        <style>
                            {{ $data['css'] }}
                        </style>
                    @endpush
                @endif

                <!-- render html -->
                @if (! empty($data['html']))
                    {!! $data['html'] !!}
                @endif

                @break
            @case ($customization::CATEGORY_CAROUSEL)
                <!-- Categories carousel -->
                <x-lord::categories.carousel
                    :title="$data['title'] ?? ''"
                    :src="route('lord.api.categories.index', $data['filters'] ?? [])"
                    :navigation-link="route('lord.home.index')"
                    aria-label="{{ trans('lord::app.home.index.categories-carousel') }}"
                />

                @break
            @case ($customization::PRODUCT_CAROUSEL)
                <!-- Product Carousel -->
                <x-lord::products.carousel
                    :title="$data['title'] ?? ''"
                    :src="route('lord.api.products.index', $data['filters'] ?? [])"
                    :navigation-link="route('lord.search.index', $data['filters'] ?? [])"
                    aria-label="{{ trans('lord::app.home.index.product-carousel') }}"
                />

                @break
        @endswitch
    @endforeach
</x-lord::layouts>
