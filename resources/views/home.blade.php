@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{asset('css/slide.css')}}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Personal Information</div>
                <div class="card-body">
                   <div class="row">
                       <div class="col-md-6"><strong>First Name:</strong></div>
                       <div class="col-md-6">{{$info->part_first_name}}</div>
                       <div class="col-md-6"><strong>Family Name:</strong></div>
                       <div class="col-md-6">{{$info->part_family_name}}</div>
                       <div class="col-md-6"><strong>Birth Date:</strong></div>
                       <div class="col-md-6">{{$info->part_birth_date ? date('m-d-Y',strtotime($info->part_birth_date)) : 'No registered'}}</div>
                       <div class="col-md-6"><strong>Email:</strong></div>
                       <div class="col-md-6">{{$info->user->email}}</div>
                   </div>
                   <div class="row mt-3">
                       <div class="col-md-6">
                           <button class="btn btn-info text-white modalpet" modal-title="Edit My information" data-attr="{{ route('participants.edit',$info->part_id) }}"><i class="fa fa-pen"></i> Edit information</button>
                       </div>
                       <div class="col-md-6">
                           <button class="btn btn-info text-white modalpet" modal-title="Event Sign Up" data-attr="{{ route('home.new_participation') }}"><i class="fa-solid fa-file-signature"></i> Register to a new event</button>
                       </div>
                   </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Incoming events to assist</div>
                <div class="card-body">
                    <div class="container">
                       @if(count($participant_events) > 0)
                             @foreach($participant_events as $event)
                                <!-- Full-width images with number text -->
                                <div class="mySlides">
                                    <div class="numbertext">{{$loop->iteration}} / {{count($participant_events)}}</div>
                                    <img src="{{asset('images/events/'.$event->eve_banner)}}" style="width:100%;height: 100%;">
                                </div>
                            @endforeach

                            <!-- Next and previous buttons -->
                            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                            <a class="next" onclick="plusSlides(1)">&#10095;</a>

                            <!-- Image text -->
                            <div class="caption-container">
                                <p id="caption"></p>
                            </div>

                            <!-- Thumbnail images -->
                            <div class="row_thumb">
                                @foreach($participant_events as $event)
                                    <div class="column">
                                      <img class="demo cursor" src="{{asset('images/events/'.$event->eve_banner)}}" style="width:100%;height: 100%;" onclick="currentSlide({{$loop->iteration}})" alt="{{$event->eve_name}} {{$event->eve_location}} (From {{date('m-d-Y',strtotime($event->eve_date))}} to {{date('m-d-Y',strtotime($event->eve_end_date))}})">
                                    </div>
                                @endforeach
                            </div>
                       @else
                            <h3>You didn't sign up to an event yet.</h3>
                       @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="{{ asset('js/home/slide.js') }}"></script>
@endsection