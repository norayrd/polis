AjaxRequest  = {
   
   
   
   _call:function(_url,_params,_method,_responseHandler){
       $.ajax({
                type: _method,
                url: _url,
                data: _params,
                success:_responseHandler
                        
                   
                   
                });
       
       
   }
};