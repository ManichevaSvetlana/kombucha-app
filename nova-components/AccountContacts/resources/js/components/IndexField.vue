<template>
    <span>{{field.value}}</span>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
    data(){
        return{
            customer: '' // name or email address
        }
    },
    created()
    {
        console.log(this.resourceName);
        console.log(this.field);
    },
    methods:{

    }
}
</script>
