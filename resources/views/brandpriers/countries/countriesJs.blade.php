<script type="text/javascript">


    var table = $('.data-table').DataTable({
        dom: 'Bfrtip',
        "columnDefs": [
            {"width": "100px", "targets": 5},
        ],
        processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [
            [10, 25, 50, 100, -1],
            ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']
        ],
        buttons: [
            {'extend': 'pageLength'},
            {
                text: 'Reload',
                action: function (e, dt, node, config) {
                    dt.ajax.reload();
                }
            },
            {'extend': 'excel'},
            {'extend': 'print'},
            {'extend': 'pdf'}
        ],
        ajax: "{{ route('countriesDatable', app()->getLocale()) }}",
        columns: [
            {data: 'DT_RowIndex', title: 'ID'},
            {
                data: 'id', title: 'Flag', "mRender": function (data, type, row) {
                    var imgeUrl = '/flags';
                    return '<img src="' + imgeUrl + '/' + row.flag + '" class="avatar" width="50" height="50"/>';

                }
            },
            {data: 'name', title: 'Name'},
            {data: 'short_name', title: 'Short Name'},
            {
                data: 'phone_code', title: 'Phone Code', "mRender": function (data, type, row) {
                    return '<span class="label font-weight-bold label-lg   label-inline">' + '+' + row.phone_code + '</span>'

                }
            },
            {
                data: 'status', title: 'Status', "mRender": function (data, type, row) {
                    if (row.status == 'Inactive') {
                        return '<span class="btn btn-light-danger font-weight-bolder btn-sm status_change border border-danger" id="' + row.id + '" data-toggle="tooltip" data-placement="bottom" title="Status Change">' + row.status +  ' </span>'
                    } else if (row.status == 'Active') {
                        return '<span class="btn btn-light-success font-weight-bolder btn-sm status_change border border-success"  id="' + row.id + ' " data-toggle="tooltip" data-placement="bottom" title="Status Change">' + row.status + '</span>'
                    }
                }
            },

            /* {
                 title: 'Actions', "mRender": function (data, type, row) {
                     var edit = '<a href="#" class="btn btn-sm btn-clean btn-icon edit-btn action-btn" id="' + row.id + '"  data-toggle="tooltip" data-placement="bottom" title="View & Edit"><i class="fas fa-edit" ></i></a>';
                     var remove = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn remove-btn"  id="' + row.id + '" data-toggle="tooltip" data-placement="bottom" title="Remove"><i class="far fa-trash-alt" ></i></a>';
                     return edit + remove;

                 }
             }*/
        ]


    });

    $(document).on('click', '.status_change', function () {
        var id = $(this).attr('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Status change it!'
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    url: '/{{(app()->getLocale())}}/country/status/' + id,
                    method: 'get',
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Your Brands has been removed',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        table.ajax.reload();
                    }
                });
            }
        });

    });

</script>
