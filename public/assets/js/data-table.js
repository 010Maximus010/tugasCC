$(document).ready(function () {
    // Inisialisasi table
    var table = $("#table").DataTable({
        iDisplayLength: 10,
        language: {
            search: "",
        },
        lengthMenu: [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "All"],
        ],
    });

    // Modifikasi tampilan search dan length pada table
    $("#table, #table_1, #table_2, #table_4").each(function () {
        var datatable = $(this);
        var search_input = datatable.closest(".dataTables_wrapper").find("div[id$=_filter] input");
        var length_sel = datatable.closest(".dataTables_wrapper").find("div[id$=_length] select");

        search_input.attr({
            placeholder: "Search",
            class: "form-control form-control-sm ps-5",
            style: "width: 250px; background-image: url(http://ppl-project.test/assets/images/search.jpg); background-repeat: no-repeat; background-position: 10px 7px !important; background-size: 18px 18px !important;",
            id: "search",
            name: "search",
        });

        length_sel.removeClass("form-control-sm");
    });

    // Inisialisasi table_1
    var table_1 = $("#table_1").DataTable({
        iDisplayLength: 10,
        language: {
            search: "",
        },
        buttons: [
            {
                extend: "print",
                title: function () {
                    return (
                        "<h5><center>Data " +
                        title_4 +
                        " - Informatika</center></h5><br/>"
                    );
                },
                className: "btn btn-primary btn-sm",
                text: '<i class="bi bi-printer"></i> Print',
                titleAttr: "Print",
            },
            {
                extend: "excel",
                title: function () {
                    return "Data " + title_4 + " - Informatika";
                },
                className: "btn btn-primary btn-sm",
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: "Excel",
            },
            // ... (tombol print dan excel untuk table_1)
        ],
        dom:
            "<'row'<'col-md-3'l><'col-md-5'B><'col-md-4'f>>" +
            "<'row'<'col-md-12'tr>>" +
            "<'row'<'col-md-5'i><'col-md-7'p>>",
        lengthMenu: [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "All"],
        ],
    });

    // Inisialisasi table_2
    var table_2 = $("#table_2").DataTable({
        iDisplayLength: 10,
        language: {
            search: "",
        },
        buttons: [
            // ... (tombol print dan excel untuk table_2)
        ],
        dom:
            "<'row'<'col-md-3'l><'col-md-5'B><'col-md-4'f>>" +
            "<'row'<'col-md-12'tr>>" +
            "<'row'<'col-md-5'i><'col-md-7'p>>",
        lengthMenu: [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "All"],
        ],
    });

    // Inisialisasi table_4
    var table_4 = $("#table_4").DataTable({
        buttons: [
            {
                extend: "print",
                title: function () {
                    return (
                        "<h5><center>Data " +
                        title_4 +
                        " - Informatika</center></h5><br/>"
                    );
                },
                className: "btn btn-primary btn-sm",
                text: '<i class="bi bi-printer"></i> Print',
                titleAttr: "Print",
            },
            {
                extend: "excel",
                title: function () {
                    return "Data " + title_4 + " - Informatika";
                },
                className: "btn btn-primary btn-sm",
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: "Excel",
            },
            // ... (tombol print dan excel untuk table_4)
        ],
        initComplete: function () {
            // Pastikan tombol-tombol benar-benar terlihat
            table_4.buttons().container().appendTo("#table_4_wrapper .col-md-5");
        },
        dom:
            "<'row'<'col-md-3'l><'col-md-5'B><'col-md-4'f>>" +
            "<'row'<'col-md-12'tr>>" +
            "<'row'<'col-md-5'i><'col-md-7'p>>",
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"],
        ],
    });

    // Event handling untuk filter
    $("input.column_filter").on("keyup click", function () {
        var column = $(this).parents("div").attr("data-column");
        filterColumnTable1(column);
        filterColumnTable4(column);
    });

    $("select.column_filter").on("change", function () {
        var column = $(this).parents("div").attr("data-column");
        filterColumnTable1(column);
        filterColumnTable4(column);
    });

    // Fungsi filterColumn untuk table_1
    function filterColumnTable1(i) {
        $("#table_1")
            .DataTable()
            .column(i)
            .search($("#col" + i + "_filter").val())
            .draw();
    }

    // Fungsi filterColumn untuk table_4
    function filterColumnTable4(i) {
        $("#table_4")
            .DataTable()
            .column(i)
            .search($("#col" + i + "_filter").val())
            .draw();
    }
});
