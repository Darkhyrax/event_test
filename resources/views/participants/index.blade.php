@extends('layouts.app')

@section('css')
	
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Manage Participants</div>
                <div class="card-body">
                	<button data-toggle="modal" class="btn btn-success mb-4 modalpet" modal-title="New Participant" data-attr="{{ route('participants.create') }}">Register participant</button>

                	<table class="table table-dark table-striped table-hover" id="participants-table">
				  	  <thead>
					    <tr>
					    	<th scope="col">
						    	First Name
						    </th>
						    <th scope="col">
						    	Family Name
						    </th>
						    <th scope="col">
						    	Birth Date
						    </th>
						    <th scope="col">
						    	Email
						    </th>
						    <th scope="col">
						    	Is Active?
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
					  	@foreach ($participants as $participant)
					  		<tr>
					  			<td>
					  				{{$participant->part_first_name}}
					  			</td>
					  			<td>
					  				{{$participant->part_family_name}}
					  			</td>
					  			<td>
					  				{{$participant->part_birth_date ? date('m-d-Y',strtotime($participant->part_birth_date)) : 'No data'}}
					  			</td>
					  			<td>
					  				{{$participant->user->email}}
					  			</td>
					  			<td>
					  				{{$participant->user->active ? 'Yes' : 'No'}}
					  			</td>
					  			<td>
					  				{{date('m-d-Y h:ia',strtotime($participant->created_at))}}
					  			</td>
					  			<td>
					  				{{date('m-d-Y h:ia',strtotime($participant->updated_at))}}
					  			</td>
					  			<td>
					  				<button class="btn btn-success dropdown-toggle" id="acciones" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                                    <div class="dropdown-menu" aria-labelledby="acciones">
                                        <a class="dropdown-item modalpet" href="javascript::void(0)" data-toggle="modal" data-attr="{{ route('participants.edit',$participant->part_id) }}" modal-title="Edit {{$participant->part_first_name}} {{$participant->part_family_name}} Information">Edit</a>
                                         <a href="javascript::void(0)" class="dropdown-item delete" data-attr="{{ route('participants.destroy',$participant->part_id) }}">Delete</a>
                                         <a href="javascript::void(0)" class="dropdown-item inactive" data-attr="{{ route('participants.inactive',['participant' => $participant->part_id,'action' => $participant->user->active ? 0 : 1]) }}">{{$participant->user->active ? 'Inactivate' : 'Activate'}}</a>
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
		$("#participants-table").DataTable();

  		$('.delete').off().click(function(e)
	    {
           Swal.fire({  
			  title: 'Do you want delete this participant?',  
			  icon: 'warning',
			  html:'<b>Note: This would delete too his participation on current events</b>',
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

	    $('.inactive').off().click(function(e)
	    {
           Swal.fire({  
			  title: 'Do you want to inactivate this participant?',  
			  icon: 'warning',
			  html:'<b>Note: This would delete his participation on current events</b>',
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
	           		  // headers: {
					  //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				    // 	},
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
  	</script>
@endsection