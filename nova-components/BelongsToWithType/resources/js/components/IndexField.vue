<template>
    <span>{{field.value.user.label}}</span>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
}
</script>
