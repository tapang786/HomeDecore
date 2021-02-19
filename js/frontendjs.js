$(document).ready(function () {
	//
	//alert('sd');
	$('.filter_terms').click(function(){

		let telnt = 1;
        if($(this).is(":checked")) {
        	//
            let filter_attr = $('.filter_attr').attr('filter_attr');
            let valus = $('.filter_attr').attr('data-terms');
            if(filter_attr) {
            	//filter_attr = $('.filter_attr').attr('filter_attr');
            	filter_attr += '&'+$(this).attr('data-attr')+'[]='+$(this).attr('data-term');
            	valus += ','+$(this).attr('data-term');
            } else {
            	filter_attr = '?'+$(this).attr('data-attr')+'[]='+$(this).attr('data-term');
            	valus = $(this).attr('data-term');
            }
            $('.filter_attr').attr('data-terms', valus);
            $('.filter_attr').attr('filter_attr', filter_attr);
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + filter_attr;
            window.history.pushState({ path: newurl }, '', newurl);
        }
        else if($(this).is(":not(:checked)")){
        	//
            let filter_attr = $('.filter_attr').attr('filter_attr');
			filter_attr = filter_attr.replace("?","");
            filter_attr = filter_attr.split("&");
            let indx = filter_attr.indexOf($(this).attr('data-attr')+'[]='+$(this).attr('data-term'));
			if (indx > -1) {
				filter_attr.splice(indx, 1);
			}
			$('.filter_attr').attr('filter_attr', '?'+filter_attr.join('&'));
			var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?'+filter_attr.join('&');
            window.history.pushState({ path: newurl }, '', newurl);

            let terms = $('.filter_attr').attr('data-terms');
            terms = terms.split(",");
            let index = terms.indexOf($(this).val());
			if (index > -1) {
				terms.splice(index, 1);
			}
			$('.filter_attr').attr('data-terms', terms.toString());  

			if(terms.length == 0) {
				//$('.filter_attr').attr('data-terms');   
				$('.filter_attr').removeAttr("data-terms");   
				$('.filter_attr').removeAttr("filter_attr");   
				telnt = 0;
			}        
        }
        $('.filter_attr').attr('telnt', telnt);

		filterProducts();
    });
	$('#sortby').on('change', function() {
	    //alert( $(this).find(":selected").val() );
	    let sortby = '';
	    let filter_attr = $('.filter_attr').attr('filter_attr');
	    if(filter_attr)
	    {
	    	/*filter_attr = filter_attr.split("&");
		    let indx = filter_attr.indexOf('sortby='+$('.filter_attr').attr('data-sortby'));
		    let lnt = filter_attr.length;
		    if(indx >= 0) {
			    filter_attr[indx] = 'sortby='+$(this).find(":selected").val();
			}
			$('.filter_attr').attr('data-sortby',$(this).find(":selected").val());
			filter_attr = filter_attr.join('&');
			
			if(filter_attr.indexOf('sortby') == -1) {
	        	filter_attr += '&sortby='+$(this).find(":selected").val();
	        	//console.log($('.filter_attr').attr('filter_attr').indexOf('sortby')); 
	        }
	        if( filter_attr.indexOf('sortby') && indx == -1) {
	        	//
	        	filter_attr = '?sortby='+$(this).find(":selected").val();
	        }*/
	        let old = $('.filter_attr').attr('data-sortby');
	        if(filter_attr.indexOf('sortby') != -1) {
	        	filter_attr = filter_attr.replace(old, $(this).find(":selected").val());
	        	//console.log(sdf);
	        } else {
	        	filter_attr += '&sortby='+$(this).find(":selected").val();
	        }
	        //console.log(old);
	        console.log(filter_attr.indexOf('sortby'));

	    }
	    else {
	    	filter_attr = '?sortby='+$(this).find(":selected").val();
	    }

	    $('.filter_attr').attr('data-sortby',$(this).find(":selected").val());
        $('.filter_attr').attr('filter_attr', filter_attr);
	    var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + filter_attr;
        window.history.pushState({ path: newurl }, '', newurl);
		filterProducts();
	});

    function filterProducts() {
    	// body...
    	var formData = new FormData();
	    formData.append('_token',$('.filter_attr').attr('data-token'));
	    formData.append('filter_attr', $('.filter_attr').attr('data-terms'));
	    if(parseInt($('.filter_attr').attr('telnt')) > 0) {
	    	formData.append('filter_products', '1');
	    }
	    if($('#sortby').find(":selected").val()) {
	    	//alert($('.filter_attr').attr('data-terms'));
	    	formData.append('sortby', $('#sortby').find(":selected").val());
	    }

    	$.ajax({
			url: $('.filter_attr').attr('data-url'),
			type: 'POST',
			data: formData,
			datatype: 'JOSN',
			processData: false,
			contentType: false,
			success: function (response) {
				$('#products').html(response.products);
			},
			error: function (response) {
				console.log(response);
			}
	    });
    }
});
