import '../css/addon.css';

import ExecutionsListing from './components/executions/Listing.vue';
import ExecutionsView from './components/executions/View.vue';
import EventsListing from './components/events/Listing.vue';
import AuditsListing from './components/audits/Listing.vue';

Statamic.booting(() => {
    Statamic.component('overseer-executions-listing', ExecutionsListing)
    Statamic.component('overseer-executions-view', ExecutionsView)
    Statamic.component('overseer-events-listing', EventsListing)
    Statamic.component('overseer-audits-listing', AuditsListing)
})