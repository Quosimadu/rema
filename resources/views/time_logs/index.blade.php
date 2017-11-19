@extends('layouts.app')

@section('title')
    Bookings :: @parent
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>Time logs</h1>
                    </div>

                    <div class="panel-body">
                        <p class=""><a class="" href="{!! route('timeLogCreate') !!}" title="New time log"><i
                                        class="fa fa-plus-circle fa-2x" aria-hidden="true"></i></a></p>
                        {!! Form::label('listing_id', 'Listing', array('class' => 'col-md-1 control-label sr-only')) !!}
                        <div class="col-md-4">
                            {!! Form::select('listing_id', [ 0 =>'-- all listings --']+$listings->toArray(), !empty($listing_id) ? $listing_id : null, array('class' => 'form-control', 'id' => 'listing_id')) !!}
                        </div>
                        <a class="btn btn-default" href="{!! route('time_logs', ['init' => 1]) !!}">Reset</a>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>Date</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Apartment</th>
                                <th>Is paid</th>
                            </tr>
                            <thead>
                            @foreach($timeLogs as $timeLog)
                                <tr>
                                    <td>{!! $timeLog->user->name !!}</td>
                                    <td>{!! \Carbon\Carbon::parse($timeLog->start)->format(trans('global.date_format')) !!}</td>
                                    <td>{!! \Carbon\Carbon::parse($timeLog->start)->format(trans('global.time_format')) !!}</td>
                                    <td>{!! \Carbon\Carbon::parse($timeLog->end)->format(trans('global.time_format')) !!}</td>
                                    <td>{!! $timeLog->listing->name !!}</td>
                                    <td>{!! $timeLog->is_paid !!}</td>
                                </tr>

                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

@section('javascript')
    <script type="text/javascript">

        $(document).ready(function () {

            $('#listing_id').change(function (e) {
                e.preventDefault();
                var targetUrl = '{!! route('time_logs') !!}' + '?listing_id=' + $(this).val();
                location.replace(targetUrl);
            });
        })
    </script>
@stop
@stop