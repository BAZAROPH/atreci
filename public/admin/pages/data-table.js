'use strict';
$(document).ready(function() {
    var simple = $('#simpletable').DataTable({
        "pageLength": 100,
        "language": {
            "decimal":        "",
            "emptyTable":     "aucune donnée disponible",
            "info":           "Affichage _START_ to _END_ of _TOTAL_ entrées",
            "infoEmpty":      "Affichage 0 to 0 of 0 entrées",
            "infoFiltered":   "(Trie sur _MAX_ total entrées)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Affichage _MENU_ entrées",
            "loadingRecords": "Chargement...",
            "processing":     "Traitement...",
            "search":         "Rechercher:",
            "zeroRecords":    "Aucun enregistrements correspondants trouvés",
            "paginate": {
                "first":      "Premier",
                "last":       "Dernier",
                "next":       "Suivant",
                "previous":   "Précédent"
            },
            "aria": {
                "sortAscending":  ": activer pour trier les colonnes par ordre croissant",
                "sortDescending": ": activer pour trier la colonne par ordre décroissant"
            }
        }
    });

    var simple = $('.simpletable').DataTable({
        "pageLength": 100
    });

    var advance = $('#advanced-table').DataTable({
        dom: 'Bfrtip',
        "pageLength": 50,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    // Setup - add a text input to each footer cell
    $('#simpletable tfoot th').each(function() {
        var title = $(this).text();
        $(this).html('<div class="md-input-wrapper"><input type="text" class="md-form-control" placeholder="' + title + ' ..." /></div>');
    });
    // Apply the search
    simple.columns().every(function() {
        var that = this;

        $('input', this.footer()).on('keyup change', function() {
            if (that.search() !== this.value) {
                that
                    .search(this.value)
                    .draw();
            }
        });
    });

    // Setup - add a text input to each footer cell
    $('#advanced-table tfoot th').each(function() {
        var title = $(this).text();
        $(this).html('<div class="md-input-wrapper"><input type="text" class="md-form-control" placeholder="Search ' + title + '" /></div>');
    });
    // Apply the search
    advance.columns().every(function() {
        var that = this;

        $('input', this.footer()).on('keyup change', function() {
            if (that.search() !== this.value) {
                that
                    .search(this.value)
                    .draw();
            }
        });
    });



});
