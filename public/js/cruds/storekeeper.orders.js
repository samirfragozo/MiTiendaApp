columnsDataTable = [
    {data: 'created_at'},
    {data: 'user.full_name', searchable: false},
    {data: 'quantity', searchable: false, className: 'dt-right'},
    {data: 'total', searchable: false, className: 'dt-right', customValue: true},
    {data: 'translated_status', searchable: false, className: 'dt-center', customValue: true},
    {data: 'actions', searchable: false, className: 'dt-center', customValue: true},
];

function status(id, next) {
    let formData = new FormData();
    formData.append('status', next);
    formData.append('order', id);

    let url = routes.update.url.replace(':id', '');
    ajaxRequest(url, formData, routes.update.method, createRow, tablePortlet);
}

/**
 * Custom value for status column
 *
 * @param {Number} column - The column number, starting on zero.
 * @param {String} value - The custom value.
 *
 * @returns {String} The HTML string with the status
 */
function getStatus(column, value) {
    if (column === 4) {
        return '<span class="m-badge m-badge--' + value.class + ' m-badge--wide">' + value.status + '</span>';
    } else if (column === 3) {
        return moneyFormat(value)
    } else if (column === 5) {
        let actions = '';

        if (value.cancel) {
            actions =
                '<a onclick="status(' + value.id + ',\'cancelled\')" class="m-portlet__nav-link btn m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--hover-danger" title="Cancelar">' +
                '<i class="fa fa-window-close"></i>' +
                '</a>'
            ;
        }

        if (value.next === 'dispatched') {
            actions +=
                '<a onclick="status(' + value.id + ',\'' + value.next + '\')" class="m-portlet__nav-link btn m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--hover-info" title="Enviado">' +
                '<i class="fa fa-motorcycle"></i>' +
                '</a>'
            ;
        } else if (value.next === 'delivered') {
            actions +=
                '<a onclick="status(' + value.id + ',\'' + value.next + '\')" class="m-portlet__nav-link btn m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--hover-success" title="Entregado">' +
                '<i class="fa fa-user-check"></i>' +
                '</a>'
            ;
        }

        actions +=
            '<a href="' + crud + '/' + value.id + '/products" class="m-portlet__nav-link btn m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--hover-primary" title="Productos">' +
            '<i class="fa fa-shopping-basket"></i>' +
            '</a>'
        ;
        return actions;
    }
}