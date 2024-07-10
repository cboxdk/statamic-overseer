<template>
    <div :class="{
        'overseer-dump rounded bg-gray-800 text-white p-3 relative w-full': true,
        'overflow-hidden': !open,
        'overflow-auto': open,
    }">
        <pre class="font-mono text-xs">{{ JSON.stringify(data || null, null, 2) }}</pre>
        <button v-if="!open" @click="open = true" class="absolute inset-0"></button>
    </div>
</template>
<script>
export default {

    props: {
        data: Object,
    },

    data: function() {
        return {
            open: false,
        };
    },

}
</script>