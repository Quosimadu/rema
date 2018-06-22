@extends('layouts.app')

@section('title')
    Accounting :: @parent
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>Accounting</h1>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <a class="btn btn-default" href="{{ route('airbnbImport') }}">Airbnb CSV Import</a>
                            <a class="btn btn-default" href="{{ route('xmlExport') }}">XML Export</a>
                            <a class="btn btn-default" href="{{ route('xmlImport') }}">Stormware Pohoda XML Import</a>
                            <a class="btn btn-default" href="{{ route('payoutXmlExport') }}">*Payout XML Export</a>
                            <a class="btn btn-default" href="{{ route('bankStatementImport') }}">Bank statement Import</a>
                            <br />
                            * Payout XML export works with filters date from/to only. Need another accounting view to show properly matched payouts
                        </div>

                        {!! Form::open(['route' => 'accounting', 'method' => 'post', 'class' => 'form-horizontal']) !!}
                        <div class="row">
                            <div class="form-group">
                                {!! Form::label('filter[date_from]', 'From', array('class' => 'col-md-1 control-label'))!!}
                                <div class="col-md-2">
                                    {!! Form::date('filter[date_from]', array_get($filters, 'date_from'), ['class' => 'form-control']) !!}
                                </div>

                                {!! Form::label('filter[date_to]', 'To', array('class' => 'col-md-1 control-label'))!!}
                                <div class="col-md-2">
                                    {!! Form::date('filter[date_to]', array_get($filters, 'date_to'), ['class' => 'form-control']) !!}
                                </div>

                                {!! Form::label('filter[listings][]', 'Listings', array('class' => 'col-md-1 control-label'))!!}
                                <div class="col-md-2">
                                    {!! Form::select('filter[listings][]', $listings, array_get($filters, 'listings'), ['id' => 'filter[listings][]', 'class' => 'select2-multiple form-control', 'multiple' => 'multiple']) !!}
                                </div>
                                <div class="col-md-1">
                                    {{ Form::submit('Filter', ['class' => 'btn btn-primary']) }}
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}

                        @if ($bookings->count())
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
                                    <td>{!! $booking->arrival_date->toDateString() !!}</td>
                                    <td>{!! $booking->departure_date->toDateString() !!}</td>
                                    <td>
                                        <a href="{!! route('bookingShow', $booking->id) !!}">{!! $booking->guest_name !!}</a>
                                    </td>
                                    <td><a href="{!! route('bookingEdit', $booking->id) !!}">edit</a></td>
                                </tr>

                            @endforeach
                        </table>
                        {{ $bookings->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2-multiple').select2();
        })
    </script>
@stop
@stop