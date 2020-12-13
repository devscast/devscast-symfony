import '../sass/app.scss'

// Layout utils
import Layout from './modules/Layout'
import Aside from './modules/Aside'

// Bootstrap utils
import 'bootstrap/js/dist/alert'
import 'bootstrap/js/dist/dropdown'
import 'bootstrap/js/dist/modal'

// Frontend Dashboard
document.addEventListener('DOMContentLoaded', function () {
    new Layout()
    new Aside()

    const datepicker = document.querySelectorAll("input.datepicker")
    if (datepicker.length > 0) {
        import('./modules/Datepicker')
            .then(module => new module.default(datepicker))
            .catch(e => console.error({e}))
    }

    const selects = document.querySelectorAll('select.select2')
    if (selects.length > 0) {
        import('./modules/Select')
            .then(module => new module.default(selects))
            .catch(e => console.error({e}))
    }

    const tables = document.querySelectorAll('table[data-datatable]')
    if (tables.length > 0) {
        import('./modules/Datatable')
            .then(module => new module.default(tables))
            .catch(e => console.error({e}))
    }

    const create = document.querySelectorAll('button[data-create-content]')
    if (create.length > 0) {
        import('./modules/Content')
            .then(module => (new module.default()).init(create))
            .catch(e => console.error({e}))
    }

    const edit = document.querySelectorAll('button[data-edit-content]')
    if (edit.length > 0) {
        import('./modules/Content')
            .then(module => (new module.default()).init(edit))
            .catch(e => console.error({e}))
    }

    const deletes = document.querySelectorAll('button[data-delete-content]')
    if (deletes.length > 0) {
        import('./modules/Content')
            .then(module => (new module.default()).delete(deletes))
            .catch(e => console.error({e}))
    }

    const searchInputs = document.querySelectorAll('input[data-autocomplete]')
    if (searchInputs.length > 0) {
        import('./modules/Autocomplete')
            .then(module => (new module.default(searchInputs)))
            .catch(e => console.error({e}))
    }

    const charts = document.querySelectorAll('div[data-statistic]')
    if (charts.length > 0) {
        import('./modules/StatisticChart')
            .then(module => (new module.default(charts)))
            .catch(e => console.error({e}))
    }
});
