<template>
    <div class="overseer-panel p-4">
        <field display="Name" width="1/2">
            {{ event.event.command }}
        </field>
        <field display="Exit Code" width="1/2">
            {{ event.event.exit_code }}
        </field>
        <field display="Options" width="1/2">
            <dump :data="event.event.options" />
        </field>
        <field display="Arguments" width="1/2">
            <dump :data="event.event.arguments" />
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