<!-- Checkout Login Vue JS Component -->
<v-checkout-login>
    <div class="flex items-center">
        <span class="cursor-pointer text-base font-medium text-blue-700">
            @lang('lord::app.checkout.login.title')
        </span>
    </div>
</v-checkout-login>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-checkout-login-template"
    >
        <div>
            <div class="flex items-center">
                <span
                    class="cursor-pointer text-base font-medium text-blue-700"
                    role="button"
                    @click="$refs.loginModel.open()"
                >
                    @lang('lord::app.checkout.login.title')
                </span>
            </div>

            <!-- Login Form -->
            <x-lord::form
                v-slot="{ meta, errors, handleSubmit }"
                as="div"
            >
                {!! view_render_event('bagisto.lord.checkout.login.before') !!}

                <!-- Login form -->
                <form @submit="handleSubmit($event, login)">
                    {!! view_render_event('bagisto.lord.checkout.login.form_controls.before') !!}

                    <!-- Login modal -->
                    <x-lord::modal ref="loginModel">
                        <!-- Modal Header -->
                        <x-slot:header>
                            <h2 class="text-2xl font-medium max-md:text-base">
                                @lang('lord::app.checkout.login.title')
                            </h2>
                        </x-slot>

                        <!-- Modal Content -->
                        <x-slot:content>
                            <!-- Email -->
                            <x-lord::form.control-group>
                                <x-lord::form.control-group.label class="required">
                                    @lang('lord::app.checkout.login.email')
                                </x-lord::form.control-group.label>

                                <x-lord::form.control-group.control
                                    type="email"
                                    class="px-6 py-4"
                                    name="email"
                                    rules="required|email"
                                    :label="trans('lord::app.checkout.login.email')"
                                    placeholder="email@example.com"
                                    :aria-label="trans('lord::app.checkout.login.email')"
                                    aria-required="true"
                                />

                                <x-lord::form.control-group.error control-name="email" />
                            </x-lord::form.control-group>

                            <!-- Password -->
                            <x-lord::form.control-group class="!mb-0">
                                <x-lord::form.control-group.label class="required">
                                    @lang('lord::app.checkout.login.password')
                                </x-lord::form.control-group.label>

                                <x-lord::form.control-group.control
                                    type="password"
                                    class="px-6 py-4"
                                    id="password"
                                    name="password"
                                    rules="required|min:6"
                                    :label="trans('lord::app.checkout.login.password')"
                                    :placeholder="trans('lord::app.checkout.login.password')"
                                    :aria-label="trans('lord::app.checkout.login.password')"
                                    aria-required="true"
                                />

                                <x-lord::form.control-group.error control-name="password" />
                            </x-lord::form.control-group>
                        </x-slot>

                        <!-- Modal Footer -->
                        <x-slot:footer>
                            <div class="flex flex-wrap items-center gap-4">
                                <x-lord::button
                                    class="primary-button max-w-none flex-auto rounded-2xl px-11 py-3 max-md:rounded-lg max-md:py-1.5"
                                    :title="trans('lord::app.checkout.login.title')"
                                    ::loading="isStoring"
                                    ::disabled="isStoring"
                                />
                            </div>
                        </x-slot>
                    </x-lord::modal>

                    {!! view_render_event('bagisto.lord.checkout.login.form_controls.after') !!}
                </form>
            </x-lord::form>

            {!! view_render_event('bagisto.lord.checkout.login.after') !!}
        </div>
    </script>

    <script type="module">
        app.component('v-checkout-login', {
            template: '#v-checkout-login-template',
            
            data() {
                return {
                    isStoring: false,
                }
            },

            methods: {
                login(params, { resetForm }) {
                    this.isStoring = true;

                    this.$axios.post("{{ route('lord.api.customers.session.create') }}", params)
                        .then((response) => {
                            this.isStoring = false;

                            window.location.reload();
                        })
                        .catch((error) => {
                            this.isStoring = false;

                            if (error.response.status == 422) {
                                setErrors(error.response.data.errors);

                                return;
                            }

                            this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });
                        });
                },
            }
        })
    </script>
@endPushOnce