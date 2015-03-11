@extends('layouts.default')

@section('content')
    <h1>Bookings</h1>
    <table>
        <thead>
        <tr>
            <th>Arrival</th>
            <th>Departure</th>
            <th>Guest</th>
        </tr>
        <thead>
        @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->arrival_date }}</td>
                <td>{{ $booking->departure_date }}</td>
                <td><a href="{{ route('bookingShow', $booking->id) }}">{{ $booking->guest_name }}</a></td>
                <td><a href="{{ route('bookingEdit', $booking->id) }}">edit</a></td>
            </tr>

        @endforeach
    </table>
    <p><a href="{{ route('bookingCreate') }}">Add new booking</a></p>
@stop