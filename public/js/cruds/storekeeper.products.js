columnsDataTable = [
    {data: 'id', searchable: false, className: 'dt-center', customValue: true},
    {data: 'picture_min', searchable: false, className: 'dt-center', customValue: true},
    {data: 'name'},
    {data: 'price'},
    {data: 'category.name'},
    {data: 'active', searchable: true, className: 'dt-center', customValue: true},
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
    } else if (column === 5) {
        return value ? '<i class="fa fa-check-square m--font-success"></i>' : '<i class="fa fa-window-close m--font-danger"></i>'
    }
}