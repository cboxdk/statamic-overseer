<template>
    <div :class="{
        'overseer-badge text-white': true,
        'bg-green-500': value < 400,
        'bg-orange-500': value >= 400 && value < 500,
        'bg-red-500': value >= 500,
    }">
        {{ value }}
    </div>
</template>
<script>
export default {

    props: {
        value: Number,
    },

}
</script>