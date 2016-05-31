@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>Write a message</h1>
                    </div>
                    <div class="panel-body">

                        {!! Form::open(array('route' => 'messages.store', 'method' => 'post', 'class' =>
                        'form-horizontal')) !!}

                        <div class="form-group">
                            <div class="col-md-2">
                                {!! Form::label('name', 'Name', array('class' => 'control-label')) !!}
                            </div>
                            <div class="col-md-8">
                                {!! Form::text('receiver', \Request::old('receiver'), $attributes = array('class' =>
                                'form-control', 'id' => 'receiver', 'placeholder' => '+420..')) !!}
                                {!! $errors->first('receiver', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">
                                {!! Form::label('content', 'Content', array('class' => 'control-label')) !!}
                            </div>
                            <div class="col-md-8">
                                {!! Form::textarea('content', \Request::old('content'), $attributes = array('class' =>
                                'form-control', 'id' => 'content', 'placeholder' => '', 'rows' => 6)) !!}
                                {!! $errors->first('content', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-2">
                                {!! Form::submit('Send message', array('class' => 'btn btn-primary')) !!}

                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop