function responceCreateUserAction(data) {
    if (data == 200) {
        $('#modal-lg').modal('hide');
        goToPage('/user/user-info');
        successAlert('Пользователь успешно добавлен');
        return;
    }
    
    console.log(data);
    validateErrors(data);
}

function goToPage(url) {
    $('section.content').load(url);
}

function inputForm() {
    bsCustomFileInput.init();
    var form = $('#form');
    var action = form.attr('action');
    var formData = new FormData($(form)[0]);        
    $.ajax({
        type: 'post',
        url: action,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            responceCreateUserAction(data);
        }
    });
    
    return false;
}


function goToPageModal(url) {
    $('.modal-body').load(url);
}
function hideAllModal() {
    $('.modal').each(function (index, value) {
        $(value).modal('hide');
    })
}
function responceDeleteUserAction(data) {
    if (data == 200) {
        hideAllModal();
        goToPage('/user/user-info');
        successAlert('Пользователь успешно удален');
        return;
    }
    
    console.log(data);
    errorAlert('Произошла ошибка: ' + data);
}

function responceDismissUserAction(data) {
    if (data == 200) {
        hideAllModal();
        goToPage('/user/user-info');
        successAlert('Пользователь успешно уволен');
        return;
    }
    
    console.log(data);
    errorAlert('Произошла ошибка: ' + data);
}

function deleteUser(button) {
    button = $(button);
    var url = button.attr('href');
    var id = button.attr('user-id');
    var _csrf = $('meta[name="csrf-token"]').attr("content");
    var data = {
        _csrf: _csrf,
        id: id,
    };
    $.post(
        url,
        data,
        responceDeleteUserAction
    );
}

function dismissUser(button) {
    button = $(button);
    var url = button.attr('href');
    var id = button.attr('user-id');
    var _csrf = $('meta[name="csrf-token"]').attr("content");
    var data = {
        _csrf: _csrf,
        id: id,
    };
    $.post(
        url,
        data,
        responceDismissUserAction
    );
}

$(document).ready(function () {
    $(document).on('click', '#createUser' , function () {
        goToPageModal('/user/user-info/create');
    });

    $(document).on('click', '.view-user-btn', function () {
        goToPageModal($(this).prop('href'));
        return false;
    });

    $(document).on('beforeSubmit', '#form', function(){
        inputForm(this);
        return false;
    });

    $(document).on('click', '#deleteUser', function(){
        deleteUser(this);
        return false;
    });

    $(document).on('click', '#dismissUser', function(){
        dismissUser(this);
        return false;
    });
    
});