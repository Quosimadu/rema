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
                        <?php /*
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
                                    <td>
                                        <a href="{!! route('bookingShow', $booking->id) !!}">{!! $booking->guest_name !!}</a>
                                    </td>
                                    <td><a href="{!! route('bookingEdit', $booking->id) !!}">edit</a></td>
                                </tr>

                            @endforeach
                        </table>
*/ ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function () {

        })
    </script>
@stop
@stop