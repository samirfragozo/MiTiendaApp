columnsDataTable = [
    {data: 'full_name'},
    {data: 'orders', className: 'dt-center'},
    {data: 'debt', className: 'dt-center'},
    {data: 'id', searchable: false, className: 'dt-center', customValue: true},
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
    if (column === 3) {
        return (
            '<a href="' + crud + '/' + value + '/orders" class="m-portlet__nav-link btn m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--hover-success" title="Ordenes">' +
            '<i class="fa fa-clipboard-list"></i>' +
            '</a>'
        );
    }
}