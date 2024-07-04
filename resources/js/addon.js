import ExecutionsListing from './components/executions/Listing.vue';
import EventsListing from './components/events/Listing.vue';
import AuditsListing from './components/audits/Listing.vue';

Statamic.booting(() => {
    Statamic.component('overseer-executions-listing', ExecutionsListing)
    Statamic.component('overseer-events-listing', EventsListing)
    Statamic.component('overseer-audits-listing', AuditsListing)
})