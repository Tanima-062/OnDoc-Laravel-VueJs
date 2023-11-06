<template>
<svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg" v-if="status == 'inactive'">
<circle cx="5" cy="5" r="5" fill="#DC5555"/>
</svg>

<svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg" v-if="status == 'active'">
<circle cx="5" cy="5" r="5" fill="#83BC73"/>
</svg>
<svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg" v-if="status == 'pending'">
<circle cx="5" cy="5" r="5" fill="#eec429"/>
</svg>


</template>

<script setup>
    defineProps({
        status: {
            type: String,
            required: true,
        }
    })
</script>
