<x-lord::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('lord::app.customers.account.gdpr.index.title')
    </x-slot>
    
    <!-- Breadcrumbs -->
    @if ((core()->getConfigData('general.general.breadcrumbs.lord')))
        @section('breadcrumbs')
            <x-lord::breadcrumbs name="addresses" />
        @endSection
    @endif

    <div class="max-md:hidden">
        <x-lord::layouts.account.navigation />
    </div>

    <div class="mx-4 flex-auto">
        <div class="flex items-center justify-between gap-4 max-md:flex-wrap">
            <div class="flex items-center">
                <!-- Back Button -->
                <a
                    class="grid md:hidden"
                    href="{{ route('lord.customers.account.index') }}"
                >
                    <span class="icon-arrow-left rtl:icon-arrow-right text-2xl"></span>
                </a>
    
                <h2 class="text-2xl font-medium max-md:text-xl max-sm:text-base ltr:ml-2.5 md:ltr:ml-0 rtl:mr-2.5 md:rtl:mr-0">
                    @lang('lord::app.customers.account.gdpr.index.title')
                </h2>
            </div>

            <div class="flex gap-4">
                <a 
                    href="{{ route('lord.customers.account.gdpr.pdf-view') }}"
                    class="secondary-button border-zinc-200 px-5 py-3 font-normal max-md:rounded-lg max-md:py-2 max-sm:py-1.5 max-sm:text-sm"
                >
                    @lang('lord::app.customers.account.gdpr.index.pdf') 
                </a>

                <a
                    href="{{ route('lord.customers.account.gdpr.html-view') }}"
                    target="_blank"
                    class="secondary-button border-zinc-200 px-5 py-3 font-normal max-md:rounded-lg max-md:py-2 max-sm:py-1.5 max-sm:text-sm"
                >
                    @lang('lord::app.customers.account.gdpr.index.html') 
                </a>
    
                <button
                    class="primary-button border-zinc-200 px-5 py-3 font-normal max-md:rounded-lg max-md:py-2 max-sm:py-1.5 max-sm:text-sm"
                    @click="$refs.loginModel.open()"
                >
                    @lang('lord::app.customers.account.gdpr.index.create-btn') 
                </button>
            </div>
        </div>

        {!! view_render_event('bagisto.lord.customers.account.gdpr.list.before') !!}

        <!-- For Desktop View -->
        <div class="max-md:hidden">
            <x-lord::datagrid :src="route('lord.customers.account.gdpr.index')" />
        </div>

        <!-- For Mobile View -->
        <div class="md:hidden">
            <x-lord::datagrid :src="route('lord.customers.account.gdpr.index')">
                <!-- Datagrid Header -->
                <template #header="{
                    isLoading,
                    available,
                    applied,
                    selectAll,
                    sort,
                    performAction
                }">
                    <div class="hidden"></div>
                </template>

                <template #body="{
                    isLoading,
                    available,
                    applied,
                    selectAll,
                    sort,
                    performAction
                }">
                    <template v-if="isLoading">
                        <x-lord::shimmer.datagrid.table.body />
                    </template>
    
                    <template v-else>
                        <template v-for="record in available.records">
                            <div class="w-full p-4 border rounded-md transition-all hover:bg-gray-50 [&>*]:border-0 mb-4 last:mb-0">
                                <div class="flex items-center justify-between">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex gap-2">
                                            <p class="text-sm text-neutral-500">
                                                @lang('lord::app.customers.account.gdpr.index.datagrid.id'): 
                                            </p>
                                            
                                            <p class="text-sm">
                                                @{{ record.id }}
                                            </p>
                                        </div>

                                        <div class="flex gap-2">
                                            <p class="text-sm text-neutral-500">
                                                @lang('lord::app.customers.account.gdpr.index.datagrid.type'): 
                                            </p>
                                            
                                            <p class="text-sm">
                                                @{{ record.type }}
                                            </p>
                                        </div>

                                        <div class="flex gap-2">
                                            <p class="text-sm text-neutral-500">
                                                @lang('lord::app.customers.account.gdpr.index.datagrid.date'): 
                                            </p>
                                            
                                            <p class="text-sm">
                                                @{{ record.created_at }}
                                            </p>
                                        </div>

                                        <div class="flex gap-2">
                                            <p class="text-sm text-neutral-500">
                                                @lang('lord::app.customers.account.gdpr.index.datagrid.message'): 
                                            </p>
                                            
                                            <p class="text-sm">
                                                @{{ record.message }}
                                            </p>
                                        </div>
                                        
                                        <div class="flex gap-2">
                                            <p class="text-sm text-neutral-500">
                                                @lang('lord::app.customers.account.gdpr.index.datagrid.status'): 
                                            </p>
                                            
                                            <p v-html="record.status"></p>
                                        </div>
                                    </div>

                                    <p v-html="record.revoke"></p>
                                </div>
                            </div>
                        </template>
                    </template>
                </template>
            </x-lord::datagrid>
        </div>

        {!! view_render_event('bagisto.lord.customers.account.gdpr.list.after') !!}
    </div>

    <!-- Login Form -->
    <x-lord::form action="{{ route('lord.customers.account.gdpr.store') }}">
        {!! view_render_event('bagisto.lord.customers.account.gdpr.request.form_controls.before') !!}

        <x-lord::modal ref="loginModel">
            <!-- Modal Header -->
            <x-slot:header>
                <h2 class="text-2xl">
                    @lang('lord::app.customers.account.gdpr.index.modal.title')
                </h2>
            </x-slot>

            <!-- Modal Content -->
            <x-slot:content>
                <!-- Type -->
                <x-lord::form.control-group>
                    <x-lord::form.control-group.label class="required">
                        @lang('lord::app.customers.account.gdpr.index.modal.type.title')
                    </x-lord::form.control-group.label>

                    <x-lord::form.control-group.control
                        type="select"
                        name="type"
                        rules="required"
                    >
                        <option
                            value=""
                            disabled
                            selected
                        >
                            @lang('lord::app.customers.account.gdpr.index.modal.type.choose')
                        </option>

                        <option value="update">
                            @lang('lord::app.customers.account.gdpr.index.modal.type.update')
                        </option>

                        <option value="delete">
                            @lang('lord::app.customers.account.gdpr.index.modal.type.delete')
                        </option>
                    </x-lord::form.control-group.control>

                    <x-lord::form.control-group.error control-name="type" />
                </x-lord::form.control-group>

                <!-- Message -->
                <x-lord::form.control-group class="!mb-0">
                    <x-lord::form.control-group.label class="required">
                        @lang('lord::app.customers.account.gdpr.index.modal.message')
                    </x-lord::form.control-group.label>

                    <x-lord::form.control-group.control
                        type="textarea"
                        name="message"
                        rules="required"
                    />

                    <x-lord::form.control-group.error control-name="message" />
                </x-lord::form.control-group>
            </x-slot>

            <!-- Modal Footer -->
            <x-slot:footer>
                <div class="flex flex-wrap items-center gap-4">
                    <x-lord::button
                        class="primary-button max-w-none flex-auto rounded-2xl px-11 py-3 max-md:rounded-lg max-md:py-1.5"
                        :title="trans('lord::app.customers.account.gdpr.index.modal.save')"
                        ::loading="isStoring"
                        ::disabled="isStoring"
                    />
                </div>
            </x-slot>
        </x-lord::modal>

        {!! view_render_event('bagisto.lord.customers.account.gdpr.request.form_controls.after') !!}
    </x-lord::form>
</x-lord::layouts.account>
