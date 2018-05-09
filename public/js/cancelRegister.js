$('.btnHuy').on('click', function (event) {
    event.preventDefault();
    $('#cancel-modal').modal();
});

var wantDelete = 0;
$('#modal-save').on('click', function () {
    wantDelete = 1;
    $.ajax({
        method: 'POST',
        url: urlCancel,
        data: {
            wantDelete: wantDelete,
            _token: token
        },
        success: function () {
            window.location.href = project_url;
        }
    })
        .done(function (msg) {
            $('#cancel-modal').modal('hide');
        });
});
