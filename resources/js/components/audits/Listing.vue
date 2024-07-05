<template>
    <div class="overseer-audits-listing">

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
                        <template slot="cell-created_at" slot-scope="{ row: audit }">
                            <a :href="cp_url(`overseer/executions/${audit.execution_id}`)" class="text-blue">
                                {{ $moment(audit.created_at).format('YYYY-MM-DD HH:MM') }}
                            </a>
                        </template>
                        <template slot="cell-initiator" slot-scope="{ row: audit }">
                            <event-info :event="audit.initiator" />
                        </template>
                        <template slot="cell-subject" slot-scope="{ row: audit }">
                            {{ subject(audit) }}
                        </template>
                        <template slot="cell-user" slot-scope="{ row: audit }">
                            <template v-if="audit.user">
                              {{ audit.user.name }}
                            </template>
                            <template v-if="audit.impersonator">
                                (impersonated by {{ audit.impersonator.name }})
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
<style>
    .overseer-audits-listing {
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