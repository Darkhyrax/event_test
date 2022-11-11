<link rel="stylesheet" href="{{asset('css/events_images.css')}}">

<div class="container">
	<div class="row">
		@if(count($events) > 0) <p>Fields with <b class="required">*</b> are required.</p> @endif
	</div>
	<form action="{{route('home.new_participation')}}" method="POST" id="participants_form" class="simpleformpet">
		@csrf
		@if(count($events) > 0)
			<div class="row">
				<div class="col-md-12">
					<ul>
						@foreach ($events as $event)
							<input type="checkbox" name="event[]" id="{{$event->eve_name}}" value="{{$event->eve_id}}" />
							<label for="{{$event->eve_name}}">
								<img src="{{asset('images/events/'.$event->eve_banner)}}" alt="{{$event->eve_name}}">
								<div class="text-block text-center">
							    	<h4>{{$event->eve_name}}</h4>
								    <p>{{$event->eve_location}}, {{date('m-d-Y',strtotime($event->eve_date))}} / {{date('m-d-Y',strtotime($event->eve_end_date))}}</p>
							  	</div>
							</label>
						@endforeach
					</ul>
				</div>
			</div>
		@else
			<h3>No events to sign up, try later.</h3>
		@endif
		<div class="row mt-3" align="center">
			<div class="col-md-12">
				@if(count($events) > 0)
					<button class="btn btn-success">Save</button>
				@endif
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</form>
</div>

<script src="{{ asset('js/general.js') }}"></script>
<script>
	$(document).ready(function ()
	{	
		$("#events").select2({
		    placeholder: "--- Select an event ---",
		    allowClear: true
		});
	});
</script>