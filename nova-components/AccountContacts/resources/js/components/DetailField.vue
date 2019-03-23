<template>
    <div v-if="field.value.customer_id">

        <div class="flex border-b border-40">
            <div class="w-1/4 py-4">
                <h4 class="font-normal text-80">
                    <b> {{field.name}} </b>
                </h4>
            </div>
            <div class="w-3/4 py-4">
                <p class="text-90">
                    {{ field.value.customer_name }}
                </p>
            </div>
        </div>

        <div class="flex border-b border-40">
            <div class="w-1/4 py-4">
                <h4 class="font-normal text-80">
                    Days Before Delivery
                    <br>
                    To Receive Reminder
                </h4>
            </div>
            <div class="w-3/4 py-4">
                <p class="text-90">
                    {{ field.value.days_before_delivery }}
                </p>
            </div>
        </div>

        <div class="flex border-b border-40">
            <div class="w-1/4 py-4">
                <h4 class="font-normal text-80">
                    Receive Re-Order Reminders?
                </h4>
            </div>
            <div class="w-3/4 py-4">
                <p class="text-90">
                    <span class="inline-block rounded-full w-2 h-2 mr-1 " :class="field.value.reminder ? 'bg-success' : 'bg-warning'"></span>
                    {{ field.value.reminder ? 'Yes' : 'No'}}
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
}
</script>
