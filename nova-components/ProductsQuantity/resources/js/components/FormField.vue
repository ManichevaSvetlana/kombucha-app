<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <div style="width: 100%" v-for="product in products.products">
                <br>
                <label class="inline-block text-80 pt-2 leading-tight">
                    {{ product.name }}
                </label>
                <br>
                <input
                        :id="product.id + '_product'"
                        type="number"
                        class="w-full form-control form-input form-input-bordered"
                        v-model="product.order_quantity"
                        @change="setValue"
                />
            </div>
        </template>
    </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    data() {
        return {
            products: {products: [], json_products: ''}
        }
    },

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.products = this.field.value || this.products;
            this.value = this.products.json_products;
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.value || '')
        },

        /**
         * Update the field's internal value.
         */
        handleChange(value) {
            this.value = value
        },

        setValue()
        {
            let products = {};
            for(let i = 0; i < this.products.products.length; i++)
            {
                products[this.products.products[i].id] = this.products.products[i].order_quantity;
            }
            this.value = JSON.stringify(products);
        }
    },
}
</script>
