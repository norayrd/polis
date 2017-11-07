//head.js(window.location.origin+"/js/utils/AjaxRequest.class.js");


$(function () {
    
    InvoiceView.init();
});

var InvoiceView = {
    init: function () {
        this.init_popup_nomen_btn();
        this.init_popup_prod_btn();
        this.init_del_btn();
    },
    init_popup_nomen_btn: function () {

        $("#popup_nomen_btn").on('click', function () {
            
            var nomenUrl = window.location.origin+'/popup-nomen-list';
            
            AjaxRequest._call('POST',nomenUrl, '', function (res) {
                $(".modal-body").html(res);
                $(".modal-footer").hide();
                $(".modal-title").text('Номенклатура');
                $("#popup_window").modal('show');
                
                $("#md_add_btn").on('click', function() {
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
                            console.log(id,isSelected,company,companyName,title);
                            var targetTblBody = $('#tbl_invoice_data').find('tbody');
                            
                            $(targetTblBody).append(
                                    '<tr> '+
                                    '   <td data-name="invoiceDataId" data-value="" class="hidden"></td>'+
                                    '   <td data-name="company" data-value="' + company + '">' + companyName + '</td>'+
                                    '   <td data-name="title">' + title + '</td>'+
                                    '   <td data-name="cost">0</td>'+
                                    '   <td data-name="count">1</td>'+
                                    '   <td data-name="sum">0</td>'+
                                    '   <td data-name="sel" data-delete="0" class="select-data"><input type="checkbox" value=""></td>'+
                                    '</tr>'
                            );
                            $('#tbl_invoice_data').editableTableWidget({editor: $('<input>')}).numericInputExample();
                            
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
                $(".modal-body").html(res);
                $('#prod_list').editableTableWidget({editor: $('<input>')}).numericInputExample();
                $(".modal-footer").hide();
                $(".modal-title").text('Наличие');
                $("#popup_window").modal('show');
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

    }
    
};

function submitBtn(invoiceSignId) { 
    $('#o_invoicesign').val(invoiceSignId);
    $('#pinvoice-form').submit();
};
