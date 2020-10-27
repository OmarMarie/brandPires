<script type="text/javascript">

    $(document).on('click', '.myImg', function () {
        var modal = document.getElementById("myModal");
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
    });
    $(document).on('click', '.close', function () {
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    });

    $('#add').on('click', function () {
       var company_id= $('#company_id').val()
        $.ajax({
            url: '/{{app()->getLocale()}}/attachments/' + company_id + '/edit',
            method: 'get',
            success: function (data) {
                $('.modal-body').html(data);
                $('.modal-title').text('Edit Attachment');
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
                                $('#modal').modal('hide');
                                location.reload();

                            }
                        }
                    });

                });
            }
        });
    });

</script>
