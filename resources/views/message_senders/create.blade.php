@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>Create a message sender</h1>
                    </div>
                    <div class="panel-body">

                        {!! Form::open(array('route' => 'message_senders.store', 'method' => 'post', 'class' =>
                        'form-horizontal')) !!}

                        <div class="form-group">
                            <div class="col-md-2">
                                {!! Form::label('name', 'Name', array('class' => 'control-label')) !!}
                            </div>
                            <div class="col-md-8">
                                {!! Form::text('name', \Request::old('name'), $attributes = array('class' =>
                                'form-control', 'id' => 'name', 'placeholder' => '')) !!}
                                {!! $errors->first('name', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2">
                                {!! Form::label('number', 'Number', array('class' => 'control-label')) !!}
                            </div>
                            <div class="col-md-8">
                                {!! Form::text('number', \Request::old('number'), $attributes = array('class' =>
                                'form-control', 'id' => 'number', 'placeholder' => '')) !!}
                                {!! $errors->first('number', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2">
                                {!! Form::label('provider', 'Provider', array('class' => 'control-label')) !!}
                            </div>
                            <div class="col-md-8">
                                {!! Form::text('provider', \Request::old('provider'), $attributes = array('class' =>
                                'form-control', 'id' => 'provider', 'placeholder' => '')) !!}
                                {!! $errors->first('provider', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-2">
                                {!! Form::submit('Save sender', array('class' => 'btn btn-primary')) !!}

                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
