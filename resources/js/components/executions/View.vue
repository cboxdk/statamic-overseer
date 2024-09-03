<template>
    <div class="overseer-view">

        <div class="card text-sm mb-6 overseer-panel">
            <field display="ID" width="1/3">
                {{ execution.id }}
            </field>
            <field display="Date & Time" width="1/3">
                {{ $moment(execution.created_at).format('YYYY-MM-DD HH:mm:ss.SSSS') }}
            </field>
            <field display="User" width="1/3">
                <user-value :value="execution.user" :impersonator="execution.usimpersonatorer" />
            </field>
            <field display="Host & PID" width="1/3">
                <div>{{ execution.host }}</div>
                <div>{{ execution.pid }}</div>
            </field>
            <field display="Duration & Memory" width="1/3">
                <div>{{ execution.duration }} ms</div>
                <div>{{ execution.memory }} mb</div>
            </field>
            <field display="CPU User Time & System Time & Usage" width="1/3">
                <div>{{ execution.cpu_user_time.toFixed(3) }}</div>
                <div>{{ execution.cpu_system_time.toFixed(3) }}</div>
                <div>{{ execution.cpu_usage_percentage.toFixed() }}%</div>
            </field>
        </div>

        <div v-if="execution.initiator" class="card text-sm mb-6 p-0 overflow-hidden">
            <div class="bg-gray-200 px-4 py-3 flex justify-between items-end">
                <div class="font-semibold text-base">Initiator</div>
            </div>
            <event-view :event="execution.initiator" />
        </div>

        <div class="card text-sm mb-6 p-0 overflow-hidden">
            <div class="bg-gray-200 px-4 py-3 flex justify-between items-end">
                <div class="font-semibold text-base">Events</div>
                <div class="opacity-75">{{ execution.events.length }} total</div>
            </div>
            <event-view
                v-for="event in execution.events"
                :event="event"
                :badge="event.id === execution.initiator.id ? 'Initiator' : null" />
        </div>

        <div class="card text-sm mb-6 p-0 overflow-hidden">
            <div class="bg-gray-200 px-4 py-3 flex justify-between items-end">
                <div class="font-semibold text-base">Audits</div>
                <div class="opacity-75">{{ execution.audits.length }} total</div>
            </div>
            <div v-for="audit in execution.audits" class="overseer-split border-t border-gray-400">
                <div class="border-r border-gray-300 bg-gray-100 p-4">
                    <div class="overseer-panel">
                        <field display="Date & Time">
                            {{ $moment(audit.created_at).format('YYYY-MM-DD HH:mm:ss.SSSS') }}
                        </field>
                    </div>
                </div>
                <div class="overseer-panel p-4">
                    <field display="Message" width="1/2">
                        {{ audit.message }}
                    </field>
                    <field display="Subject" width="1/2">
                        <audit-subject :audit="audit" />
                    </field>
                    <field display="Properties">
                        <dump :data="audit.properties" />
                    </field>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import Dump from '../common/Dump.vue';
import Field from '../common/Field.vue';
import UserValue from '../values/User.vue';
import EventInfo from '../events/Info.vue';
import AuditSubject from '../audits/Subject.vue';
import EventView from '../events/View.vue';
import EventCommandPanel from '../events/CommandPanel.vue';
import EventDefaultPanel from '../events/DefaultPanel.vue';
import EventEventPanel from '../events/EventPanel.vue';
import EventJobPanel from '../events/JobPanel.vue';
import EventRequestPanel from '../events/RequestPanel.vue';

export default {

    components: {
        Dump,
        Field,
        UserValue,
        EventInfo,
        AuditSubject,
        EventView,
        EventCommandPanel,
        EventDefaultPanel,
        EventEventPanel,
        EventJobPanel,
        EventRequestPanel,
    },

    props: {
        execution: {
            type: Object,
            required: true,
        },
    },

    methods: {

    }

}
</script>