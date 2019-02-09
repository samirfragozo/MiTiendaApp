columnsDataTable = [
    {data: 'picture_min', searchable: false, className: 'dt-center', customValue: true},
    {data: 'name'},
    {data: 'historical_price', searchable: false, className: 'dt-right', customValue: true},
    {data: 'quantity', searchable: false, className: 'dt-right'},
    {data: 'subtotal', searchable: false, className: 'dt-right', customValue: true},
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
    } else if (column === 2 || column === 4) {
        return moneyFormat(value);
    }
}
