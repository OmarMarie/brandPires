<script type="text/javascript">


    var table = $('.data-table').DataTable({
        dom: 'Bfrtip',
        "columnDefs": [
            {"width": "50px", "targets": 5},
        ],
        processing: true,
        serverSide: true,
        data: {
            "brand_id": $('#brand_id').val()
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
            url: "{{ route('companyPackagesDatable', app()->getLocale()) }}",
            type: "get",
            data: {
                "brand_id": $('#brand_id').val()
            }
        },
        columns: [
            {data: 'DT_RowIndex', title: 'ID'},
            {
                title: 'Package', "mRender": function (data, type, row) {
                    return '<span class="font-weight-bold text-warning ">' + row.package + '</span>'

                }
            },

            {
                title: 'Services', "mRender": function (data, type, row) {
                    var campaigns = '<a href="/{{app()->getLocale()}}/campaigns/' + $('#brand_id').val() +'/'+ row.id + '"  class="btn btn-sm btn-clean btn-icon action-btn" id="' + row.id + '" data-toggle="tooltip" data-placement="bottom" title="Campaigns"><i class="fas fa-volleyball-ball"></i></a>'
                    return campaigns ;
                }

            },
            {data: 'created_at', title: 'Created at'},
            {
                title: 'Expiry Date', "mRender": function (data, type, row) {
                    if (row.expiry == null)
                    {return '<span class="font-weight-bold text-success">Not Start</span>'}
                    else  if ( row.expiry == 'True')
                    {return '<span class="font-weight-bold text-danger"> Expiry </span>'}
                    else
                    { return '<span class="font-weight-bold text-warning">' + row.expiry_date + '</span>'}

                }
            },
            {
                title: 'Actions', "mRender": function (data, type, row) {
                    var remove = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn remove-btn"  id="' + row.id + '" data-toggle="tooltip" data-placement="bottom" title="Remove"><i class="far fa-trash-alt" style="color: #f64e60"></i></a>';
                    return   remove;

                }
            }
        ]


    });

    $('#add').on('click', function () {
       var brand_id= $('#brand_id').val()
        $.ajax({
            url: '/{{app()->getLocale()}}/packages/' + brand_id + '/create',
            method: 'get',
            success: function (data) {
                $('.modal-body').html(data);
                $('.modal-title').text('Add Campaign');
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
                    url: '/{{(app()->getLocale())}}/brand/packages/' + id,
                    method: 'delete',
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Your Packages has been removed',
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
