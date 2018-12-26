columnsDataTable = [
    {data: 'created_at'},
    {data: 'store.name'},
    {data: 'quantity', searchable: false, className: 'dt-center'},
    {data: 'total', searchable: false, className: 'dt-center'},
    {data: 'translated_status', searchable: false, className: 'dt-center', customValue: true},
    {data: 'actions_user', searchable: false, className: 'dt-center', customValue: true},
];

function cancel(id) {
    let formData = new FormData();

    let url = routes.update.url.replace(':id', id);
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
    } else if (column === 5) {
        let actions = '';

        if (value.cancel) {
            actions =
                '<a onclick="cancel(' + value.id + ')" class="m-portlet__nav-link btn m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--hover-danger" title="Cancelar">' +
                    '<i class="fa fa-window-close"></i>' +
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