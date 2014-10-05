//for cordinated AJAX requests

	

	 multifetch=function(AJAX){

		multifetch.prototype.list.push(AJAX);
		if(multifetch.prototype.list.length==1)
			multifetch.prototype.next();

 					}


	 multifetch.prototype.list=[];
	multifetch.prototype.next=function() {
		if(multifetch.prototype.list.length){

		$.ajax(multifetch.prototype.list.shift()).done(function(){
		
		multifetch.prototype.next();
									});

						   }
						 };
