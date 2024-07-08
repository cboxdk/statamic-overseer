<template>
    <div>
        <template v-if="user">
            {{ user.name }}
        </template>
        <template v-else="user">
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
        user: Object,
        impersonator: Object,
    },

}
</script>