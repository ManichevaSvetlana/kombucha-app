<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <notifications group="errors" position="bottom left"/>
            <label class="inline-block text-80 pt-2 leading-tight">
                Customer Name
            </label> <br>
            <small>Start to type a name or email address, and field will be populated with the Customer name.</small>
            <br>
            <input
                    :id="field.name + '_customer_name'"
                    type="text"
                    class="w-full form-control form-input form-input-bordered"
                    :class="errorClasses"
                    placeholder="Customer Name"
                    v-model="contact.customer_name"
                    @input="getCustomer"
                    :style="contact.customer_id ? 'border-color: #00ff5e' : ''"
            />
            <input
                    :id="field.name"
                    type="text"
                    v-model="value"
                    style="display: none"
            />
            <br>
            <br>
            <label class="inline-block text-80 pt-2 leading-tight">
                Days Before Delivery To Receive Reminder
            </label> <br>
            <small>Number of Days before delivery day the customer receives a text/email order reminder.</small>
            <br>
            <input
                    :id="field.name + '_days_before_delivery'"
                    type="number"
                    class="w-full form-control form-input form-input-bordered"
                    :class="errorClasses"
                    placeholder="Days Before Delivery To Receive Reminder"
                    v-model="contact.days_before_delivery"
                    @input="setValue('days_before_delivery')"
            />
            <br>
            <br>
            <label class="inline-block text-80 pt-2 leading-tight">
                Receive Re-Order Reminders?
            </label> <br>
            <input
                    :id="field.name + '_reminder'"
                    type="checkbox"
                    :class="errorClasses"
                    v-model="contact.reminder"
                    @change="setValue('reminder')"
            />
        </template>
    </default-field>
</template>

<script>
    import {FormField, HandlesValidationErrors} from 'laravel-nova'

    export default {
        mixins: [FormField, HandlesValidationErrors],

        props: ['resourceName', 'resourceId', 'field'],

        data() {
            return {
                contact: {customer_id: '', customer_name: '', reminder: true, days_before_delivery: ''}
            }
        },

        methods: {
            /*
             * Set the initial, internal value for the field.
             */
            setInitialValue() {
                this.contact = this.field.value || this.contact;
                this.value = JSON.stringify(this.contact);
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

            getCustomer() {
                this.contact.customer_id = '';
                if (this.contact.customer_name.length > 2) {
                    axios.get('/customers/' + this.contact.customer_name + '/find').then(response => {
                        if (!response.data.result) {
                            if (response.data.status == 0) this.$notify({
                                type: 'warn',
                                group: 'errors',
                                title: response.data.message,
                                duration: 1000,
                                speed: 1000
                            });
                        }
                        else {
                            this.contact.customer_name = response.data.customer.name;
                            this.contact.customer_id = response.data.customer.id;
                            this.value = JSON.stringify(this.contact);
                        }
                    })
                }
            },

            setValue(element)
            {
                this.value = JSON.stringify(this.contact);
            }
        },
    }
</script>
