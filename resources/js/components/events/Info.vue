<template>

    <div>
        <template v-if="event">
            <template v-if="event.type === 'request'">
                <span class="font-semibold">Request</span> /
                {{ event.event.method }} /
                {{ event.event.response_code }} /
                {{ response_cache_hit ? 'Hit' : 'Miss' }}
                <div class="overseer-info opacity-75">{{ event.event.url }}</div>
            </template>
            <template v-else-if="event.type === 'job'">
                <span class="font-semibold">Job</span>
                <div class="overseer-info opacity-75">{{ event.event.name }}</div>
            </template>
            <template v-else-if="event.type === 'command'">
                <span class="font-semibold">Command</span>
                <div class="overseer-info opacity-75">{{ event.event.command }}</div>
            </template>
            <template v-else>
                <span class="font-semibold">Event</span>
                <div class="overseer-info opacity-75">{{ event.event.event }}</div>
            </template>
        </template>
        <template v-else>
            Unknown
        </template>
    </div>

</template>
<script>

export default {

    props: {
        event: {
            type: Object,
        },
    },

};

</script>
<style>
    .overseer-info {
        max-width: 40ch;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
</style>