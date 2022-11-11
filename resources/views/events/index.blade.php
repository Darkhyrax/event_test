@extends('layouts.app')

@section('css')
	
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Manage Events</div>
                <div class="card-body">
                	<button data-toggle="modal" class="btn btn-success mb-4 modalpet" modal-title="New Event" data-attr="{{ route('events.create') }}">Register event</button>
                	<table class="table table-dark table-striped table-hover" id="events-table">
				  	  <thead>
					    <tr>
					    	<th scope="col">
						    	Name
						    </th>
						    <th scope="col">
						    	Location
						    </th>
						    <th scope="col">
						    	Event Date Start
						    </th>
						    <th scope="col">
						    	Event Date End
						    </th>
						    <th scope="col">
						    	Banner
						    </th>
						    <th scope="col">
						    	Created at
						    </th>
						   <th scope="col">
						    	Updated at
						    </th>
						    <th scope="col">
						    	
						    </th>
					    </tr>
					  </thead>
					  <tbody>
					  	@foreach ($events as $event)
					  		<tr>
					  			<td>
					  				{{$event->eve_name}}
					  			</td>
					  			<td>
					  				{{$event->eve_location}}
					  			</td>
					  			<td>
					  				{{date('m-d-Y h:ia',strtotime($event->eve_date))}}
					  			</td>
					  			<td>
					  				{{date('m-d-Y h:ia',strtotime($event->eve_end_date))}}
					  			</td>
					  			<td>
					  				<button class="btn btn-primary btn-sm modalpet" data-toggle="modal" data-attr="{{ route('events.banner',$event->eve_id) }}" modal-title="{{$event->eve_name}} Banner" title="See banner"><i class="fa-solid fa-eye"></i></button>
					  			</td>
					  			<td>
					  				{{date('m-d-Y h:ia',strtotime($event->created_at))}}
					  			</td>
					  			<td>
					  				{{date('m-d-Y h:ia',strtotime($event->updated_at))}}
					  			</td>
					  			<td>
					  				<button class="btn btn-success dropdown-toggle" id="actions" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                                    <div class="dropdown-menu" aria-labelledby="actions">
                                        <a class="dropdown-item modalpet" href="javascript::void(0)" data-toggle="modal" data-attr="{{ route('events.edit',$event->eve_id) }}" modal-title="Edit {{$event->eve_name}} Information">Edit</a>
                                        <a class="dropdown-item modalpet" href="javascript::void(0)" data-toggle="modal" data-attr="{{ route('events.participants',$event->eve_id) }}" modal-title="See {{$event->eve_name}} participants">See participants</a>
                                         <a href="javascript::void(0)" class="dropdown-item delete" data-attr="{{ route('events.destroy',$event->eve_id) }}">Delete</a>
                                    </div>
					  			</td>
					  		</tr>
					  	@endforeach
					  </tbody>
					</table>
            	</div>
        	</div>
    	</div>
	</div>
</div>
@endsection

@section('js')
	<script>
		$(document).ready(function ()
		{
			$("#events-table").DataTable();

	  		$('.delete').off().click(function(e)
		    {
	           Swal.fire({  
				  title: 'Do you want delete this event?',  
				  icon: 'warning',
				  html:'<b>Note: It will remove all participants from it as well.</b>',
				  showDenyButton: false,  
				  showCancelButton: true,  
				  confirmButtonText: 'Yes',  
				  denyButtonText: 'No',
				}).then((result) => {  
				    if (result.isConfirmed) 
				    {    
				        let url = $(this).attr('data-attr');
				        e.preventDefault();

				        $.ajax({
				          url: url,
		           		  headers: {
						        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						    },
				          type : 'DELETE',
				          success: function(resp)
				          {
				              // Reload page after click ok on alert
				              Swal.fire("Success!",resp.message,"success").then(function() 
				              {
			            			location.reload(true);
								});
				          },
			              complete: function(){
			                $('.loader').fadeOut('slow');
			              },
				          error: function(xhr, ajaxOptions, thrownError) 
				          {
			                	show_alert_message('error',xhr.status,xhr.responseText);            
				          }
				         
				        });
				    }
				});
		    });
  		});
  	</script>
@endsection