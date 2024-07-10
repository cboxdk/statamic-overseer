<template>
    <div class="overseer-panel p-4">
        <field display="Response Code" width="1/4">
            <response-code :value="event.event.response_code" />
        </field>
        <field display="Method" width="1/4">
            {{ event.event.method }}
        </field>
        <field display="Cache Hit" width="1/4">
            {{ event.event.response_cache_hit ? 'Hit' : 'Miss' }}
        </field>
        <field display="IP Address" width="1/4">
            {{ event.event.ip_address }}
        </field>
        <field display="URL">
            {{ event.event.url }}
        </field>
        <field display="Session ID" width="1/2">
            {{ event.event.session_id }}
        </field>
        <field display="Middleware" width="1/2">
            <template v-for="middleware in event.event.middleware">
                {{ middleware }}<br>
            </template>
        </field>
        <field display="Headers">
            <dump :data="event.event.headers" />
        </field>
        <field display="Payload" width="1/2">
            <dump :data="event.event.payload" />
        </field>
        <field display="Response" width="1/2">
            <dump :data="event.event.response" />
        </field>
    </div>
</template>

<script>
import Field from '../common/Field.vue';
import Dump from '../common/Dump.vue';
import ResponseCode from '../values/ResponseCode.vue';

export default {

    components: {
        Field,
        Dump,
        ResponseCode,
    },

    props: {
        event: {
            type: Object,
        },
    },

};
</script>