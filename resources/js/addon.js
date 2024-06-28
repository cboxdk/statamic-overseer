import StatamicOverseer from './components/fieldtypes/StatamicOverseer.vue'

Statamic.booting(() => {
    Statamic.component('statamic_overseer-fieldtype', StatamicOverseer)
})
