{!! view_render_event('bagisto.lord.layout.header.before') !!}

@if(core()->getCurrentChannel()->locales()->count() > 1 || core()->getCurrentChannel()->currencies()->count() > 1 )
    <div class="max-lg:hidden">
        <x-lord::layouts.header.desktop.top />
    </div>
@endif

<header class="shadow-gray sticky top-0 z-10 bg-blue-500 shadow-sm max-lg:shadow-none">
    <x-lord::layouts.header.desktop />

    <x-lord::layouts.header.mobile />
</header>

{!! view_render_event('bagisto.lord.layout.header.after') !!}
