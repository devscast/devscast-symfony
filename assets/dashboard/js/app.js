import '../sass/app.scss';

// Dashforge utils
import Dashforge from './modules/Dashforge';
import DashforgeAside from './modules/DashforgeAside';

// Bootstrap utils
import 'bootstrap/js/dist/alert'
import 'bootstrap/js/dist/dropdown'

// Frontend Dashboard
document.addEventListener('DOMContentLoaded', function () {
    new Dashforge();
    new DashforgeAside();

    const datepicker = document.querySelectorAll("input.datepicker");
    if (datepicker.length > 0) {
        import('flatpickr')
            .then(m => {
                m.default(datepicker, {
                    minDate: 'today',
                    weekNumbers: true,
                    enableTime: true,
                    dateFormat: "Y-m-d H:i" +
                        "",
                })
            })
            .catch(e => console.error({e}));
    }

    const selects = document.querySelectorAll('select.select2');
    if (selects.length > 0) {
        import('select2')
            .then(() => {
                $(selects).select2({
                    placeholder: 'choisir',
                    allowClear: true,
                    searchInputPlaceholder: 'recherche...'
                })
            })
            .catch(e => console.error({e}))
    }

    const tables = document.querySelectorAll('table[data-datatable]');
    if (tables.length > 0) {
        import('./modules/DashforgeDatatable')
            .then(module => new module.default())
            .catch(e => console.error({e}))
    }
});
