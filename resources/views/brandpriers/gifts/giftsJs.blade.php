<script type="text/javascript">


    var table = $('.data-table').DataTable({

        dom: 'Bfrtip',
        "columnDefs": [
            {"width": "50px", "targets": 7},
        ],
        processing: true,
        serverSide: true,
        responsive: true,
        data: {
            "campaign_id": $('#campaign_id').val()
        },
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
        ajax: {
            url: "{{ route('giftsDatable', app()->getLocale()) }}",
            type: "get",
            data: {
                "campaign_id": $('#campaign_id').val()
            }
        },

        columns: [
            {data: 'DT_RowIndex', title: 'ID'},
            {data: 'name', title: 'Name'},
            {
                data: 'id',title: 'Code Number', "mRender": function (data, type, row) {
                    return '<span class="font-weight-bold text-warning ">' + row.code_number + '</span>'

                }
            },
            {
                data: 'id',title: 'Gift From', "mRender": function (data, type, row) {
                    return '<span class="font-weight-bold text-success">' + row.gift_from + '</span>'

                }
            },
            {
                data: 'id',title: 'Center', "mRender": function (data, type, row) {
                    return '<span class="font-weight-bold text-danger">' + row.center + ' </span>'

                }
            },
            {data: 'country_id', title: 'Country'},
            {data: 'city_id', title: 'City'},
            {
                title: 'Actions', "mRender": function (data, type, row) {
                    var edit = '<a href="#" class="btn btn-sm btn-clean btn-icon edit-user-btn action-btn" id="' + row.id + '"  title="View & Edit"><i class="fas fa-edit" ></i></a>';
                    var remove = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn remove-levels-btn"  id="' + row.id + '" title="Remove"><i class="far fa-trash-alt" ></i></a>';
                    return edit ;

                }
            }
        ]
    });


    $('#add').on('click', function () {
        campaign_id = $('#campaign_id').val()
        $.ajax({
            url: '/{{app()->getLocale()}}/gifts/create/' + campaign_id ,
            method: 'get',
            success: function (data) {
                $('.modal-body').html(data);
                $('.modal-title').text('Add Gift');
                $('#modal').modal('show');
                $('#form').submit(function (e) {
                    e.preventDefault();
                   // $(".btn").attr("disabled", true);
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
    $(document).on('click', '.edit-user-btn', function () {
        var id = $(this).attr('id');
        $.ajax({
            url: '/{{app()->getLocale()}}/gifts/' + id + '/edit',
            type: 'get',
            success: function (data) {
                $('.modal-body').html(data);
                $('.modal-title').text('Edit Gift');
                $('#modal').modal('show');

                $('#form').submit(function (e) {
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
    $(document).on('click', '.remove-levels-btn', function () {

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
                    url: '/{{(app()->getLocale())}}/levels/' + id,
                    method: 'delete',
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Your levels has been removed',
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
