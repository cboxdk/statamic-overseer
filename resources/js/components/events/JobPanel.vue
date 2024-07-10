<template>
    <div class="overseer-panel p-4">
        <field display="Name" width="1/2">
            {{ event.event.name }}
        </field>
        <field display="Connection & Queue" width="1/4">
            <div>{{ event.event.connection }}</div>
            <div>{{ event.event.queue }}</div>
        </field>
        <field display="Tries & Timeout" width="1/4">
            <div>{{ event.event.tries || '—' }}</div>
            <div>{{ event.event.timeout || '—' }}</div>
        </field>
    </div>
</template>

<script>
import Field from '../common/Field.vue';
import Dump from '../common/Dump.vue';

export default {

    components: {
        Field,
        Dump,
    },

    props: {
        event: {
            type: Object,
        },
    },

};
</script>