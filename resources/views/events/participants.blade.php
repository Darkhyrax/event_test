<div class="container">
	<div class="row">
		<div class="col-md-12">
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
					    	Signed up at
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
				  				{{date('m-d-Y h:ia',strtotime($participant->created_at))}}
				  			</td>
				  		</tr>
				  	@endforeach
			  	</tbody>
			</table>
		</div>
	</div>
	<div class="row justify-content-center mt-3">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	</div>
</div>
<script>
	$("#participants-table").DataTable();
</script>