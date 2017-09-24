AjaxRequest  = {
   
    _call:function( _method, _url, _data, _successHandler, _errorHandler, _completeHandler){
        $.ajax({
                type: _method,
                url: _url,
                data: _data,
                success:_successHandler,
                error: _errorHandler,
                complete: _completeHandler,
            });

	//beforeSend, 
	//error, 
	//dataFilter
	//success
	//complete
       
    }
};