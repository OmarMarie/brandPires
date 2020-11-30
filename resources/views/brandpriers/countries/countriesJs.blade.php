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
                title: 'Flag', "mRender": function (data, type, row) {
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
                    if (row.status == 'False') {
                        return '<span class="label font-weight-bold label-lg  label-light-danger label-inline">' + row.status + '</span>'
                    } else if (row.status == 'True') {
                        return '<span class="label font-weight-bold label-lg  label-light-success label-inline">' + row.status + '</span>'
                    }
                }
            },

            /* {
                 title: 'Actions', "mRender": function (data, type, row) {
                     var edit = '<a href="#" class="btn btn-sm btn-clean btn-icon edit-btn action-btn" id="' + row.id + '"  data-toggle="tooltip" data-placement="bottom" title="View & Edit"><i class="fas fa-edit" style="color: #3699ff"></i></a>';
                     var remove = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn remove-btn"  id="' + row.id + '" data-toggle="tooltip" data-placement="bottom" title="Remove"><i class="far fa-trash-alt" style="color: #f64e60"></i></a>';
                     return edit + remove;

                 }
             }*/
        ]


    });
    $('#add').on('click', function () {

        $.ajax({
            url: '{{ route('brands.create', app()->getLocale()) }}',
            method: 'get',
            success: function (data) {
                $('.modal-body').html(data);
                $('.modal-title').text('Add Brand');
                $('#modal').modal('show');

                $('#userForm').submit(function (e) {
                    e.preventDefault();
                    var form = $(this);
                    var url = form.attr('action');
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: new FormData(this),
                        dataType: "json",
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {

                            if (data.status === 422) {
                                var error_html = '';

                                for (let value of Object.values(data.errors)) {
                                    error_html += '<div class="alert alert-danger">' + value + '</div>';
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    html: error_html,
                                })
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                table.ajax.reload();
                                $('#modal').modal('hide');

                            }
                        }
                    });

                });
            }
        });
    });

    $(document).on('click', '.edit-btn', function () {
        var id = $(this).attr('id');
        $.ajax({
            url: '/{{app()->getLocale()}}/brands/' + id + '/edit',
            type: 'get',
            success: function (data) {
                $('.modal-body').html(data);
                $('.modal-title').text('Edit Brand');
                $('#modal').modal('show');

                $('#userForm').submit(function (e) {
                    e.preventDefault();
                    var form = $(this);
                    var url = form.attr('action');
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: new FormData(this),
                        dataType: "json",
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {

                            if (data.status === 422) {
                                console.log(data);
                                var error_html = '';

                                for (let value of Object.values(data.errors)) {
                                    error_html += '<div class="alert alert-danger">' + value + '</div>';
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    html: error_html,
                                })
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                table.ajax.reload();
                                $('#modal').modal('hide');
                            }
                        }
                    });

                });
            }
        });
    });
    $(document).on('click', '.remove-btn', function () {

        var id = $(this).attr('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    url: '/{{(app()->getLocale())}}/brands/' + id,
                    method: 'delete',
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
