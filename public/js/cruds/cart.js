columnsDataTable = [
    {data: 'picture_min', searchable: false, className: 'dt-center', customValue: true},
    {data: 'name'},
    {data: 'store.name'},
    {data: 'price', className: 'dt-right'},
    {data: 'quantity', className: 'dt-center'},
    {data: 'subtotal', className: 'dt-right'},
    {data: 'id', searchable: false, className: 'dt-center', customValue: true},
];

function minus(id) {
    let url = routes.cart.minus.url.replace(':id', id);
    ajaxRequest(url, null, routes.cart.minus.method, createRow, tablePortlet);
}

function order() {
    ajaxRequest(routes.create.url, null, routes.create.method, createRow, tablePortlet);
}

function plus(id) {
    let url = routes.cart.plus.url.replace(':id', id);
    ajaxRequest(url, null, routes.cart.plus.method, createRow, tablePortlet);
}

function remove(id) {
    let url = routes.cart.remove.url.replace(':id', id);
    ajaxRequest(url, null, routes.cart.remove.method, createRow, tablePortlet);
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
    if (column === 0) {
        return '<img width="35" height="35" src="' + value + '" class="m--img-rounded m--marginless" alt="Picture">';
    } else if (column === 6) {
        return (
            '<a onclick="plus(' + value + ')" class="m-portlet__nav-link btn m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--hover-success" title="Mas Uno">' +
                '<i class="fa fa-plus"></i>' +
            '</a>' +
            '<a onclick="minus(' + value + ')" class="m-portlet__nav-link btn m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--hover-primary" title="Menos Uno">' +
                '<i class="fa fa-minus"></i>' +
            '</a>' +
            '<a onclick="remove(' + value + ')" class="m-portlet__nav-link btn m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--hover-danger" title="Eliminar">' +
                '<i class="fa fa-trash-alt"></i>' +
            '</a>'
        );
    }
}
