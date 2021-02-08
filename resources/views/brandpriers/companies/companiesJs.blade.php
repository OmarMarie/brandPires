<script type="text/javascript">

    var table = $('.data-table').DataTable({
        dom: 'Bfrtip',
        "columnDefs": [
            {"width": "30px", "targets": 6},
            {
                "targets": 0,
                "className": "text-center",
            }
        ],
        processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [
            [25, 50, 100, -1],
            ['25 rows', '50 rows', '100 rows', 'Show all']
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
        ajax: "{{ route('CompanyDatable', app()->getLocale()) }}",
        columns: [
            {data: 'DT_RowIndex', title: 'ID'},
            {data: 'name', title: 'Name'},
            {data: 'email', title: 'email'},
            {data: 'phone', title: 'Phone'},
            {data: 'status', title: 'Status', "mRender": function (data, type, row) {
                    if (row.status == 'Inactive') {
                        return '<span class="label font-weight-bold label-lg  label-light-danger label-inline border border-danger">' + row.status + '</span>'
                    } else if (row.status == 'Active') {
                        return '<span class="label font-weight-bold label-lg  label-light-success label-inline border border-success">' + row.status + '</span>'
                    }
                }
            },
            {data: 'id',title: 'Services', "mRender": function (data, type, row) {
                    var contacts= '<a href="/{{app()->getLocale()}}/company/contacts/' + row.id + '"  class="btn btn-sm btn-clean btn-icon action-btn" id="' + row.id + '" data-toggle="tooltip" data-placement="bottom" title="Contacts"><i class="fas fa-id-card-alt"></i></a>'
                    var attachments= '<a href="/{{app()->getLocale()}}/company/attachments/' + row.id +'"  class="btn btn-sm btn-clean btn-icon action-btn" id="' + row.id + '" data-toggle="tooltip" data-placement="bottom" title="Attachments"><i class="fas fa-paperclip"></i></a>'
                    return contacts + attachments;
                }

            },
            {data: 'id',title: 'Actions', "mRender": function (data, type, row) {
                    var edit = '<a href="#" class="btn btn-sm btn-clean btn-icon edit-btn action-btn" id="' + row.id + '"  data-toggle="tooltip" data-placement="bottom" title="View & Edit"><i class="fas fa-edit" ></i></a>';
                    var remove = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn remove-btn"  id="' + row.id + '" data-toggle="tooltip" data-placement="bottom" title="Remove"><i class="far fa-trash-alt"></i></a>';
                    return edit ;

                }
            },
        ],



    });
    $('#add').on('click', function () {


        $.ajax({
            url: '{{ route('companies.create', app()->getLocale()) }}',
            method: 'get',
            success: function (data) {
                $('.modal-body').html(data);
                $('.modal-title').text('Add Company');
                $('#modal').modal('show');

                $('#userForm').submit(function (e) {
                    e.preventDefault();
                    /*$("#submitBtn").attr("disabled", true);*/
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
            url: '/{{app()->getLocale()}}/companies/' + id + '/edit',
            type: 'get',
            success: function (data) {
                $('.modal-body').html(data);
                $('.modal-title').text('Edit Company');
                $('#modal').modal('show');

                $('#userForm').submit(function (e) {
                    e.preventDefault();
                    $(".btn").attr("disabled", true);
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
                            title: 'Your Company has been removed',
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
