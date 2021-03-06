$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').prop('content')
    }
});

let crud = window.location.pathname,
    form = $('#form'),
    formButton = $('#formButton'),
    formPortlet = $('#form-portlet'),
    formReset = $('#formReset'),
    formTitle = $('#formTitle'),
    routes = {
        cart: {
            add: {
                url : crud + '/:id/add',
                method : 'GET'
            },
            minus: {
                url : crud + '/:id/minus',
                method : 'GET'
            },
            plus: {
                url : crud + '/:id/plus',
                method : 'GET'
            },
            remove: {
                url : crud + '/:id/remove',
                method : 'GET'
            },
        },
        create: {
            url : crud,
            method : 'POST'
        },
        data: {
            url : crud,
            method : 'GET'
        },
        select: {
            url : '/select',
            method : 'GET'
        },
        show: {
            url : crud + '/:id',
            method : 'GET'
        },
        status: {
            url : crud + '/status',
            method : 'POST'
        },
        update: {
            url : crud + '/:id',
            method : 'PUT'
        }
    },
    table = $('#table'),
    tablePortlet = $('#table-portlet'),
    title = formTitle.attr('data-title');

function ajaxRequest(url, data, method, callback, element) {
    block(element);

    if(method === 'PUT'){
        method = 'POST';
        data.append('_method', 'PUT');
    } else if(method === 'DELETE') {
        method = 'POST';
        if(data === null){
            data = new FormData();
            data.append('_method', 'DELETE');
        }
    }

    $.ajax({
        url: url,
        data: data,
        dataType: "json",
        method: method,
        processData: false,
        contentType: false,
        success: function (results) {
            $('#validations').addClass('m--hide');
            callback(results);
        },
        error: function(results){
            if(results.status === 422){
                showValidations(results.responseJSON.errors);
            }
        },
        fail: function (results) {
            showMessage(results, true);
        },
        complete: function(){
            unblock(element);
        }
    });
}

function block(element){
    mApp.block(element, {});
}
function disableForm(disabled = true, buttons = disabled) {
    form.find('input, textarea').prop('disabled', disabled);
    form.find('.only-view').prop('readonly', true);
    form.find('.switch').bootstrapSwitch('readonly', disabled);
    form.find('button').prop('disabled', disabled);
    formButton.prop('disabled', buttons);
    formReset.prop('disabled', buttons);
}

formButton.on("click", function () {
    let id = $('#id_form').val();
    let action = formButton.attr('data-action');
    let formData = new FormData(form[0]);

    if (action === 'create' || action === 'creating') {
        ajaxRequest(routes['create'].url, formData, routes['create'].method, createRow, formPortlet);
    } else if (action === 'show') {
        disableForm(false);
        $('#form .form-group:first .form-control').focus();
        formReset.removeClass("m--hide");
        formTitle.html(Lang.get('cruds/base.titles.update', {name: $('#name_form').val()}));
        formButton.html(Lang.get('cruds/base.buttons.update')).attr('data-action', 'update');
    } else {
        let url = routes['update'].url.replace(':id', id);
        ajaxRequest(url, formData, routes['update'].method, createRow, formPortlet);
    }
});

formReset.on("click", function () {
    let action = formButton.attr('data-action');

    if (action === 'update') {
        show($('#id_form').val());
    } else if (action === 'creating' && table.length === 0) {
        window.location.href = "/home";
    } else {
        dataTable.rows().deselect();
        resetForm('creating');
    }
});

function resetForm(action = 'create', name) {
    $('#id_form').val(0);
    form[0].reset();

    if (action === 'create') {
        disableForm(false);
        action = 'creating';
        formReset.removeClass("m--hide");
        formTitle.html(Lang.get('cruds/base.titles.create'));
    } else if (action === 'creating') {
        disableForm(true, true);
        formReset.removeClass("m--hide");
        formTitle.html(null);
    } else if (action === 'show') {
        disableForm(true, false);
        formReset.addClass("m--hide");
        formTitle.html(Lang.get('cruds/base.titles.show', {name: name}));
    }

    formButton.html(Lang.get('cruds/base.buttons.' + action)).attr('data-action', action);
    $('span[name=form-error]').remove();
    $('#validations').addClass('m--hide');
    form.find('select').selectpicker('refresh');
}

function showMessage(message, error = false) {
    if (error) toastr.error(message);
    else toastr.success(message);
}

function showValidations(errors) {
    $('#validations').removeClass('m--hide');
    $('span[name=form-error]').remove();

    for (let error in errors) {
        if (errors.hasOwnProperty(error)) {
            $('#' + error + '_form').parents('div .form-group').append('<span class="m--font-danger" name="form-error">' + errors[error] + '</span>')
        }
    }
}

function unblock(element){
    mApp.unblock(element, {});
}

function moneyFormat(value){
    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
    });

    return formatter.format(value);
}

//Init select picker
$(".m_selectpicker").selectpicker();

//Init wizard
let wizard = new mWizard('m_wizard', {
    startStep: 1
});

$('.m-wizard__step-number').on('click', function() {
    let step = $(this).children().html();
    try { wizard.goTo(step); } catch (e){}
});

$('.select-reload').on('click', function() {
    dataSelect($(this));
});

$('#picture_form').on('change', function(){
    if (this.files && this.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#preview')
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(this.files[0]);
    }
});

function dataSelect(reload) {
    let select = reload.parent().siblings('div').children('select');
    let url = routes['select'].url + '?id=' + select.attr('id') + '&name=' + select.attr('name');
    ajaxRequest(url, null, routes['select'].method, reloadSelect, formPortlet);
}

function reloadSelect(results) {
    let select =  $('#' + results.id);
    select.empty();
    select.append($('<option>', {
        value: '',
        text : Lang.get('cruds/base.placeholder')
    }));
    $.each(results.data, function(key, value) {
        select.append($('<option>', {
            value: key,
            text : value
        }));
    });
    select.selectpicker('refresh');
}

$(document).ready( function () {
    $('.select-reload').each(function() {
        dataSelect($(this));
    });

    $('li.m-menu__item > div > ul > li.m-menu__item--active').parents('li.m-menu__item').addClass('m-menu__item--open m-menu__item--expanded');

    if (form.length !== 0) disableForm(true);
    if (table.length === 0) ajaxRequest(routes.data.url, null, routes.data.method, show, formPortlet);
});

function storekeeper(result) {
    if (result == null) ajaxRequest('/storekeeper', null, 'GET', storekeeper, formPortlet);
    else {
        if (result.message) showMessage(result.message);
        location.reload();
    }
}
