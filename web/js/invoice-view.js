//head.js(window.location.origin+"/js/utils/AjaxRequest.class.js");


$(function () {
    
    InvoiceView.init();
});

var InvoiceView = {
    init: function () {
        this.init_popup_nomen_btn();
        this.init_popup_prod_btn();
        this.init_del_btn();
        this.init_submit_btn();
        this.select_data_uncheck();
        this.initNumberOnChange($('#tbl_invoice_data'));
        this.initTypeOnChange($('#tbl_invoice_data'));
    },
    init_popup_nomen_btn: function () {

        $("#popup_nomen_btn").on('click', function () {
            
            var nomenUrl = window.location.origin+'/popup-nomen-list';
            
            AjaxRequest._call('POST',nomenUrl, '', function (res) {
                $(".modal-body").html(res);
                $(".modal-footer").hide();
                $(".modal-title").text('Номенклатура');
                $("#popup_window").modal('show');
                
                $("#md_add_btn").unbind('click').on('click', function() {
                    $('#nomen_list >tbody >tr').each(function(rIndex){
                        var id, company, title;

                        $(this).find('td').each(function(cIndex){
                            var tdName = $(this).data('name');
                            
                            if (tdName == 'sel') {
                                id = $(this).find('input').val();
                                isSelected = $(this).find('input').is(':checked');
                            } else if (tdName == 'company') {
                                company = $(this).data('value');
                                companyName = $(this).text();
                            } else if (tdName == 'title') {
                                title = $(this).text();
                            }
                        });
                        if (isSelected) {
                            //console.log(id,isSelected,company,companyName,title);
                            var targetTblBody = $('#tbl_invoice_data').find('tbody');
                            
                            $(targetTblBody).append(
                                    '<tr> '+
                                    '   <td data-name="invoiceDataId" data-value="" class="hidden"></td>'+
                                    '   <td data-name="company" data-value="' + company + '">' + companyName + '</td>'+
                                    '   <td data-name="title">' + title + '</td>'+
                                    '   <td data-name="type"><select><option value="1">розница</option><option value="2" selected>партия</option></select></td>'+
                                    '    <td data-name="numberFrom"><input type="text" class="form-control number-from" value=""></td>'+
                                    '    <td data-name="numberTo"><input type="text" class="form-control number-to" value=""></td>'+
                                    '    <td data-name="dateFrom"><input type="text" class="form-control date-from" value=""></td>'+
                                    '    <td data-name="dateTo"><input type="text" class="form-control date-to" value=""></td>'+
                                    '   <td data-name="cost">0</td>'+
                                    '   <td data-name="count">1</td>'+
                                    '   <td data-name="sum">0</td>'+
                                    '   <td data-name="sel" data-delete="0" data-nomen="' + id + '" class="select-data"><input type="checkbox" value=""></td>'+
                                    '</tr>'
                            );
                            $('#tbl_invoice_data').editableTableWidget({editor: $('<input>')}).numericInputExample();
                            $(".date-from").mask("99.99.9999");
                            $(".date-to").mask("99.99.9999");
                            InvoiceView.initNumberOnChange($('#tbl_invoice_data'));
                        }
                        
                    });
                    $("#popup_window").modal('hide');
                    
                });
            });

        });

    },
    init_popup_prod_btn: function () {

        $("#popup_prod_btn").on('click', function () {
            
            var prodUrl = window.location.origin+'/popup-prod-list';
            
            AjaxRequest._call('POST',prodUrl, '', function (res) {
                $(".modal-content").width(1000);
                $(".modal-body").html(res);
                $('#prod_list').editableTableWidget({editor: $('<input>')}).numericInputExample();
                $(".modal-footer").hide();
                $(".modal-title").text('Наличие');
                $("#popup_window").modal('show');

                $("#md_add_btn").unbind('click').on('click', function() {
                    $('#prod_list >tbody >tr').each(function(rIndex){
                        var id, company, companyName, title, parent, dateFrom, dateTo, isSelected;
                        
                        id= $(this).find("td[data-name='sel'] >input").val();
                        isSelected = $(this).find("td[data-name='sel'] >input").is(':checked');
                        company = $(this).find("td[data-name='company']").data('value');
                        companyName = $(this).find("td[data-name='company']").text();
                        title = $(this).find("td[data-name='title']").text();
                        dateFrom = $(this).find("td[data-name='date-from']").text();
                        dateTo = $(this).find("td[data-name='date-to']").text();
                        parent = $(this).find("td[data-name='party']").data('value');
                        
                                                
                        if (isSelected) {
                            console.log(id, company, companyName, title, parent, dateFrom, dateTo, isSelected);
                            
                            var targetTblBody = $('#tbl_invoice_data').find('tbody');
                            
                            $(targetTblBody).append(
                                    '<tr> '+
                                    '   <td data-name="invoiceDataId" data-value="" class="hidden"></td>'+
                                    '   <td data-name="company" data-value="' + company + '">' + companyName + '</td>'+
                                    '   <td data-name="title">' + title + '</td>'+
                                    '   <td data-name="type"><select><option value="1" selected>розница</option><option value="2">партия</option></select></td>'+
                                    '   <td data-name="numberFrom"><input type="text" class="form-control number-from" value=""></td>'+
                                    '   <td data-name="numberTo"><input type="text" class="form-control number-to hidden" disabled value=""></td>'+
                                    '   <td data-name="dateFrom"><input type="text" class="form-control date-from" value="' + dateFrom + '"></td>'+
                                    '   <td data-name="dateTo"><input type="text" class="form-control date-to" value="' + dateTo + '"></td>'+
                                    '   <td data-name="cost">0</td>'+
                                    '   <td data-name="count">1</td>'+
                                    '   <td data-name="sum">0</td>'+
                                    '   <td data-name="sel" data-delete="0" data-nomen="' + id + '"  data-parent="' + parent + '" class="select-data"><input type="checkbox" value=""></td>'+
                                    '</tr>'
                            );
                            $('#tbl_invoice_data').editableTableWidget({editor: $('<input>')}).numericInputExample();
                            $(".date-from").mask("99.99.9999");
                            $(".date-to").mask("99.99.9999");
                            InvoiceView.initNumberOnChange($('#tbl_invoice_data'));
                            
                        }
                    });
                    $("#popup_window").modal('hide');
                    
                });
            });

        });

    },
    init_del_btn: function () {

        $("#del_btn").on('click', function () {
            $(".select-data").each(function() {
                if ($(this).find('input').is(':checked')) {
                    $(this).data('delete',1).parent().addClass('hidden');
                }
            });
            $('#tbl_invoice_data').editableTableWidget({editor: $('<input>')}).numericInputExample();
        });

        if ($('#tbl_invoice_data').data('disabled')==1) {
            $('#del_btn').addClass('disabled');
        };


    },
    
    init_submit_btn: function () {

        $(".submit-btn").on('click', function () {
            invoiceSignId = $(this).data('sign-id');
            $('#o_invoicesign').val(invoiceSignId);
            
            var actionUrl = $('#pinvoice-form').attr('action');
            
            // content of invoice
            var paramJSONData = {};
            $('#tbl_invoice_data >tbody >tr').each(function(rIndex) {
                var trObj = {};
                $(this).find('td').each(function(){
                    tdTitle = $(this).data('name');
                    var tdObj = {};
                    
                    if ((tdTitle != 'sel') && ($(this).find('input').length > 0) ) {
                        tdObj['text'] = $(this).find('input').val();
                        tdObj['value'] = $(this).find('input').val();
                    } else if ((tdTitle != 'sel') && ($(this).find('select').length > 0) ) {
                        //tdObj['text'] = $(this).find('select').text();
                        tdObj['value'] = $(this).find('select').val();
                    } else {
                        tdObj['text'] = $(this).text();
                    }
                    
                    if ($(this).data('value')) {
                        tdObj['value'] = $(this).data('value');
                    }
                    
                    if (tdTitle == 'sel') {
                        tdObj['deleted'] = $(this).data('delete');
                        tdObj['nomen'] = $(this).data('nomen');
                    }

                    trObj[tdTitle] = tdObj;
                });
                
                paramJSONData[rIndex] = trObj;

            });
            
            // header of invoice
            var paramJSON = {
                    'o_invoiceid': $('#o_invoiceid').val(),
                    'o_companyto': $('#o_companyto').val(),
                    'o_companyfrom': $('#o_companyfrom').val(),
                    'o_invoicesign': $('#o_invoicesign').val(),
                    'o_fioto': ($('#o_fioto').val()) ? $('#o_fioto').val() : '',
                    'o_fiofrom': ($('#o_fiofrom').val()) ? $('#o_fiofrom').val() : '',
                    'o_type': $('#o_type').val(),
                    'o_person': $('#o_person').val(),
                    'o_backreason': $('#o_backreason').val(),
                    'content': paramJSONData
                };
                
            var paramData = 'paramdata=' + JSON.stringify(paramJSON);

            AjaxRequest._call('POST',actionUrl, paramData, 
                function (res) {
                    // show success message
                },
                function (res) {
                    // show error message
                },
                function () {
                    document.location.href = window.location.origin+'/invoice-list';
                }
            );

            return false;
        });

    },
    select_data_uncheck: function(){
        $('.select-data').find('input').each(function(){
            $(this).removeAttr('checked');
        });
        
    },
    initNumberOnChange: function(obj) {
        if ($(obj).is('table') ) {
            $(obj).find('tbody >tr').each( function() {
                //console.log($(this).find('.number-from').val());
                $(this).find('.number-from').unbind('keyup').on('keyup', InvoiceView.numberOnChange);
                $(this).find('.number-to').unbind('keyup').on('keyup',InvoiceView.numberOnChange);
            });
        } else if ($(obj).is('tr') ) {
            console.log('2');
        }

    },
    numberOnChange: function() {
        var row = $(this).parent().parent();
        var numberFrom = $(row).find('.number-from').val();
        var numberTo = $(row).find('.number-to').val();
        var dataType = $(row).find('td[data-name="type"] >select').val();
        var nfrom = 0;
        var nto = 0;
        var prefix = '';
        
        if (dataType == 1) {
            $(row).find("td[data-name='count']").html(1);
        } else if (numberFrom.length == numberTo.length) {
            
            for(i=0; i<numberFrom.length; i++) {
                if (numberFrom[i] == numberTo[i]) {
                    prefix = prefix + numberFrom[i];
                } else {
                    break;
                }
            }
            
            nfrom = numberFrom.substring(prefix.length,numberFrom.length);
            nto = numberTo.substring(prefix.length, numberTo.length);
            
            ncount = nto - nfrom + 1;
            
            if (!isNaN(ncount) && (ncount > 0)) {
                $(row).find("td[data-name='count']").html(ncount);
            } else {
                $(row).find("td[data-name='count']").html(0);
            }
            
        } else {
            $(row).find("td[data-name='count']").html(0);
        }
        
        InvoiceView.initNumberOnChange($('#tbl_invoice_data'));
        
    },
    initTypeOnChange: function(obj) {
        if ($(obj).is('table') ) {
            $(obj).find('tbody >tr').each( function() {
                $(this).find("td[data-name='type'] >select").unbind('change').on('change', function() {
                    if ($(this).val() == 1) {
                        $(this).closest('tr').find("td[data-name='count']").html(1);
                        $(this).closest('tr').find(".number-to").prop("disabled", true);
                        $(this).closest('tr').find(".number-to").addClass("hidden");
                    } else {
                        $(this).closest('tr').find('.number-from').keyup();
                        $(this).closest('tr').find(".number-to").prop("disabled", false);
                        $(this).closest('tr').find(".number-to").removeClass("hidden");
                    };
                });
            });
        }

    },

};

