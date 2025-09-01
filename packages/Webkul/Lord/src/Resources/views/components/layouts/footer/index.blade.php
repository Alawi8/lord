{!! view_render_event('bagisto.lord.layout.footer.before') !!}

<!--
    The category repository is injected directly here because there is no way
    to retrieve it from the view composer, as this is an anonymous component.
-->
@inject('themeCustomizationRepository', 'Webkul\Theme\Repositories\ThemeCustomizationRepository')

<!--
    This code needs to be refactored to reduce the amount of PHP in the Blade
    template as much as possible.
-->
@php
    $channel = core()->getCurrentChannel();

    $customization = $themeCustomizationRepository->findOneWhere([
        'type'       => 'footer_links',
        'status'     => 1,
        'theme_code' => $channel->theme,
        'channel_id' => $channel->id,
    ]);
@endphp

<footer class="mt-16 bg-gray-900 relative overflow-hidden">
    <!-- Background decoration -->
    <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900"></div>
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"></div>
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse" style="animation-delay: 2s"></div>
    </div>

    <div class="relative flex justify-between gap-x-6 gap-y-8 p-[60px] max-1060:flex-col-reverse max-md:gap-5 max-md:p-8 max-sm:px-4 max-sm:py-5">
        <!-- For Desktop View -->
        <div class="flex flex-wrap items-start gap-24 max-1180:gap-6 max-1060:hidden">
            @if ($customization?->options)
                @foreach ($customization->options as $footerLinkSection)
                    <ul class="grid gap-5 text-sm">
                        @php
                            usort($footerLinkSection, function ($a, $b) {
                                return $a['sort_order'] - $b['sort_order'];
                            });
                        @endphp

                        @foreach ($footerLinkSection as $link)
                            <li>
                                <a href="{{ $link['url'] }}" class="text-gray-300 hover:text-white transition-all duration-300 hover:translate-x-1 flex items-center group">
                                    <span class="w-0 h-0.5 bg-blue-500 group-hover:w-4 transition-all duration-300 mr-0 group-hover:mr-2"></span>
                                    {{ $link['title'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            @endif
        </div>

        <!-- For Mobile view -->
        <x-lord::accordion
            :is-active="false"
            class="hidden !w-full rounded-xl border border-gray-700 bg-gray-800/50 backdrop-blur-sm max-1060:block max-sm:rounded-lg"
        >
            <x-slot:header class="rounded-t-lg bg-gray-700/50 font-medium text-gray-200 max-md:p-2.5 max-sm:px-3 max-sm:py-2 max-sm:text-sm">
                @lang('lord::app.components.layouts.footer.footer-content')
            </x-slot>

            <x-slot:content class="flex justify-between !bg-gray-800/30 !p-4">
                @if ($customization?->options)
                    @foreach ($customization->options as $footerLinkSection)
                        <ul class="grid gap-5 text-sm">
                            @php
                                usort($footerLinkSection, function ($a, $b) {
                                    return $a['sort_order'] - $b['sort_order'];
                                });
                            @endphp

                            @foreach ($footerLinkSection as $link)
                                <li>
                                    <a
                                        href="{{ $link['url'] }}"
                                        class="text-sm font-medium text-gray-300 hover:text-white transition-colors duration-300 max-sm:text-xs">
                                        {{ $link['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                @endif
            </x-slot>
        </x-lord::accordion>

        {!! view_render_event('bagisto.lord.layout.footer.newsletter_subscription.before') !!}

        <!-- News Letter subscription -->
        @if (core()->getConfigData('customer.settings.newsletter.subscription'))
            <div class="grid gap-2.5">
                <p
                    class="max-w-[288px] text-3xl font-bold leading-[45px] text-white max-md:text-2xl max-sm:text-lg bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent"
                    role="heading"
                    aria-level="2"
                >
                    @lang('lord::app.components.layouts.footer.newsletter-text')
                </p>

                <p class="text-xs text-gray-400">
                    @lang('lord::app.components.layouts.footer.subscribe-stay-touch')
                </p>

                <div>
                    <x-lord::form
                        :action="route('lord.subscription.store')"
                        class="mt-2.5 rounded max-sm:mt-0"
                    >
                        <div class="relative w-full group">
                            <x-lord::form.control-group.control
                                type="email"
                                class="block w-[420px] max-w-full rounded-xl border border-gray-600 bg-gray-800/50 backdrop-blur-sm px-5 py-4 text-base text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300 max-1060:w-full max-md:p-3.5 max-sm:mb-0 max-sm:rounded-lg max-sm:p-2 max-sm:text-sm"
                                name="email"
                                rules="required|email"
                                label="Email"
                                :aria-label="trans('lord::app.components.layouts.footer.email')"
                                placeholder="email@example.com"
                            />
    
                            <x-lord::form.control-group.error control-name="email" />
    
                            <button
                                type="submit"
                                class="absolute top-1.5 flex w-max items-center rounded-xl bg-gradient-to-r from-blue-500 to-purple-600 px-7 py-2.5 font-medium text-white hover:from-blue-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl max-md:top-1 max-md:px-5 max-md:text-xs max-sm:mt-0 max-sm:rounded-lg max-sm:px-4 max-sm:py-2 ltr:right-2 rtl:left-2"
                            >
                                @lang('lord::app.components.layouts.footer.subscribe')
                            </button>
                        </div>
                    </x-lord::form>
                </div>
            </div>
        @endif

        {!! view_render_event('bagisto.lord.layout.footer.newsletter_subscription.after') !!}
    </div>

    <div class="relative flex justify-between bg-gray-800/50 backdrop-blur-sm border-t border-gray-700 px-[60px] py-3.5 max-md:justify-center max-sm:px-5">
        {!! view_render_event('bagisto.lord.layout.footer.footer_text.before') !!}

        <p class="text-sm text-gray-400 max-md:text-center">
            @lang('lord::app.components.layouts.footer.footer-text', ['current_year'=> date('Y') ])
        </p>

        {!! view_render_event('bagisto.lord.layout.footer.footer_text.after') !!}
    </div>
</footer>

{!! view_render_event('bagisto.lord.layout.footer.after') !!}