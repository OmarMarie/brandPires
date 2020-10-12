<script type="text/javascript">


    var table = $('.data-table').DataTable({

        dom: 'Bfrtip',
        "columnDefs": [

            {"width": "170px", "targets": 4},
        ],
        processing: true,
        serverSide: true,
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
        ajax: "{{ route('bubblesTransferActionsDatable', app()->getLocale()) }}",
        columns: [
            {data: 'DT_RowIndex', title: 'ID'},
            {data: 'player_id', title: 'Playe Name'},
            {data: 'player_tank_id', title: 'Player Tank'},
            {data: 'bubbles_number', title: 'Bubbles Number'},
            {data: 'created_at', title: 'Created at'},
        ]
    });


</script>