<template>

    <div>
        <template v-if="audit.model_type === 'entry'">
            <span class="font-semibold">Entry</span> /
            {{ audit.subject.collection.title }}
            <div class="text-2xs opacity-75">{{ audit.subject.title }}</div>
        </template>
        <template v-if="audit.model_type === 'term'">
            <span class="font-semibold">Term</span> /
            {{ audit.subject.taxonomoy.title }}
            <div class="text-2xs opacity-75">{{ audit.subject.title }}</div>
        </template>
        <template v-if="audit.model_type === 'asset'">
            <span class="font-semibold">Asset</span> /
            {{ audit.subject.container.title }}
            <div class="text-2xs opacity-75">{{ audit.subject.title }}</div>
        </template>
        <template v-if="audit.model_type === 'user'">
            <span class="font-semibold">User</span>
            <div class="text-2xs opacity-75">{{ audit.subject.name }}</div>
        </template>
        <template v-if="audit.model_type === 'blueprint'">
            <span class="font-semibold">Blueprint</span>
            <div class="text-2xs opacity-75">{{ audit.subject.display }}</div>
        </template>
        
    </div>

</template>
<script>

export default {

    props: {
        audit: {
            type: Object,
        },
    },

};

</script>