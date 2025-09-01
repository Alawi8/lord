<v-book-slots :bookingProduct = "{{ $bookingProduct }}" />

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-book-slots-template"
    >
        <div>
            <x-lord::form.control-group.label class="required">
                {{ $title  ?? trans('lord::app.products.view.type.booking.slots.book-an-appointment') }}
            </x-lord::form.control-group.label>

            <div class="grid grid-cols-2 gap-x-4">
                <!-- Select Date -->
                <x-lord::form.control-group class="!mb-0">
                    <x-lord::form.control-group.label class="hidden">
                        @lang('lord::app.products.view.type.booking.slots.date')
                    </x-lord::form.control-group.label>
                    
                    <x-lord::form.control-group.control
                        type="date"
                        class="py-4"
                        name="booking[date]"
                        rules="required"
                        :label="trans('lord::app.products.view.type.booking.slots.date')"
                        :placeholder="trans('YYYY-MM-DD')"
                        data-min-date="today"
                        ::disable="disabledDates"                       
                        @change="getAvailableSlots"
                    />

                    <x-lord::form.control-group.error control-name="booking[date]" />
                </x-lord::form.control-group>

                <!-- Select Slots -->
                <x-lord::form.control-group class="!mb-0">
                    <x-lord::form.control-group.label class="hidden">
                        @lang('lord::app.products.view.type.booking.slots.title')
                    </x-lord::form.control-group.label>

                    <x-lord::form.control-group.control
                        type="select"
                        class="py-4"
                        name="booking[slot]"
                        rules="required"
                        v-model="selectedSlot"
                        :label="trans('lord::app.products.view.type.booking.slots.title')"
                        :placeholder="trans('lord::app.products.view.type.booking.slots.title')"
                    >
                        <option value="">
                            @lang('lord::app.products.view.type.booking.slots.select-slot')
                        </option>
                        
                        <option v-if="! slots?.length">
                            @lang('lord::app.products.view.type.booking.slots.no-slots-available')
                        </option>

                        <option
                            v-for="slot in slots"
                            :value="slot.timestamp"
                            v-text="slot.from + ' - ' + slot.to"
                        >
                        </option>
                    </x-lord::form.control-group.control>

                    <x-lord::form.control-group.error control-name="booking[slot]" />
                </x-lord::form.control-group>
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-book-slots', {
            template: '#v-book-slots-template',

            props: ['bookingProduct', 'title'],

            data() {
                return {
                    slots: [],

                    selectedSlot: '',
                }
            },

            created() {
                this.minAllowedDate = this.calculateMinDate();
            },

            computed: {
                preventDays() {
                    return this.bookingProduct?.table_slot?.prevent_scheduling_before || 0;
                },

                minAllowedDate() {
                    const today = new Date();

                    today.setDate(today.getDate() + parseInt(this.preventDays, 10));
                    
                    return today.toISOString().split('T')[0];
                },

                disabledDates() {
                    const dates = [];
                    
                    const today = new Date();
                    
                    const endDate = new Date(this.minAllowedDate);

                    while (today < endDate) {
                        dates.push(today.toISOString().split('T')[0]);
                        
                        today.setDate(today.getDate() + 1);
                    }

                    return dates;
                }
            },

            methods: {
                calculateMinDate() {
                    let today = new Date();
                    
                    let preventDays = parseInt(this.preventDays) || 0;
                    
                    today.setDate(today.getDate() + preventDays);

                    return today.toISOString().split('T')[0]; 
                },
        
                getAvailableSlots(params) {
                    let date = params.target.value;

                    this.$axios.get(`{{ route('lord.booking-product.slots.index', '') }}/${this.bookingProduct.id}`, {
                        params: { date }
                    })
                        .then((response) => {
                            this.slots = response.data.data;

                            this.selectedSlot = '';
                        })
                        .catch(error => {
                            if (error.response.status == 422) {
                                setErrors(error.response.data.errors);
                            }
                        });
                }
            }
        });
    </script>
@endpushOnce
