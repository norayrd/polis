/* global $ */
/* this is an example for validation and change events */
$.fn.numericInputExample = function () {
    'use strict';
    var element = $(this),
    footer = element.find('tfoot tr'),
    dataRows = element.find('tbody tr'),
    initialTotal = function () {
        var column, total;
        for (column = 3; column < footer.children().size(); column++) {
            total = 0;
            dataRows.each(function () {
                var row = $(this);
                total += parseFloat(row.children().eq(column).text());
            });
            footer.children().eq(column).text(total);
        };
    },
    initialSumm = function (row) {
        var costCol, countCol, summCol;
        costCol = 3;
        countCol = 4;
        summCol = 5;
        
        if ( row !== undefined ) {
            row.children().eq(summCol).text( row.children().eq(costCol).text() * row.children().eq(countCol).text());
            initialTotal();
        } else {
            dataRows.each(function(index){
                $(this).children().eq(summCol).text( $(this).children().eq(costCol).text() * $(this).children().eq(countCol).text());
            })
        }
    };
    element.find('td').on('change', function (evt) {
        var cell = $(this),
        column = cell.index(),
        total = 0;
        if ((column === 0) || (column === 1)) {
            return;
        }
        element.find('tbody tr').each(function () {
            var row = $(this);
            total += parseFloat(row.children().eq(column).text());
        });
        
        initialSumm(cell.parent());
        
        /*if (column === 1 && total > 5000) {
            $('.alert').show();
            return false; // changes can be rejected
        } else {
            $('.alert').hide();
            footer.children().eq(column).text(total);
        }*/
    }).on('validate', function (evt, value) {
        var cell = $(this),
        column = cell.index();
        if (column === 0) {
            return !!value && value.trim().length > 0;
        } else {
            return !isNaN(parseFloat(value)) && isFinite(value);
        }
    });
    initialSumm();
    initialTotal();
    return this;
};
