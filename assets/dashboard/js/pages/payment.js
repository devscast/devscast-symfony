import $ from 'jquery'
import 'select2'
import axios from '../axios'
import {createLoader, disableInput, enableInput, removeLoader} from "../functions/dom";

const config = {
    placeholder: 'choisir',
    searchInputPlaceholder: 'recherche...'
};

const invoice = $("select#invoices_id");
const type = $("select#type");
const bank = $("select#banks_id");
const reference = $("input[name='reference']");

invoice.select2(config);
type.select2(config);
bank.select2(config);

disableInput(bank, reference);
type.on('change', e => {
    if (e.target.value === 'BANK') {
        enableInput(bank, reference)
    } else {
        disableInput(bank, reference)
    }
});


const setAmount = (remaining) => {
    const amount = $("input[name='amount']");
    amount.attr('max', remaining);
    amount.val(remaining);
}

const fetchInvoice = (id) => {
    createLoader();
    axios.get(`/api/invoices/${id}`)
        .then(response => {
            const container = document.querySelector("#invoice_data");
            const data = response.data;
            container.innerHTML = data.html;
            setAmount(data.invoice.remaining);
        })
        .catch(error => {
            alert("Impossible de charger la facture, Réessayer !")
            console.error({error})
        })
        .finally(removeLoader)
}

fetchInvoice(invoice.val())
invoice.on('change', e => {
    fetchInvoice(e.target.value)
})
