<template>
    <div class="overseer-events-listing">

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
                        <template slot="cell-created_at" slot-scope="{ row: event }">
                            <a :href="cp_url(`overseer/executions/${event.execution_id}`)" class="text-blue">
                                {{ $moment(event.created_at).format('YYYY-MM-DD HH:MM') }}
                            </a>
                        </template>
                        <template slot="cell-type" slot-scope="{ row: event }">
                            <event-info :event="event" />
                        </template>
                        <template slot="cell-user" slot-scope="{ row: event }">
                            <template v-if="event.user">
                                {{ event.user.name }}
                            </template>
                            <template v-if="event.impersonator">
                                (impersonated by {{ event.impersonator.name }})
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

        <event-view
            v-if="showEvent"
            :id="activeEvent.id"
            @closed="closeEvent"
        />

    </div>
</template>

<script>
import EventInfo from './Info.vue';

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
            requestUrl: cp_url('overseer/events/list'),
        }
    },

    methods: {


    }

}
</script>
<style>
    .overseer-events-listing {
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