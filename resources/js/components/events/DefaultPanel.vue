<template>
    <div class="overseer-panel p-4">
        <field display="Data">
            <dump :data="event.event" />
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