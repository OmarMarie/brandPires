<script type="text/javascript">


    var table = $('.data-table').DataTable({
        dom: 'Bfrtip',
        "columnDefs": [
            {"width": "50px", "targets": 5},
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
        ajax: "{{ route('brandsDatable', app()->getLocale()) }}",
        columns: [
            {data: 'DT_RowIndex', title: 'ID'},
            {data: 'brand_name', title: 'Name'},
            {data: 'id',title: 'Company Name', "mRender": function (data, type, row) {
                    return '<span class="font-weight-bold text-success">' + row.company_id + ' </span>'

                }
            },
            {data: 'id',title: 'Services', "mRender": function (data, type, row) {
                    var packages = '<a href="/{{app()->getLocale()}}/brand/packages/' + row.id + '"  class="btn btn-sm btn-clean btn-icon action-btn" id="' + row.id + '" data-toggle="tooltip" data-placement="bottom" title="Packages"><i class="fas fa-box-open"></i></a>'
                    var attachments = '<a href="/{{app()->getLocale()}}/brand/attachments/' + row.id + '"  class="btn btn-sm btn-clean btn-icon action-btn" id="' + row.id + '" data-toggle="tooltip" data-placement="bottom" title="Attachments"><i class="fas fa-paperclip"></i></a>'
                    return packages + attachments;
                }

            },
            {data: 'id',data: 'status', title: 'Status', "mRender": function (data, type, row) {
                    if (row.status == 'False') {
                        return '<span class="label font-weight-bold label-lg  label-light-danger label-inline">' + row.status + '</span>'
                    } else if (row.status == 'True') {
                        return '<span class="label font-weight-bold label-lg  label-light-success label-inline">' + row.status + '</span>'
                    }
                }
            },

            {data: 'id',title: 'Actions', "mRender": function (data, type, row) {
                    var edit = '<a href="#" class="btn btn-sm btn-clean btn-icon edit-btn action-btn" id="' + row.id + '"  data-toggle="tooltip" data-placement="bottom" title="View & Edit"><i class="fas fa-edit" style="color: #3699ff"></i></a>';
                    var remove = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn remove-btn"  id="' + row.id + '" data-toggle="tooltip" data-placement="bottom" title="Remove"><i class="far fa-trash-alt" style="color: #f64e60"></i></a>';
                    return edit + remove;

                }
            }
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
                    $("#submitBtn").attr("disabled", true);
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
                                $("#submitBtn").attr("disabled", false);
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
                    $(".btn").attr("disabled", true);
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
                                $(".btn").attr("disabled", false);
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
