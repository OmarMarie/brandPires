<script type="text/javascript">


    var table = $('.data-table').DataTable({

        dom: 'Bfrtip',
        "columnDefs": [

            {"width": "170px", "targets": 6},
            {"targets": 0, "className": "text-center",}
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
        ajax: "{{ route('logUsersDatable', app()->getLocale()) }}",
        columns: [
            {data: 'DT_RowIndex', title: 'ID'},
            {data: 'user_id', title: 'Name'},
            {data: 'login_ip', title: 'Login Ip'},
            {data: 'country', title: 'Country'},
            {data: 'city', title: 'City'},
            {data: 'region', title: 'Region'},
            {data: 'created_at', title: 'Created at'},
        ]
    });


</script>
