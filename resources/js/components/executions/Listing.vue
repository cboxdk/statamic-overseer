<template>
    <div class="overseer-executions-listing">

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
                
                <div class="card p-0 overflow-hidden">

                    <data-list-filters
                        ref="filters"
                        :filters="filters"
                        :active-filters="activeFilters"
                        :active-filter-badges="activeFilterBadges"
                        :active-count="activeFilterCount"
                        @changed="filterChanged"
                    />

                    <data-list-table
                        @sorted="sorted">
                        <template slot="cell-created_at" slot-scope="{ row: execution }">
                            <a :href="cp_url(`overseer/executions/${execution.id}`)" class="text-blue">
                                {{ $moment(execution.created_at).format('YYYY-MM-DD HH:MM') }}
                            </a>
                        </template>
                        <template slot="cell-initiator" slot-scope="{ row: execution }">
                            <event-info :event="execution.initiator" />
                        </template>
                        <template slot="cell-duration" slot-scope="{ row: execution }">
                            {{ execution.duration }} ms
                        </template>
                        <template slot="cell-memory" slot-scope="{ row: execution }">
                            {{ execution.memory }} mb
                        </template>
                        <template slot="cell-counts" slot-scope="{ row: execution }">
                            {{ execution.audit_count }} au / 
                            {{ execution.event_count }} ev
                        </template>
                        <template slot="cell-cpu" slot-scope="{ row: execution }">
                            {{ execution.cpu_user_time.toFixed(3) }} /
                            {{ execution.cpu_system_time.toFixed(3) }} /
                            {{ execution.cpu_usage_percentage.toFixed() }}%
                        </template>
                        <template slot="cell-user" slot-scope="{ row: execution }">
                            <template v-if="execution.user">
                              {{ execution.user.name }}
                            </template>
                            <template v-if="execution.impersonator">
                                <br>
                                ({{ execution.impersonator.name }})
                            </template>
                        </template>
                    </data-list-table>
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

export default {

    mixins: [Listing],

    components: {
        EventInfo,
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
<style>
    .overseer-executions-listing {
        td, th {
            white-space: nowrap;
            &:not(:first-child) {
                padding-left: 0;
            }
        }
        .actions-column {
            display: none;            
        }
    }
</style>