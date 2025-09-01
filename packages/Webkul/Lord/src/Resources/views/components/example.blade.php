<!-- default product listing -->
<x-lord::products.carousel
    title="Men's Collections"
    :src="route('lord.api.products.index')"
    :navigation-link="route('lord.home.index')"
/>

<!-- category product listing -->
<x-lord::products.carousel
    title="Men's Collections"
    :src="route('lord.api.products.index', ['category_id' => 1])"
    :navigation-link="route('lord.home.index')"
/>

<!-- featured product listing -->
<x-lord::products.carousel
    title="Men's Collections"
    :src="route('lord.api.products.index', ['featured' => 1])"
    :navigation-link="route('lord.home.index')"
/>

<!-- new product listing -->
<x-lord::products.carousel
    title="Men's Collections"
    :src="route('lord.api.products.index', ['new' => 1])"
    :navigation-link="route('lord.home.index')"
/>

<!-- basic/traditional form  -->
<x-lord::form action="">
     
    <!-- Type E-mail -->
    <x-lord::form.control-group>
        <x-lord::form.control-group.label>
            Email
        </x-lord::form.control-group.label>

        <x-lord::form.control-group.control
            type="email"
            name="email"
            rules="required|email"
            value=""
            label="Email"
            placeholder="email@example.com"
        />

        <x-lord::form.control-group.error control-name="email" />
    </x-lord::form.control-group>

    <!-- Type Date -->
    <x-lord::form.control-group>
        <x-lord::form.control-group.label>
            Date of Birth
        </x-lord::form.control-group.label>

        <x-lord::form.control-group.control
            type="date"
            id="dob"
            name="date_of_birth" 
            value=""
            label="Date of Birth"
            placeholder="Date of Birth"
        />

        <x-lord::form.control-group.error control-name="date_of_birth" />
    </x-lord::form.control-group>

    <!-- Type Date Time -->
    <x-lord::form.control-group>
        <x-lord::form.control-group.label>
            Start Timing
        </x-lord::form.control-group.label>

        <x-lord::form.control-group.control
            type="datetime"
            id="starts_from"
            name="starts_from"
            value=""
            label="Start Timing"
            placeholder="Start Timing"
        />

        <x-lord::form.control-group.error control-name="starts_from" />
    </x-lord::form.control-group>

    <!-- Type Text -->
    <x-lord::form.control-group>
        <x-lord::form.control-group.label class="required">
            @lang('name')
        </x-lord::form.control-group.label>

        <x-lord::form.control-group.control
            type="text"
            name="name"
            rules="required"
            :value=""
            label="name"
            placeholder="name"
        />

        <x-lord::form.control-group.error control-name="name" />
    </x-lord::form.control-group>

    <!-- Type Select -->
    <x-lord::form.control-group>
        <x-lord::form.control-group.label>
            @lang('lord::app.catalog.families.create.column')
        </x-lord::form.control-group.label>

        <x-lord::form.control-group.control
            type="select"
            name="column"
            rules="required"
            :label="trans('lord::app.catalog.families.create.column')"
        >
            <!-- Default Option -->
            <option value="">
                @lang('lord::app.catalog.families.create.select-group')
            </option>

            <option value="1">
                @lang('lord::app.catalog.families.create.main-column')
            </option>

            <option value="2">
                @lang('lord::app.catalog.families.create.right-column')
            </option>
        </x-lord::form.control-group.control>

        <x-lord::form.control-group.error control-name="column" />
    </x-lord::form.control-group>

    <!--Type Checkbox -->
    <x-lord::form.control-group>
        <x-lord::form.control-group.control
            type="checkbox"
            id="is_unique"
            name="is_unique"
            value="1"
            for="is_unique"
        />

        <x-lord::form.control-group.label for="is_unique">
            @lang('lord::app.catalog.attributes.edit.is-unique')
        </x-lord::form.control-group.label>
    </x-lord::form.control-group>

    <!--Type Radio -->
    <x-lord::form.control-group>
        <x-lord::form.control-group.control
            type="radio"
            id="is_unique"
            name="is_unique"
            value="1"
            for="is_unique"
        />

        <x-lord::form.control-group.label for="is_unique" />
            @lang('lord::app.catalog.attributes.edit.is-unique')
        </x-lord::form.control-group.label>
    </x-lord::form.control-group>

    <!-- Type Tinymce -->
    <x-lord::form.control-group>
        <x-lord::form.control-group.label>
            Description
        </x-lord::form.control-group.label>

        <x-lord::form.control-group.control
            type="textarea"
            class="description"
            name="description"
            rules="required"
            :value=""
            label="Description"
            :tinymce="true"
        />

        <x-lord::form.control-group.error control-name="description" />
    </x-lord::form.control-group>
</x-lord::form>

<!-- customized/ajax form -->
<x-lord::form
    v-slot="{ meta, errors, handleSubmit }"
    as="div"
>
    <form @submit="handleSubmit($event, callMethodInComponent)">
        <x-lord::form.control-group>
            <x-lord::form.control-group.label>
                Email
            </x-lord::form.control-group.label>

            <x-lord::form.control-group.control
                type="email"
                name="email"
                rules="required"
                :value="old('email')"
                label="Email"
                placeholder="email@example.com"
            />

            <x-lord::form.control-group.error control-name="email" />
        </x-lord::form.control-group>

        <button>Submit</button>
    </form>
</x-lord::form>

<!-- Shimmer -->
<x-lord::shimmer.checkout.onepage.payment-method />

<!-- tabs -->
<x-lord::tabs>
    <x-lord::tabs.item
        title="Tab 1"
    >
        Tab 1 Content
    </x-lord::tabs.item>

    <x-lord::tabs.item
        title="Tab 2"
    >
        Tab 2 Content
    </x-lord::tabs.item>
</x-lord::tabs>

<!-- accordion -->
<x-lord::accordion>
    <x-slot:header>
        Accordion Header
    </x-slot>

    <x-slot:content>
        Accordion Content
    </x-slot>
</x-lord::accordion>

<!-- modal -->
<x-lord::modal>
    <x-slot:toggle>
        Modal Toggle
    </x-slot>

    <x-slot:header>
        Modal Header
    </x-slot>

    <x-slot:content>
        Modal Content
    </x-slot>
</x-lord::modal>

<!-- drawer -->
<x-lord::drawer>
    <x-slot:toggle>
        Drawer Toggle
    </x-slot>

    <x-slot:header>
        Drawer Header
    </x-slot>

    <x-slot:content>
        Drawer Content
    </x-slot>
</x-lord::drawer>

<!-- dropdown -->
<x-lord::dropdown>
    <x-slot:toggle>
        Toogle
    </x-slot>

    <x-slot:content>
        Content
    </x-slot>
</x-lord::dropdown>

<!--Range Slider -->
<x-lord::range-slider
    ::key="refreshKey"
    default-type="price"
    ::default-allowed-max-range="allowedMaxPrice"
    ::default-min-range="minRange"
    ::default-max-range="maxRange"
    @change-range="setPriceRange($event)"
/>

<!-- Image/Media -->
<x-lord::media.images.lazy
    class="after:content-[' '] relative min-w-[250px] bg-zinc-100 transition-all duration-300 after:block after:pb-[calc(100%+9px)] group-hover:scale-105"
    ::src="product.base_image.medium_image_url"
    ::key="product.id"
    ::index="product.id"
    width="291"
    height="300"
    ::alt="product.name"
/>

<!-- Page Title -->
<x-slot:title>
    @lang('Title')
</x-slot>

<!-- Page Layout -->
<x-lord::layouts>
   Page Content 
</x-lord::layouts>

<!-- label class -->

<div class="label-canceled"></div>

<div class="label-info"></div>

<div class="label-completed"></div>

<div class="label-closed"></div>

<div class="label-processing"></div>

<div class="label-pending"></div>