columnsDataTable = [
    {data: 'picture_min', searchable: false, className: 'dt-center', customValue: true},
    {data: 'name'},
    {data: 'address'},
    {data: 'neighborhood'},
    {data: 'phone'},
    {data: 'cellphone'},
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
        return '<img width="35" height="35" src="' + value + '" class="m--img-rounded m--marginless" alt="Picture">';
    } else if (column === 6) {
        return (
            '<a href="javascript:" onclick="openMap(' + value.latitude + ', ' + value.longitude + ', \'' + value.title + '\')" class="m-portlet__nav-link btn m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--hover-danger" title="Ubicación">' +
                '<i class="fa fa-map-marker-alt"></i>' +
            '</a>' +
            '<a href="' + crud + '/' + value.id + '/products" class="m-portlet__nav-link btn m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--hover-primary" title="Productos">' +
                '<i class="fa fa-shopping-basket"></i>' +
            '</a>'
        );
    }
}