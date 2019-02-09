columnsDataTable = [
    {data: 'full_name'},
    {data: 'orders', className: 'dt-right'},
    {data: 'total_orders', className: 'dt-right', customValue: true},
    {data: 'payments', className: 'dt-right'},
    {data: 'total_payments', className: 'dt-right', customValue: true},
    {data: 'debt', className: 'dt-right', customValue: true},
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
    if (column === 2 || column === 4 || column === 5) {
        return moneyFormat(value)
    }
    if (column === 6) {
        return (
            '<a href="' + crud + '/' + value + '/orders" class="m-portlet__nav-link btn m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--hover-danger" title="Ordenes">' +
                '<i class="fa fa-clipboard-list"></i>' +
            '</a>' +
            '<a href="' + crud + '/' + value + '/payments" class="m-portlet__nav-link btn m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--hover-success" title="Abonos">' +
                '<i class="fa fa-money-bill"></i>' +
            '</a>'

        );
    }
}