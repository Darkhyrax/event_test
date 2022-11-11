$(document).ready(function ()
{
	// Modal petitions
	$('.modalpet').off().click(function(e)
    {
            $('.loader').fadeIn('slow');
	    	$("#modal_title").text($(this).attr('modal-title'));
	    	
	        let url = $(this).attr('data-attr');
	        e.preventDefault();

	        $.ajax({
	          url: url,
	          success: function(resp)
	          {
	              $("#modal_content").html(resp);
	              $("#general_modal").modal("show"); 
	          },
              complete: function(){
                $('.loader').fadeOut('slow');
              },
	          error: function(xhr, ajaxOptions, thrownError) 
	          {
                	show_alert_message('error',xhr.status,xhr.responseText);            
	          }
	         
	        });
    });


	// Send simple forms with only requires a success message and reload (CRUD)
	$(".simpleformpet").off().submit(function( event ) 
	{
		event.preventDefault();
		var form;
		var ajaxpet;

		// Depending if contains an input file, the ajax petition will work in a different way
		if ($('input:file').length) 
		{
			form = new FormData($(this)[0]);
			ajaxpet = {
				          url: $(this).attr('action'),
				          context: this,
				          processData: false,
			              contentType: false,
				          data: form,
				          type: $(this).attr('method'),
				          dataType:'JSON',
				          success: function(resp)
				          {
				          	  // Reload page after click ok on alert
				              Swal.fire("Success!",resp.message,"success").then(function() {
			            			location.reload(true);
								});
				          },
				          error: function(xhr, ajaxOptions, thrownError) 
				          {
			          			if (xhr.status == 422) 
			          			{
			          				// Eliminate the error message of the fields that are correct
				                  	$(this).find("strong[id]").text('');
				                  	// Bootstrap style to mark that the data is correct
				                  	$(this).find('input:text, input:password, input:file, input[name="email"],select, textarea').removeClass('is-invalid').addClass('is-valid');
				              	 	// show the fields that contain errors in the form
				              	 	form_errors(xhr.responseJSON.errors);
			          			}
			          			else
			          			{
			          				show_alert_message('error',xhr.status,xhr.responseText);
			          			}
				          }
				         
			        };

		}
		else
		{
			ajaxpet = {
				          url: $(this).attr('action'),
				          context: this,
				          data: $(this).serialize(),
				          type: $(this).attr('method'),
				          dataType:'JSON',
				          success: function(resp)
				          {
				          	  // Reload page after click ok on alert
				              Swal.fire("Success!",resp.message,"success").then(function() {
			            			location.reload(true);
								});
				          },
				          error: function(xhr, ajaxOptions, thrownError) 
				          {
			          			if (xhr.status == 422) 
			          			{
			          				// Eliminate the error message of the fields that are correct
				                  	$(this).find("strong[id]").text('');
				                  	// Bootstrap style to mark that the data is correct
				                  	$(this).find('input:text, input:password, input:file, input[name="email"],select, textarea').removeClass('is-invalid').addClass('is-valid');
				              	 	// show the fields that contain errors in the form
				              	 	form_errors(xhr.responseJSON.errors);
			          			}
			          			else
			          			{
			          				show_alert_message('error',xhr.status,xhr.responseText);
			          			}
				          }
				         
	        };
		}
	  	
	  	$.ajax(ajaxpet);

	});
});

function form_errors(fields) 
{
	 $.each(fields, function(field,message)
	 {
 		$('#'+field).removeClass('is-valid');
		$('#'+field).addClass('is-invalid');
		$("#"+field+"-error").text(message);
	 });
}

function show_alert_message(type,code,message) 
{

	if (type == 'success') 
	{
		title = 'Success!';
	}
	else if(type == "error")
	{
		title = 'Oops!';
	}
	else
	{
		title = 'Warning!';
	}

	if (code == 404) 
    {
        message = "Page not found";
    }
    else if (code == 500) 
    {
        message = "There was an error processing the request, try again later.";
    }
    else if(code == 0)
    {
        message = "Request cancelled or no internet.";
    }
    
    Swal.fire(title,message,type);
}