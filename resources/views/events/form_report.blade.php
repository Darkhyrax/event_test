@extends('layouts.app')

@section('css')
    
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Daily participants registered graphic report</div>
                <div class="card-body">
                    <div class="row">
                        <p>Fields with <b class="required">*</b> are required.</p>
                    </div>
                    <form action="{{route('events.report')}}" method="POST" id="event_report_form">
                    @csrf
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label for="from" class="form-label"><b class="required">*</b> From:</label>
                                <input type="date" name="from" id="from" class="form-control">
                                <span class="text-danger">
                                    <strong id="from-error"></strong>
                                </span>
                            </div>
                            <div class="col-md-4">
                                <label for="to" class="form-label"><b class="required">*</b> To:</label>
                                <input type="date" name="to" id="to" class="form-control">
                                <span class="text-danger">
                                    <strong id="to-error"></strong>
                                </span>
                            </div>
                            <div class="col-md-4">
                                <label for="event" class="form-label"><b class="required">*</b> Event:</label>
                                <select class="form-control" id="event" name="event">
                                    <option value="">--- Select an Event ---</option>
                                    @foreach ($events as $event)
                                        <option value="{{$event->eve_id}}">{{$event->eve_name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">
                                    <strong id="event-error"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="row form-group">
                          <div class="col-md-12">
                            <button class="btn btn-success">Generate</button>
                            <button type="button" class="btn btn-danger" onclick="$('#event_report_form').trigger('reset');$('#preview').hide(1000);">Clear</button>
                          </div>
                      </div>
                    </form>
                    <div class="row justify-content-center">
                        <div id="load" style="display:none;">
                          <i style="font-size: 1000%;" class="fa fa-spinner fa-spin"></i>
                        </div>
                        <div id="preview" style="display:none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="{{asset('js/events/report.js')}}"></script>
    <script src="{{ asset('js/google-chart-loader.js') }}"></script>
@endsection