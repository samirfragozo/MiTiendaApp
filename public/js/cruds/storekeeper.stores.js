columnsDataTable = [
    {data: 'id', searchable: false, className: 'dt-center', customValue: true},
    {data: 'picture_min', searchable: false, className: 'dt-center', customValue: true},
    {data: 'document'},
    {data: 'name'},
    {data: 'active', searchable: true, className: 'dt-center', customValue: true},
    {data: 'actions', searchable: false, className: 'dt-center', customValue: true},
];

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
        return (
            '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">' +
            '<input class="m-checkable" name="massive[]" type="checkbox" value="' + value + '">' +
            '<span></span>' +
            '</label>'
        );
    } else if (column === 1) {
        return '<img width="35" height="35" src="' + value + '" class="m--img-rounded m--marginless" alt="Picture">';
    } else if (column === 4) {
        return '<span class="m-badge m-badge--' + (value ? 'success">✔' : 'danger">✘') + '</span>'
    } else if (column === 5) {
        return (
            '<a href="javascript:" onclick="openMap(' + value.latitude + ', ' + value.longitude + ', \'' + value.title + '\')" class="m-portlet__nav-link btn m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--hover-danger" title="Ubicación">' +
                '<i class="fa fa-map-marker-alt"></i>' +
            '</a>' +
            '<a href="' + crud + '/' + value.id + '/products" class="m-portlet__nav-link btn m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--hover-primary" title="Productos">' +
                '<i class="fa fa-shopping-basket"></i>' +
            '</a>' +
            '<a href="' + crud + '/' + value.id + '/orders" class="m-portlet__nav-link btn m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--hover-success" title="Ordenes">' +
                '<i class="fa fa-clipboard-list"></i>' +
            '</a>' +
            '<a href="' + crud + '/' + value.id + '/debts" class="m-portlet__nav-link btn m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--hover-accent" title="Deudas">' +
                '<i class="fa fa-money-bill"></i>' +
            '</a>'
        );
    }
}