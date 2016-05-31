@extends('app')

@section('content') <div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col">
            <div class="panel panel-default">
                <div class="panel-heading">
    <h1>Bookings</h1>
                </div>
                <div class="panel-body">

                    {!! Form::label('listing_id', 'Listing', array('class' => 'col-md-1 control-label sr-only')) !!}
                    <div class="col-md-4">
                    {!! Form::select('listing_id', [ 0 =>'-- all listings --']+$listings->toArray(), !empty($listing_id) ? $listing_id : null, array('class' => 'form-control', 'id' => 'listing_id')) !!}
                    </div>
                    {!! Form::label('time', 'Time', array('class' => 'col-md-1 control-label sr-only')) !!}
                    <div class="col-md-4">
                        {!! Form::select('time', $timeOptions, !empty($time) ? $time : 'future', array('class' => 'form-control', 'id' => 'time')) !!}
                    </div>
                    <a class="btn btn-default" href="{!! route('bookings', ['init' => 1]) !!}">Reset</a>

                    <table class="table">
        <thead>
        <tr>
            <th>Arrival</th>
            <th>Departure</th>
            <th>Guest</th>
        </tr>
        <thead>
        @foreach($bookings as $booking)
            <tr>
                <td>{!! $booking->arrival_date !!}</td>
                <td>{!! $booking->departure_date !!}</td>
                <td><a href="{!! route('bookingShow', $booking->id) !!}">{!! $booking->guest_name !!}</a></td>
                <td><a href="{!! route('bookingEdit', $booking->id) !!}">edit</a></td>
            </tr>

        @endforeach
    </table>
    <p><a class="btn btn-primary" href="{!! route('bookingCreate') !!}">Add new booking</a></p></div>
            </div>
        </div>
    </div>
</div>

@section('javascript')
    <script type="text/javascript">

        $(document).ready(function() {

            $('#listing_id').change(function(e) {
                e.preventDefault();
                var targetUrl = '{!! route('bookings') !!}' + '?listing_id=' + $(this).val();
                location.replace(targetUrl);
            });
            $('#time').change(function(e) {
                e.preventDefault();
                var targetUrl = '{!! route('bookings') !!}' + '?time=' + $(this).val();
                location.replace(targetUrl);
            });
        })
    </script>
@stop
@stop