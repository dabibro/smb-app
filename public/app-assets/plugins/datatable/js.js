$(document).ready(function () {
    $('.dataTables').dataTable({
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        language: {
            search: '',
            searchPlaceholder: "Search Keyword...",
            paginate: {
                next: '<i class="feather icon-arrow-right">',
                previous: '<i class="feather icon-arrow-left">'
            }
        }
    });

    $('.datatable-btn').dataTable({
        dom: "lfBrtip",
        buttons: [
            {
                extend: "csv",
                className: "btn btn-primary",
                text: '<i class="fal fa-file-csv"></i> <span class="hide-text">CSV</span>',
                titleAttr: 'CSV',
                footer: true,
                title: $('.print-title').text(),
                orientation: 'landscape',
                pageSize: 'A4'
            },
            {
                responsive: false,
                extend: "pdfHtml5",
                className: "btn btn-primary",
                text: '<i class="fal fa-file-pdf"></i> <span class="hide-text">PDF</span>',
                titleAttr: 'PDF',
                footer: true,
                title: $('.print-title').text(),
                orientation: 'landscape',
                pageSize: 'A4'
            },
            {
                extend: "print",
                className: "btn btn-primary",
                text: '<i class="fal fa-print"></i> <span class="hide-text">Print</span>',
                titleAttr: 'Print',
                footer: true,
                title: $('.print-title').text(),
                orientation: 'landscape',
                pageSize: 'A4'
            },
        ],
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        language: {
            search: '',
            searchPlaceholder: "Search Keyword...",
            paginate: {
                next: '<i class="feather icon-arrow-right m-0">',
                previous: '<i class="feather icon-arrow-left m-0">',
            }
        },
        order: false,
        pageLength: 50,
    });

    //------------------------------------------------------------------------------
    $('.dynamic-datatable').dataTable({
        dom: "lfBrtip",
        buttons: [
            {
                extend: "csv",
                className: "btn btn-primary",
                text: '<i class="fal fa-file-csv"></i> <span class="hide-text">CSV</span>',
                titleAttr: 'CSV',
                title: $('.print-title').text(),
                orientation: 'landscape',
                pageSize: 'A4',
                footer: true
            },
            {
                responsive: false,
                extend: "pdfHtml5",
                className: "btn btn-primary",
                text: '<i class="fal fa-file-pdf"></i> <span class="hide-text">PDF</span>',
                titleAttr: 'PDF',
                footer: true,
                title: $('.print-title').text(),
                orientation: 'landscape',
                pageSize: 'A4'
            },
            {
                extend: "print",
                className: "btn btn-primary",
                text: '<i class="fal fa-print"></i> <span class="hide-text">Print</span>',
                titleAttr: 'Print',
                footer: true,
                title: $('.print-title').text(),
                orientation: 'landscape',
                pageSize: 'A4'
            },
        ],
        responsive: false,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 50,
        "searching": true,
        "paging": false,
        "info": false,
        sort: true,
        language: {
            search: '',
            searchPlaceholder: "Search Keyword...",
            paginate: {
                next: '<i class="feather icon-arrow-right m-0">',
                previous: '<i class="feather icon-arrow-left m-0">',
            }
        }
    });
    //------------------------------------------------------------------------------
    $('.datatables-search').dataTable({
        paging: false,
        language: {
            paginate: {
                next: '<i class="feather icon-arrow-right">',
                previous: '<i class="feather icon-arrow-left">'
            }
        }
    });
});