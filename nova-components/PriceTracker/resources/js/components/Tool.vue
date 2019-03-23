<template>
    <div>
        <heading class="mb-6">Price Tracker</heading>
        <div class="card overflow-hidden">
            <div>
                <div>
                    <!---->
                </div>
                <div>
                    <div class="flex border-b border-40">
                        <div class="w-1/5 py-6 px-8">
                            <label for="customer_request" class="inline-block text-80 pt-2 leading-tight">
                                <b>Customer</b>
                            </label>
                        </div>
                        <div class="py-6 px-8 w-1/2">

                        </div>
                    </div>
                </div>
                <div>
                    <div class="flex border-b border-40">
                        <div class="w-1/5 py-6 px-8">
                            <select data-testid="request-type-select" dusk="request"
                                    class="form-control form-select mb-3 w-full" v-model="requestType">
                                <option value="name" selected="selected">Name</option>
                                <option value="phone">Phone</option>
                                <option value="email">Email</option>
                            </select>
                            <div class="help-text help-text mt-2"></div>
                        </div>
                        <div class="py-6 px-8 w-1/2">
                            <v-select :options="customers" :filterable="false" id="customer_request" v-model="request"
                                      @search="getCustomers" @input="getCustomer" style="border: 1px solid #bacad6;" class="w-full form-control form-input">

                                <template slot="no-options">
                                    Type to search the Customer..
                                </template>


                            </v-select>
                            <div class="help-text help-text mt-2"></div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="flex border-b border-40">
                        <div class="w-1/5 py-6 px-8">
                            <label for="customer_request" class="inline-block text-80 pt-2 leading-tight">
                                <b>Products</b>
                            </label>
                        </div>
                        <div class="py-6 px-8 w-1/2">

                        </div>
                    </div>
                </div>
                <div v-if="!loading" v-for="product in products">
                    <div class="flex border-b border-40">
                        <div class="w-1/5 py-6 px-8">
                            <label class="inline-block text-80 pt-2 leading-tight">
                                {{product.name}}
                            </label>
                        </div>
                        <div class="py-4 px-6 w-1/2">
                            <input type="text" placeholder="Price" v-model="product.default_price"
                                   class="w-full form-control form-input form-input-bordered"> <!---->
                            <div class="help-text help-text mt-2"></div>
                        </div>
                        <div class="py-2 px-2 w-1/2">
                            <input type="checkbox" placeholder="Price" v-model="product.active" style="margin-top: 20px;"
                            >
                        </div>
                    </div>
                </div>
                <div class="loader" v-else>
                    <div class="circle circle-1"></div>
                    <div class="circle circle-2"></div>
                    <div class="circle circle-3"></div>
                </div>

                <div class="bg-30 px-8 py-4" style="text-align: right;">
                    <button class="btn btn-default btn-primary inline-flex items-center relative"
                            dusk="update-button" @click="updatePrices">
            <span class="">
            Update Prices for the Customer
            </span> <!---->
                    </button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                requestType: 'name',
                request: {},
                customers: [],
                products: [],
                currentCustomer: {},
                loading: false,
                test: 5,
                defaultProducts: {0 : {default_price: 3}, 1: {default_price: 3}}
            }
        },
        beforeCreate() {
            axios.get('/products').then(response => {
                this.products = response.data;
                this.defaultProducts = JSON.parse(JSON.stringify(response.data));
            })
        },
        created()
        {
            let path = window.location.toString().split('#')[1];
            let id = false;
            if(path && path.indexOf("customer=") + 1) {
                id = path.split('=')[1];
                if(id) this.setCustomer(id);
            }
        },
        methods: {
            getCustomers(search, loading) {
                let request = search;
                if (request.length > 1) {
                    loading(true);
                    axios.get('/customers?' + this.requestType + '=' + request).then(response => {
                        this.customers = response.data;
                        loading(false);
                    }).catch(e => {
                        alert(e.message);
                        console.log(e);
                        loading(false);
                    });
                }

            },
            getCustomer() {
                if(this.request.value) {
                    this.loading = true;
                    axios.get('/customers/' + this.request.value).then(response => {
                        this.currentCustomer = response.data;
                        this.setDefaultPrices(Object.assign({}, this.defaultProducts));
                        if(this.currentCustomer.prices && this.currentCustomer.prices.length > 0) this.setPrices(this.currentCustomer.prices);
                        window.history.pushState("", "", '#customer=' + this.currentCustomer.id);
                        this.loading = false;
                        console.log(this.currentCustomer);
                    }).catch(e => {
                        console.log(e);
                        alert(e.message);
                    });
                }
            },
            setDefaultPrices(prices)
            {
                let products = this.products;
                for(let i = 0; i < products.length; i++){
                    products[i].default_price = prices[i].default_price;
                }
            },
            setPrices(prices)
            {
                for(let i = 0; i < this.products.length; i++){
                    let index = this.getIndexById(prices, this.products[i].id);
                    if(index != -1) {
                        this.products[i].default_price = prices[index].price;
                        this.products[i].active = prices[index].active;
                    }
                }
            },
            getIndexById(array, id)
            {
                for(let i = 0; i < array.length; i++){
                    if(array[i].product_id == id) return i;
                }
                return -1;
            },
            updatePrices()
            {
                if(this.currentCustomer.id)
                {
                    this.loading = true;
                    axios.post('/prices/' + this.currentCustomer.id, {products: this.products}).then(response => {
                        this.loading = false;
                        this.$swal('Prices were updated.');
                        console.log(response.data);
                    }).catch(e => {
                        this.loading = false;
                        this.$swal(e.message);
                        console.log(e.message);
                    })
                }
            },
            setCustomer(id)
            {
                this.loading = true;
                axios.get('/customers/' + id).then(response => {
                    let customer = response.data;
                    this.customers = [{value: customer.id, label: customer.name + ' - ' + customer.email}];
                    this.requestType = 'email';
                    this.request = this.customers[0];
                    this.currentCustomer = response.data;
                    this.setDefaultPrices(Object.assign({}, this.defaultProducts));
                    if(this.currentCustomer.prices && this.currentCustomer.prices.length > 0) this.setPrices(this.currentCustomer.prices);
                    this.loading = false;
                }).catch(e => {
                    this.loading = false;
                    this.$swal(e.message);
                    console.log(e.message);
                })
            }
        }
    }
</script>

<style>
    #customer_request .dropdown-toggle{
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
