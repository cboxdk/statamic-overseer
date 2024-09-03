<template>
    <div class="overseer-panel p-4">
        <field display="Name">
            {{ event.event.event }}
        </field>
        <field display="Changed Attributes" width="1/2">
            <dump :data="event.event.changed_attributes" />
        </field>
        <field display="Difference" width="1/2">
            <dump :data="event.event.diff" />
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