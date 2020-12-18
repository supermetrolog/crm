function successAlert(message) {
    toastr.success(message);
}

function errorAlert(message) {
    toastr.error(message);
}

function validateErrors(data) {
    data = JSON.parse(data);
  
    $.each(data, function (key, value) {
      toastr.error(value);
    });
}

$(document).ready(function () {
    $(document).on('click', '[data-close-modal="close"]', function () {
        console.log('FUCK THE POLICE');
        var modal = $(this).closest('.modal');
        modal.modal('hide');
    });
});