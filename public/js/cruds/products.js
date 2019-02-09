columnsDataTable = [
    {data: 'picture_min', searchable: false, className: 'dt-center', customValue: true},
    {data: 'name'},
    {data: 'price', searchable: false, className: 'dt-right', customValue: true},
    {data: 'category.name'},
    {data: 'description'},
    {data: 'id', searchable: false, className: 'dt-center', customValue: true},
];

function add(id) {
    let url = routes.cart.add.url.replace(':id', id);
    ajaxRequest(url, null, routes.cart.add.method, showMessage, tablePortlet);
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
    } else if (column === 2) {
        return moneyFormat(value)
    } else if (column === 5) {
        return (
            '<a onclick="add(' + value + ')" class="m-portlet__nav-link btn m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--hover-primary" title="Agregar al Carro">' +
                '<i class="fa fa-cart-plus"></i>' +
            '</a>'
        );
    }
}
