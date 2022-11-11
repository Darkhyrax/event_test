<div class="container">
	<div class="row">
		<p>Fields with <b class="required">*</b> are required.</p>
		<p>Password must contain at least 8 characters, one lowercase and uppercase letter,one number and one symbol ($, !, ., #).</p>
	</div>
	<form action="{{route('participants.store')}}" method="POST" id="participants_form" class="simpleformpet">
		@csrf
		<div class="row form-group">
			<div class="col-md-4">
				<label for="part_first_name" class="form-label"><b class="required">*</b> First Name:</label>
				<input class="form-control" type="text" name="part_first_name" id="part_first_name" maxlength="100" value="{{isset($participant) ? $participant->part_first_name: ''}}" placeholder="Example: John" />
				<span class="text-danger">
                    <strong id="part_first_name-error"></strong>
              	</span>
			</div>
			<div class="col-md-4">
				<label for="part_family_name" class="form-label"><b class="required">*</b> Family Name:</label>
				<input class="form-control" type="text" name="part_family_name" id="part_family_name" maxlength="100" value="{{isset($participant) ? $participant->part_family_name: ''}}" placeholder="Example: Doe"/>
				<span class="text-danger">
                    <strong id="part_family_name-error"></strong>
              	</span>
			</div>
			<div class="col-md-4">
				<label for="part_birth_date" class="form-label"> Birth Date:</label>
				<input class="form-control" type="date" name="part_birth_date" id="part_birth_date" value="{{isset($participant) ? $participant->part_birth_date: ''}}" />
				<span class="text-danger">
                    <strong id="part_birth_date-error"></strong>
              	</span>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-4">
				<label for="email" class="form-label"><b class="required">*</b> Email:</label>
				<input class="form-control" type="email" name="email" id="email" maxlength="250" value="{{isset($participant) ? $participant->user->email: ''}}" placeholder="Example: example@example.com" />
				<span class="text-danger">
                    <strong id="email-error"></strong>
              	</span>
			</div>
			<div class="col-md-4">
				<label for="password" class="form-label">@if (!isset($participant)) <b class="required">*</b>@endif Password:</label>
				<input class="form-control" type="password" name="password" id="password" placeholder="Example: Secure81!" />
				<span class="text-danger">
                    <strong id="password-error"></strong>
              	</span>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				@if(isset($participant))
					<input type="hidden" name="part_id" value="{{$participant->part_id}}">
					<input type="hidden" name="user_id" value="{{$participant->user_id}}">
				@endif
				<button class="btn btn-success">Save</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</form>
</div>

<script src="{{ asset('js/general.js') }}"></script>