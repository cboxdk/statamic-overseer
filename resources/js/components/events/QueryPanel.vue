<template>
    <div class="overseer-panel p-4">
        <field display="Connection" width="1/3">
            {{ event.event.connection }}
        </field>
        <field display="Time" width="1/3">
            {{ event.event.time }} ms
        </field>
        <field display="Slow" width="1/3">
            {{ event.event.slow ? 'Yes' : 'No' }}
        </field>
        <field display="SQL Query">
            <code-value :code="event.event.sql" />
        </field>
        <field display="Bindings">
            <dump :data="event.event.bindings" />
        </field>
    </div>
</template>

<script>
import Field from '../common/Field.vue';
import Dump from '../common/Dump.vue';
import CodeValue from '../common/Code.vue';

export default {

    components: {
        Field,
        Dump,
        CodeValue,
    },

    props: {
        event: {
            type: Object,
        },
    },

};
</script>