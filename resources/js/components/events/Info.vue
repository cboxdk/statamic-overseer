<template>

    <div>
        <template v-if="event">
            <template v-if="event.type === 'request'">
                <span class="font-semibold">Request</span> /
                {{ event.event.method }} /
                {{ event.event.response_code }} /
                {{ event.event.response_cache_hit ? 'Hit' : 'Miss' }}
                <div class="text-2xs opacity-75 overseer-max">
                    {{ urlPath(event.event.url) }}
                </div>
            </template>
            <template v-else-if="event.type === 'job'">
                <span class="font-semibold">Job</span>
                <div class="text-2xs opacity-75">{{ event.event.name }}</div>
            </template>
            <template v-else-if="event.type === 'command'">
                <span class="font-semibold">Command</span>
                <div class="text-2xs opacity-75">{{ event.event.command }}</div>
            </template>
            <template v-else-if="event.type === 'event'">
                <span class="font-semibold">Event</span>
                <div class="text-2xs opacity-75">{{ event.event.name }}</div>
            </template>
            <template v-else>
                <span class="font-semibold">Unknown</span>
                <div class="text-2xs opacity-75">—</div>
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

    methods: {

        urlPath(string) {
            const url = new URL(string);
            return url.pathname + url.search;
        },

    },

};

</script>