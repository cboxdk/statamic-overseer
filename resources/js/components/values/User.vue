<template>
    <div>
        <template v-if="value">
            {{ value.name }}
        </template>
        <template v-else>
            Unknown
        </template>
        <template v-if="impersonator">
            <div class="text-2xs opacity-75">
                Impersonated by {{ impersonator.name }}
            </div>
        </template>
    </div>
</template>
<script>
export default {

    props: {
        value: Object,
        impersonator: Object,
    },

}
</script>