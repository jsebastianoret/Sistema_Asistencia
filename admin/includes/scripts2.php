<style>
    /* Personalizacion del paginador */
    .dataTables_wrapper .dataTables_paginate {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 10px !important;
        font-family: 'Poppins', sans-serif;
    }

    .dataTables_paginate .pagination {
        border-radius: 0.5rem;
    }

    .dataTables_paginate .pagination li {
        margin: 0.25rem;
    }

    .dataTables_paginate .pagination .previous {
        background-color: #54AF0C;
    }

    .dataTables_paginate .pagination .next {
        background-color: #54AF0C;
    }

    .dataTables_paginate .pagination li a {
        background-color: transparent;
        text-decoration: none;
        color: #fff;
        border: none;
    }

    .dataTables_paginate .pagination li.active {
        background-color: #54AF0C;
        color: #fff;
    }

    .dataTables_paginate .paginate_button {
        border-radius: 17px;
        background-color: #1E4DA9;
        cursor: pointer;
        color: black;
        font-family: "Poppins", sans-serif;
    }

    .dataTables_info {
        font-family: 'Poppins', sans-serif;
    }

    div.dataTables_wrapper div.dataTables_info {
        padding-top: 21px;
    }

    .dataTables_length label {
        font-family: "Poppins", sans-serif;
    }

    .dataTables_filter label {
        font-family: "Poppins", sans-serif;
    }

    .pagination li a:focus {
        outline: none;
        box-shadow: none;
    }
</style>

<script>
$(document).ready(function() {
    var table = $('#example1').DataTable({
        "pagingType": "simple_numbers",
        "lengthMenu": [
            [9, 18, 27, -1],
            [9, 18, 27, "All"]
        ],
        initComplete: function() {
            var api = this.api();

            $('#filter-rojo').on('click', function() {
                api.columns(0).search('').draw();
                filtrarDias(api, 0, 7);
            });

            $('#filter-gold').on('click', function() {
                api.columns(0).search('').draw();
                filtrarDias(api, 8, 14);
            });

            $('#filter-verde').on('click', function() {
                api.columns(0).search('').draw();
                filtrarDias(api, 15, 21);
            });
        }
    });

    function filtrarDias(api, diasMin, diasMax) {
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var dias = parseInt($(api.row(dataIndex).node()).attr('data-days'));
                if (dias >= diasMin && dias <= diasMax) {
                    return true;
                }
                return false;
            }
        );
        api.draw();

        $.fn.dataTable.ext.search.pop();
    }
});
    </script>