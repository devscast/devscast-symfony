import flatpickr from "flatpickr"

export default class Datepicker {
    constructor(elements) {
        elements.forEach(element => {
            flatpickr(element, {
                minDate: 'today',
                weekNumbers: true,
                enableTime: true,
                dateFormat: "Y-m-d H:i",
            })
        })
    }
}
