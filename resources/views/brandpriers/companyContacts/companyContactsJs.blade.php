<script type="text/javascript">


    var table = $('.data-table').DataTable({
        dom: 'Bfrtip',
        "columnDefs": [
            {"width": "50px", "targets": 5},
        ],
        processing: true,
        serverSide: true,
        responsive: true,
        data: {
            "company_id": $('#company_id').val()
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
            url: "{{ route('contactsDatable', app()->getLocale()) }}",
            type: "get",
            data: {
                "company_id": $('#company_id').val()
            }
        },
        columns: [
            {data: 'DT_RowIndex', title: 'ID'},
            {data: 'name', title: 'Name'},
            {
                title: 'Job Title', "mRender": function (data, type, row) {
                    return '<span class="font-weight-bold text-info ">' + row.job_title + '</span>'

                }
            },
            {data: 'phone', title: 'Phone'},
            {data: 'email', title: 'Email'},
            {
                data: 'id', title: 'Actions', "mRender": function (data, type, row) {
                    var remove = '<a href="#" class="btn btn-sm btn-clean btn-icon action-btn remove-btn"  id="' + row.id + '" data-toggle="tooltip" data-placement="bottom" title="Remove"><i class="far fa-trash-alt" ></i></a>';
                    return   remove;

                }
            }
        ]


    });

    $('#add').on('click', function () {
       var company_id= $('#company_id').val()
        $.ajax({
            url: '/{{app()->getLocale()}}/contacts/' + company_id + '/create',
            method: 'get',
            success: function (data) {
                $('.modal-body').html(data);
                $('.modal-title').text('Add Contact');
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
                                $('#modal').modal('hide');
                                table.ajax.reload();


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
                    url: '/{{(app()->getLocale())}}/contacts/' + id,
                    method: 'delete',
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Your Contact has been removed',
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
