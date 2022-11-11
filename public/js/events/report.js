$(document).ready(function ()
{
	$("#event").select2();

	$("#event_report_form").submit(function( event ) 
	{
		event.preventDefault();
	  	
	  	$("#preview").hide();
	  	$("#preview").html('');
	  	$("#load").show();

	  	$.ajax({
	          url: $(this).attr('action'),
	          context: this,
	          data: $(this).serialize(),
	          type: $(this).attr('method'),
	          dataType:'JSON',
	          complete: function()
	          {
      				$("#load").hide();
	          },
	          success: function(resp)
	          {
	          		// Eliminate the error message of the fields that are correct
          			$(this).find("strong[id]").text('');
                  	// Bootstrap style to mark that the data is correct
                  	$(this).find('input:text, input:password, input:file, input[name="email"],select, textarea').removeClass('is-invalid is-valid');
	              	$("#preview").show();
	              	$("#preview").html(resp.view);
	              	
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
	         
        });
	});
});