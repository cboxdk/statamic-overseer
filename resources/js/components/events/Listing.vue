<template>
    <div class="overseer-listing">

        <div v-if="initializing" class="w-full flex justify-center text-center">
            <loading-graphic />
        </div>

        <div v-if="!initializing && !analyzing">

            <div class="card mb-4">
                <LineChartGenerator v-bind="chartProps" :height="300"/>
            </div>

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
                                    <user-value :value="event.user" :impersonator="event.impersonator" />
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

        <event-view
            v-if="showEvent"
            :id="activeEvent.id"
            @closed="closeEvent"
        />

    </div>
</template>

<script>
import EventInfo from './Info.vue';
import UserValue from '../values/User.vue';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  LinearScale,
  CategoryScale,
  PointElement
} from 'chart.js'
import { Line as LineChartGenerator } from 'vue-chartjs/legacy'

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  LineElement,
  LinearScale,
  CategoryScale,
  PointElement
)

export default {

    mixins: [Listing],

    components: {
        EventInfo,
        UserValue,
        LineChartGenerator,
    },

    props: ['initialColumns'],

    mounted() {
        this.analyze();
    },

    data() {
        return {
            columns: this.initialColumns,
            sortColumn: 'recorded_at',
            sortDirection: 'desc',
            requestUrl: cp_url('overseer/events/list'),
            analyticsUrl: cp_url('overseer/events/analytics'),
            analytics: null,
            analyzing: true,
        }
    },

    computed: {
        chartProps() {
            return {
                chartData: {
                    labels: this.analytics.labels,
                    datasets: [
                        {
                            label: 'Requests',
                            backgroundColor: '#43a9ff',
                            data: this.analytics.requests,
                        },
                        {
                            label: 'Commands',
                            backgroundColor: '#ff269e',
                            data: this.analytics.commands,
                        },
                        {
                            label: 'Jobs',
                            backgroundColor: '#f5a82f',
                            data: this.analytics.jobs,
                        },
                    ],
                },
                chartOptions: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            };
        }

    },

    methods: {

        analyze() {
            this.analyzing = true;
            this.$axios.get(this.analyticsUrl)
                .then(response => {
                    this.analytics = response.data;
                    this.analyzing = false;
                });
        },

    }

}
</script>