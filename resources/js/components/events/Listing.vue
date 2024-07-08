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
                            <template slot="cell-recorded_at" slot-scope="{ row: event }">
                                <a :href="cp_url(`overseer/executions/${event.execution_id}`)" class="text-blue">
                                    {{ $moment(event.recorded_at).format('YYYY-MM-DD HH:mm:ss.SSSS') }}
                                </a>
                                <div class="text-2xs opacity-75">
                                    {{ event.execution_id }}
                                </div>
                            </template>
                            <template slot="cell-type" slot-scope="{ row: event }">
                                <event-info :event="event" />
                            </template>
                            <template slot="cell-user" slot-scope="{ row: event }">
                                <user :user="event.user" :impersonator="event.impersonator" />
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

        <event-view
            v-if="showEvent"
            :id="activeEvent.id"
            @closed="closeEvent"
        />

    </div>
</template>

<script>
import EventInfo from './Info.vue';
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
            sortColumn: 'recorded_at',
            sortDirection: 'desc',
            requestUrl: cp_url('overseer/events/list'),
        }
    },

    methods: {


    }

}
</script>