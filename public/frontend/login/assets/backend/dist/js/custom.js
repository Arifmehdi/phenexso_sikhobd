$(function () {
    $(document).ready(function () {
        // Initialize Select2 and prevent it from breaking layout
        $("#taxpayerSelect").select2({
            width: "100%", // important for keeping the button on same line
        });
    });

    $("#table-export").DataTable({
        dom: `
                                          <"row mb-2"
                                            <"col-sm-4 col-md-4"l>
                                            <"col-sm-4 col-md-4"B>
                                            <"col-sm-4 col-md-4"f>
                                          >
                                          rt
                                          <"row"
                                            <"col-sm-12 col-md-6"i>
                                            <"col-sm-12 col-md-6"p>
                                          >
                                        `,
        buttons: [
            {
                extend: "copyHtml5",
                text: '<i class="fas fa-copy"></i>',
                className: "btn btn-sm btn-primary me-2", // primary blue + spacing
                titleAttr: "Copy",
            },
            {
                extend: "csvHtml5",
                text: '<i class="fas fa-file-csv"></i>',
                className: "btn btn-sm btn-success me-2", // green + spacing
                titleAttr: "CSV",
            },
            {
                extend: "excelHtml5",
                text: '<i class="fas fa-file-excel"></i>',
                className: "btn btn-sm btn-info me-2", // info blue + spacing
                titleAttr: "Excel",
            },
            {
                extend: "pdfHtml5",
                text: '<i class="fas fa-file-pdf"></i>',
                className: "btn btn-sm btn-danger me-2", // red + spacing
                titleAttr: "PDF",
            },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i>',
                className: "btn btn-sm btn-secondary me-2", // gray + spacing
                titleAttr: "Print",
            },
            {
                extend: "colvis",
                text: '<i class="fas fa-eye"></i>',
                className: "btn btn-sm btn-warning me-2", // yellow + spacing
                titleAttr: "Column Visibility",
            },
        ],
        responsive: true,
        paging: true,
        ordering: true,
        order: [[0, "asc"]],
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000],
            [10, 25, 50, 100, 500, 1000],
        ],
    });
    $("#table-default").DataTable({
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        responsive: true,
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000],
            [10, 25, 50, 100, 500, 1000],
        ],
    });
});
$(document).ready(function () {
    var current = window.location.href;

    $(".nav-sidebar a").each(function () {
        var $this = $(this);

        // Check if current URL ends with this href (handles trailing slash)
        if (current.endsWith($this.attr("href"))) {
            $this.addClass("active"); // Active link

            // Open parent menus
            $this
                .closest(".nav-treeview")
                .show()
                .closest(".nav-item")
                .addClass("menu-open");

            // Set active to parent link
            $this
                .closest(".nav-treeview")
                .siblings("a.nav-link")
                .addClass("active");
        }
    });
});
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
    }
}
