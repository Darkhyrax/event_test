<div class="form-container sign-up-container">
    <form method="POST" action="{{ route('register') }}" id="signupform">
        <h1>Create Account</h1>
        <p>Fields with (<span class="required">*</span>) are required
            <br>
            <strong>Note: </strong>Password must contain at least 8 characters, one lowercase and uppercase letter,one number and one symbol ($, !, ., #).
        </p> 
        @csrf
        <!-- <h5>Password must contain: </h5> -->
        <label for="part_first_name" class="col-form-label text-md-end"><span class="required">*</span> First Name</label>
       <input id="part_first_name" type="text" class="form-control @error('part_first_name') is-invalid @enderror" name="part_first_name" value="{{ old('part_first_name') }}" placeholder="Example: John" autocomplete="part_first_name" autofocus>
        @error('part_first_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <label for="part_family_name" class="col-form-label text-md-end"><span class="required">*</span> Family Name</label>
        <input id="part_family_name" type="text" class="form-control @error('part_family_name') is-invalid @enderror" name="part_family_name" value="{{ old('part_family_name') }}" placeholder="Example: Doe" autocomplete="part_family_name">
        @error('part_family_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="part_birth_date" class="col-form-label text-md-end"> Birth Date</label>
        <input id="part_birth_date" type="date" class="form-control @error('part_birth_date') is-invalid @enderror" name="part_birth_date" value="{{ old('part_birth_date') }}" autocomplete="part_birth_date" format>
        @error('part_birth_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="email" class="col-form-label text-md-end"><span class="required">*</span> Email</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="example@example.com">
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="password" class="col-form-label text-md-end"><span class="required">*</span> Password</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="Example: Secure81!">
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="events" class="col-form-label text-md-end"> Events you would like to participate in</label>
        <select class="form-control" id="events" name="events[]" multiple>
            @foreach ($events as $event)
                <option value="{{$event->eve_id}}">{{$event->eve_name}} ({{date('m-d-Y',strtotime($event->eve_date))}} - {{date('m-d-Y',strtotime($event->eve_end_date))}})</option>
            @endforeach
        </select>
        <br>
        <button>Sign Up</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#events').select2({
            placeholder: "--- Select an event ---",
            allowClear: true
        });
    });
</script>