import $ from 'jquery'
import 'datatables.net-dt'
import 'datatables.net-responsive-dt'

export default class Datatable {
    constructor(tables) {
        $(tables).DataTable({
            responsive: true,
            autoWidth: true,
            stateSave: false,
            paging: false,
            info: false,
            ordering: false,
            searching: false,
            language: {
                searchPlaceholder: 'Recherche...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
                zeroRecords: "Aucune Donnée",
                info: "Affichage de la page _PAGE_ sur _PAGES_",
                infoEmpty: "Aucune Donnée Disponible",
                infoFiltered: "(Filtré par _MAX_ résultat total)"
            },
        });
    }
}
