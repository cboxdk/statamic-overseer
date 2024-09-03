<template>
    <div class="overseer-listing">

        <div v-if="initializing" class="w-full flex justify-center text-center">
            <loading-graphic />
        </div>

        <div v-if="!initializing">

            <data-list
                
                :visible-columns="columns"
                :columns="columns"
                :rows="items"
                :sort="false"
                :sort-column="sortColumn"
                :sort-direction="sortDirection">
                
                <div slot-scope="{ filteredRows: rows }">
                    
                    <div class="card p-0 overflow-hidden">
    
                        <data-list-filters
                            ref="filters"
                            :filters="filters"
                            :active-filters="activeFilters"
                            :active-filter-badges="activeFilterBadges"
                            :active-count="activeFilterCount"
                            @changed="filterChanged"
                        />
    
                        <div class="overseer-table">
                            <data-list-table
                                @sorted="sorted">
                                <template slot="cell-created_at" slot-scope="{ row: audit }">
                                    <a :href="cp_url(`overseer/executions/${audit.execution_id}`)" class="text-blue">
                                        {{ $moment(audit.created_at).format('YYYY-MM-DD HH:mm:ss.SSSS') }}
                                    </a>
                                    <div class="text-2xs opacity-75">
                                        {{ audit.execution_id }}
                                    </div>
                                </template>
                                <template slot="cell-initiator" slot-scope="{ row: audit }">
                                    <event-info :event="audit.initiator" />
                                </template>
                                <template slot="cell-subject" slot-scope="{ row: audit }">
                                    <subject :audit="audit" />
                                </template>
                                <template slot="cell-user" slot-scope="{ row: audit }">
                                    <user-value :value="audit.user" :impersonator="audit.impersonator" />
                                </template>
                            </data-list-table>
                        </div>
                    </div>
    
                    <data-list-pagination
                        class="mt-6"
                        :resource-meta="meta"
                        :per-page="perPage"
                        @page-selected="selectPage"
                        @per-page-changed="changePerPage"
                    />
    
                </div>
    
            </data-list>

        </div>

    </div>
</template>

<script>
import UserValue from '../values/User.vue';
import EventInfo from '../events/Info.vue';
import Subject from './Subject.vue';

export default {

    mixins: [Listing],

    components: {
        EventInfo,
        UserValue,
        Subject,
    },

    props: ['initialColumns'],

    data() {
        return {
            columns: this.initialColumns,
            sortColumn: 'created_at',
            sortDirection: 'desc',
            requestUrl: cp_url('overseer/audits/list'),
        }
    },

    methods: {

        subject(audit) {
            return [
                audit.model_type,
                audit.model_handle,
                audit.model_id,
            ].filter(item => item !== null).join(' / ');
        },

    }

}
</script>