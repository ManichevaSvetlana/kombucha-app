<template>
    <div>

        <div class="flex border-b border-40">
            <div class="w-1/4 py-4">{{field.name}}</div>
            <div class="w-3/4 py-4">
                <div style="width: 100%" v-for="product in field.value.products">
                    <div class="w-1/4 py-4">
                        <h4 class="font-normal text-80">
                            <b> {{ product.name }} </b> - {{ product.order_quantity }} items
                        </h4>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
}
</script>
