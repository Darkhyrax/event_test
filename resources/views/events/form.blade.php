<div class="container">
	<div class="row">
		<p>Fields with <b class="required">*</b> are required.</p>
	</div>
	<div class="row">
		<p><strong>Note: </strong> Allowed banner file extensions: .jpg, .jpeg, .png.</p>
	</div>
	<form action="{{route('events.store')}}" method="POST" id="events_form" class="simpleformpet" enctype="multipart/form-data" accept-charset="utf-8">
		@csrf
		<div class="row form-group">
			<div class="col-md-6">
				<label for="eve_name" class="form-label"><b class="required">*</b> Name:</label>
				<input class="form-control" type="text" name="eve_name" id="eve_name" maxlength="100" value="{{isset($event) ? $event->eve_name: ''}}" placeholder="Example: Club fest" />
				<span class="text-danger">
                    <strong id="eve_name-error"></strong>
              	</span>
			</div>
			<div class="col-md-6">
				<label for="eve_location" class="form-label"><b class="required">*</b> Location:</label>
				<input class="form-control" type="text" name="eve_location" id="eve_location" maxlength="100" value="{{isset($event) ? $event->eve_location: ''}}" placeholder="Example: Arizona, TX" />
				<span class="text-danger">
                    <strong id="eve_location-error"></strong>
              	</span>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="eve_date" class="form-label"><b class="required">*</b> Begin Date:</label>
				<input class="form-control" type="datetime-local" name="eve_date" id="eve_date" value="{{isset($event) ? date('Y-m-d\TH:i',strtotime($event->eve_date)): ''}}" />
				<span class="text-danger">
                    <strong id="eve_date-error"></strong>
              	</span>
			</div>
			<div class="col-md-6">
				<label for="eve_end_date" class="form-label"><b class="required">*</b> End Date:</label>
				<input class="form-control" type="datetime-local" name="eve_end_date" id="eve_end_date" value="{{isset($event) ? date('Y-m-d\TH:i',strtotime($event->eve_date)) : ''}}" />
				<span class="text-danger">
                    <strong id="eve_end_date-error"></strong>
              	</span>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-6">
				<label for="eve_banner" class="form-label">@if(isset($event)) New @else <b class="required">*</b> @endif Banner:</label>
				<div class="input-group">
  					<div>
    					<input type="file" id="eve_banner" name="eve_banner" accept=".png,.jpg,.jpeg">
  					</div>
				</div>
				<span class="text-danger">
                    <strong id="eve_banner-error"></strong>
              	</span>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				@if(isset($event))
					<input type="hidden" name="eve_id" value="{{$event->eve_id}}">
				@endif
				<button class="btn btn-success">Save</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</form>
</div>

<script src="{{ asset('js/general.js') }}"></script>