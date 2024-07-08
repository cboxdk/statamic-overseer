<template>
    <div class="overseer-listing">

        <div v-if="initializing" class="w-full flex justify-center text-center">
            <loading-graphic />
        </div>

        <data-list
            v-if="!initializing"
            :visible-columns="columns"
            :columns="columns"
            :rows="items"
            :sort="false"
            :sort-column="sortColumn"
            :sort-direction="sortDirection">
            
            <div slot-scope="{ filteredRows: rows }">
                
                <div class="card p-0">

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
                            <template slot="cell-created_at" slot-scope="{ row: execution }">
                                <a :href="cp_url(`overseer/executions/${execution.id}`)" class="text-blue">
                                    {{ $moment(execution.created_at).format('YYYY-MM-DD HH:mm:ss.SSSS') }}
                                </a>
                                <div class="text-2xs opacity-75">
                                    {{ execution.id }}
                                </div>
                            </template>
                            <template slot="cell-initiator" slot-scope="{ row: execution }">
                                <event-info :event="execution.initiator" />
                            </template>
                            <template slot="cell-stats" slot-scope="{ row: execution }">
                                {{ execution.audit_count }} audits / 
                                {{ execution.event_count }} events
                                <div class="text-2xs opacity-75">
                                    {{ execution.duration }} ms /
                                    {{ execution.memory }} mb /
                                    {{ execution.cpu_user_time.toFixed(3) }} /
                                    {{ execution.cpu_system_time.toFixed(3) }} /
                                    {{ execution.cpu_usage_percentage.toFixed() }}%
                                </div>

                            </template>
                            <template slot="cell-cpu" slot-scope="{ row: execution }">
                            </template>
                            <template slot="cell-user" slot-scope="{ row: execution }">
                                <user :user="execution.user" :impersonator="execution.impersonator" />
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

        <execution-view
            v-if="showExecution"
            :id="activeExecution.id"
            @closed="closeExecution"
        />

    </div>
</template>

<script>
import EventInfo from '../events/Info.vue';
import User from '../common/User.vue';

export default {

    mixins: [Listing],

    components: {
        EventInfo,
        User,
    },

    props: ['initialColumns'],

    data() {
        return {
            columns: this.initialColumns,
            sortColumn: 'created_at',
            sortDirection: 'desc',
            requestUrl: cp_url('overseer/executions/list'),
        }
    },

    methods: {

    }

}
</script>