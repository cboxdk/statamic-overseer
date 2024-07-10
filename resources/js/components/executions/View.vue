<template>
    <div class="overseer-view">

        <div class="card text-sm mb-6 overseer-panel">
            <div class="overseer-1/3">
                <div class="font-semibold mb-0.5">ID</div>
                <div class="opacity-75">{{ execution.id }}</div>
            </div>
            <div class="overseer-1/3">
                <div class="font-semibold mb-0.5">Date & Time</div>
                <div class="opacity-75">{{ $moment(execution.created_at).format('YYYY-MM-DD HH:mm:ss.SSSS') }}</div>
            </div>
            <div class="overseer-1/3">
                <div class="font-semibold mb-0.5">User</div>
                <div class="opacity-75"><user :user="execution.user" :impersonator="execution.usimpersonatorer" /></div>
            </div>
            <div class="overseer-1/3">
                <div class="font-semibold mb-0.5">Host & PID</div>
                <div class="opacity-75">
                    {{ execution.host }} /
                    {{ execution.pid }}
                </div>
            </div>
            <div class="overseer-1/3">
                <div class="font-semibold mb-0.5">Duration & Memory</div>
                <div class="opacity-75">
                    {{ execution.duration }} ms /
                    {{ execution.memory }} mb
                </div>
            </div>
            <div class="overseer-1/3">
                <div class="font-semibold mb-0.5">CPU User Time / System Time / Usage </div>
                <div class="opacity-75">
                    {{ execution.cpu_user_time.toFixed(3) }} /
                    {{ execution.cpu_system_time.toFixed(3) }} /
                    {{ execution.cpu_usage_percentage.toFixed() }}%
                </div>
            </div>
        </div>

        <div class="card text-sm mb-6 p-0 overflow-hidden">
            <div class="bg-gray-200 px-4 py-3 flex justify-between items-end">
                <div class="font-semibold text-base">Events</div>
                <div class="opacity-75">{{ execution.events.length }} total</div>
            </div>
            <div v-for="event in execution.events" class="overseer-split border-t border-gray-400">
                <div class="border-r border-gray-300 bg-gray-100 p-4">
                    <div class="overseer-panel">
                        <div class="overseer-full">
                            <div class="font-semibold mb-0.5">Date & Time</div>
                            <div class="opacity-75">{{ $moment(event.recorded_at).format('YYYY-MM-DD HH:mm:ss.SSSS') }}</div>
                        </div>
                        <div class="overseer-full">
                            <div class="font-semibold mb-0.5">Type</div>
                            <div class="opacity-75 capitalize flex items-center">
                                {{ event.type }}
                                <div v-if="event.id === execution.initiator.id" class="badge-sm bg-blue-600 ml-1">
                                    Initiator
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overseer-panel p-4">
                    <template v-if="event.type === 'request'">
                        <div class="overseer-1/4">
                            <div class="font-semibold mb-0.5">Method</div>
                            <div class="opacity-75">
                                {{ event.event.method }}
                            </div>
                        </div>
                        <div class="overseer-1/4">
                            <div class="font-semibold mb-0.5">Response Code</div>
                            <div class="opacity-75">
                                {{ event.event.response_code }}
                            </div>
                        </div>
                        <div class="overseer-1/4">
                            <div class="font-semibold mb-0.5">Cache Hit</div>
                            <div class="opacity-75">
                                {{ event.event.response_cache_hit ? 'Hit' : 'Miss' }}
                            </div>
                        </div>
                        <div class="overseer-1/4">
                            <div class="font-semibold mb-0.5">IP Address</div>
                            <div class="opacity-75">
                                {{ event.event.ip_address }}
                            </div>
                        </div>
                        <div class="overseer-full">
                            <div class="font-semibold mb-0.5">URL</div>
                            <div class="opacity-75">
                                {{ event.event.url }}
                            </div>
                        </div>
                        <div class="overseer-1/2">
                            <div class="font-semibold mb-0.5">Session ID</div>
                            <div class="opacity-75">
                                {{ event.event.session_id }}
                            </div>
                        </div>
                        <div class="overseer-1/2">
                            <div class="font-semibold mb-0.5">Middleware</div>
                            <div class="opacity-75">
                                <template v-for="middleware in event.event.middleware">
                                    {{ middleware }}<br>
                                </template>
                            </div>
                        </div>
                        <div class="overseer-full">
                            <div class="font-semibold mb-0.5">Headers</div>
                            <dump :data="event.event.headers" />
                        </div>
                        <div class="overseer-1/2">
                            <div class="font-semibold mb-0.5">Payload</div>
                            <dump :data="event.event.payload" />
                        </div>
                        <div class="overseer-1/2">
                            <div class="font-semibold mb-0.5">Response</div>
                            <dump :data="event.event.response" />
                        </div>
                    </template>
                    <template v-else-if="event.type === 'command'">
                        <div class="overseer-1/2">
                            <div class="font-semibold mb-0.5">Name</div>
                            <div class="opacity-75">
                                {{ event.event.command }}
                            </div>
                        </div>
                        <div class="overseer-1/2">
                            <div class="font-semibold mb-0.5">Exit Code</div>
                            <div class="opacity-75">
                                {{ event.event.exit_code }}
                            </div>
                        </div>
                        <div class="overseer-1/2">
                            <div class="font-semibold mb-0.5">Options</div>
                            <dump :data="event.event.options" />
                        </div>
                        <div class="overseer-1/2">
                            <div class="font-semibold mb-0.5">Arguments</div>
                            <dump :data="event.event.arguments" />
                        </div>
                    </template>
                    <template v-else-if="event.type === 'job'">
                        <div class="overseer-1/2">
                            <div class="font-semibold mb-0.5">Name</div>
                            <div class="opacity-75">
                                {{ event.event.name }}
                            </div>
                        </div>
                        <div class="overseer-1/4">
                            <div class="font-semibold mb-0.5">Connection & Queue</div>
                            <div class="opacity-75">
                                {{ event.event.connection }} /
                                {{ event.event.queue }}
                            </div>
                        </div>
                        <div class="overseer-1/4">
                            <div class="font-semibold mb-0.5">Tries & Timeout</div>
                            <div class="opacity-75">
                                {{ event.event.tries || '—' }} /
                                {{ event.event.timeout || '—' }}
                            </div>
                        </div>
                    </template>
                    <template v-else-if="event.type === 'event'">
                        <div class="overseer-full">
                            <div class="font-semibold mb-0.5">Name</div>
                            <div class="opacity-75">
                                {{ event.event.event }}
                            </div>
                        </div>
                        <div class="overseer-1/2">
                            <div class="font-semibold mb-0.5">Changed Attributes</div>
                            <dump :data="event.event.changed_attributes" />
                        </div>
                        <div class="overseer-1/2">
                            <div class="font-semibold mb-0.5">Diff</div>
                            <dump :data="event.event.diff" />
                        </div>
                    </template>
                    <template v-else>
                        <div class="overseer-full">
                            <div class="font-semibold mb-0.5">Data</div>
                            <dump :data="event.event" />
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div class="card text-sm mb-6 p-0 overflow-hidden">
            <div class="bg-gray-200 px-4 py-3 flex justify-between items-end">
                <div class="font-semibold text-base">Audits</div>
                <div class="opacity-75">{{ execution.audits.length }} total</div>
            </div>
            <div v-for="audit in execution.audits" class="overseer-split border-t border-gray-400">
                <div class="border-r border-gray-300 bg-gray-100 p-4">
                    <div class="overseer-panel">
                        <div class="overseer-full">
                            <div class="font-semibold mb-0.5">Date & Time</div>
                            <div class="opacity-75">{{ $moment(audit.created_at).format('YYYY-MM-DD HH:mm:ss.SSSS') }}</div>
                        </div>
                    </div>
                </div>
                <div class="overseer-panel p-4">
                    <div class="overseer-1/2">
                        <div class="font-semibold mb-0.5">Message</div>
                        <div class="opacity-75">
                            {{ audit.message }}
                        </div>
                    </div>
                    <div class="overseer-1/2">
                        <div class="font-semibold mb-0.5">Subject</div>
                        <div class="opacity-75">
                            <audit-subject :audit="audit" />
                        </div>
                    </div>
                    <div class="overseer-full">
                        <div class="font-semibold mb-0.5">Properties</div>
                        <dump :data="audit.properties" />
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import User from '../common/User.vue';
import Dump from '../common/Dump.vue';
import EventInfo from '../events/Info.vue';
import AuditSubject from '../audits/Subject.vue';

export default {

    components: {
        User,
        Dump,
        EventInfo,
        AuditSubject,
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