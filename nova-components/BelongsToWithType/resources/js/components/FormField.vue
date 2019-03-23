<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <!-- Choose User type -->
            <select class="form-control form-select mb-3 w-full" v-model="user.user_type" @change="clearUsers">
                <option value="user" selected="selected">User</option>
                <option value="customer" selected="selected">Customer</option>
                <option value="sales_rep" selected="selected">Sales Representative</option>
            </select>

            <br><br>

            <!-- Search the User -->
            <v-select :options="options" :filterable="false" id="user_request" v-model="user.user"
                      @search="getUsers" @input="setUser" style="border: 1px solid #bacad6;" class="w-full form-control form-input">

                <template slot="no-options">
                    Type to search the User..
                </template>

            </v-select>

        </template>
    </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    data(){
        return{
            user: {user: {}, user_type: 'user'},
            options: []
        }
    },

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.user = this.field.value || this.user;
            this.value = JSON.stringify(this.user);
            if(this.user.user) this.options.push(this.user.user);
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

        /**
         * Clear users array after changing role type.
         */
        clearUsers() {
            this.options = [];
            this.user.user = {};
        },

        /**
         * Clear users array after changing role type.
         */
        setUser() {
            this.value = JSON.stringify(this.user);
        },

        /**
         * Get Users by name || email || phone_number.
         */
        getUsers(search, loading) {
            let request = search;
            if (request.length > 1) {
                loading(true);
                axios.get('/users?' + this.user.user_type + '=' + request).then(response => {
                    this.options = response.data;
                    loading(false);
                }).catch(e => {
                    alert(e.message);
                    console.log(e);
                    loading(false);
                });
            }
        },
    },
}
</script>

<style>
    #user_request .dropdown-toggle{
        border: none;
    }
    .loader {
        height: 90vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .circle {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #d1d1d1;
    }
    .circle:not(:last-child) {
        margin-right: 10px;
    }
    .circle-1 {
        animation: moveup 0.9s infinite;
    }
    .circle-2 {
        animation: moveup 0.9s 0.3s infinite;
    }
    .circle-3 {
        animation: moveup 0.9s 0.6s infinite;
    }
    @keyframes moveup {
        0% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
        100% {
            transform: translateY(0);
        }
    }

</style>
