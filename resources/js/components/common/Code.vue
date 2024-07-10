<template>
    <div :class="{
        'overseer-code rounded bg-gray-300 p-3 relative w-full': true,
    }">
        <pre class="font-mono text-xs">{{ code }}</pre>
    </div>
</template>
<script>
export default {

    props: {
        code: String,
    },

}
</script>