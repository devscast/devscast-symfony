import $ from 'jquery'
import 'select2'

export default class Select {
    constructor(elements) {
        $(elements).select2({
            placeholder: 'choisir',
            allowClear: false,
            searchInputPlaceholder: 'recherche...'
        })
    }
}
