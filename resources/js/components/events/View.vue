<template>

    <div class="overseer-split border-t border-gray-400">
        <div class="border-r border-gray-300 bg-gray-100 p-4">
            <div class="overseer-panel">
                <field display="Date & Time">
                    {{ $moment(event.recorded_at).format('YYYY-MM-DD HH:mm:ss.SSSS') }}
                </field>
                <field display="Type">
                    {{ typeDisplay }}
                    <div v-if="badge" class="badge-sm bg-blue-500">
                        {{ badge }}
                    </div>
                </field>
            </div>
        </div>
        <event-request-panel v-if="event.type === 'request'" :event="event" />
        <event-command-panel v-else-if="event.type === 'command'" :event="event" />
        <event-job-panel v-else-if="event.type === 'job'" :event="event" />
        <event-event-panel v-else-if="event.type === 'event'" :event="event" />
        <event-query-panel v-else-if="event.type === 'query'" :event="event" />
        <event-default-panel v-else :event="event" />
    </div>

</template>

<script>
import Field from '../common/Field.vue';
import EventCommandPanel from '../events/CommandPanel.vue';
import EventDefaultPanel from '../events/DefaultPanel.vue';
import EventEventPanel from '../events/EventPanel.vue';
import EventJobPanel from '../events/JobPanel.vue';
import EventRequestPanel from '../events/RequestPanel.vue';
import EventQueryPanel from '../events/QueryPanel.vue';

export default {

    components: {
        Field,
        EventCommandPanel,
        EventDefaultPanel,
        EventEventPanel,
        EventJobPanel,
        EventRequestPanel,
        EventQueryPanel,
    },

    props: {
        event: {
            type: Object,
        },
        badge: {
            type: String,
        },
    },

    computed: {

        typeDisplay() {
            const labels = {
                request: 'Request',
                command: 'Command',
                job: 'Job',
                event: 'Event',
                query: 'Query',
            };
            return labels[this.event.type] || this.event.type;
        }

    }

};

</script>