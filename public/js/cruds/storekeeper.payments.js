columnsDataTable = [
    {data: 'created_at'},
    {data: 'value', className: 'dt-right', customValue: true},
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
    if (column === 1) {
        return moneyFormat(value);
    }
}