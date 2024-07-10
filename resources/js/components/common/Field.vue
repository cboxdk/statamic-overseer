<template>
    <div :class="`overseer-field overseer-${width || 'full'}`">
        <div class="overseer-label">{{ display }}</div>
        <div class="overseer-value">
            <slot></slot>
        </div>
    </div>
</template>
<script>
export default {

    props: {
        display: String,
        width: String,
    },

}
</script>