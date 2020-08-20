import $ from 'jquery'
import 'datatables.net-dt'
import 'datatables.net-responsive-dt'

export default class DashforgeDatatable {
    constructor() {
        $('table[data-datatable]').DataTable({
            responsive: true,
            autoWidth: true,
            stateSave: true,
            language: {
                searchPlaceholder: 'Recherche...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
                zeroRecords: "Aucune Donnée",
                info: "Affichage de la page _PAGE_ sur _PAGES_",
                infoEmpty: "Aucune Donnée Disponible",
                infoFiltered: "(Filtré par _MAX_ réultat total)"
            },
        });
    }
}
