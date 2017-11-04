//head.js(window.location.origin+"/js/utils/AjaxRequest.class.js");


$(function () {
    
    InvoiceView.init();
});

var InvoiceView = {
    init: function () {
        
        this.init_popup_nomen_btn();

    },
    init_popup_nomen_btn: function () {

        $("#popup_nomen_btn").on('click', function () {
            
            var nomenUrl = window.location.origin+'/popup-nomen-list';
            
            AjaxRequest._call('POST',nomenUrl, '', function (res) {
                $(".modal-body").html(res);
                $(".modal-footer").hide();
                $(".modal-title").text('Номенклатура');
                $("#popup_nomen_window").modal('show');
            });

        });

    }
    
};

function submitBtn(invoiceSignId) { 
    $('#o_invoicesign').val(invoiceSignId);
    $('#pinvoice-form').submit();
};

function addFromNomen(products) { 


};
