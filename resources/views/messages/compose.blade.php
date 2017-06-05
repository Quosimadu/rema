@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>Write a message</h1>
                    </div>
                    <div class="panel-body">

                        {!! Form::open(array('route' => 'messages.send', 'method' => 'post', 'class' =>
                        'form-horizontal')) !!}
                        <div class="form-group">
                            <div class="col-md-2">
                                {!! Form::label('sender', 'Sender', array('class' => 'control-label')) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::select('sender_id', $messageSenders, \Request::old('sender_id'), array('class' =>
                                'form-control', 'id' => 'sender')) !!}
                                {!! $errors->first('sender_id', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            {!! Form::select('provider_id', $providers, \Request::old('provider_id'), array('class' =>
                            'form-control', 'id' => 'providers')) !!}
                            {!! $errors->first('provider_id', '
                            <div class="note note-error">:message</div>
                            ') !!}
                        </div>

                        <div class="form-group">
                            <div class="col-md-2">
                                {!! Form::label('receiver', 'Receiver', array('class' => 'control-label')) !!}
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
<!--
                            <div class="col-md-4">
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        Templates
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                        @foreach($message_templates as $template)
                                            <li><a href="#">{!! $template->name !!}
                                                    ({!! str_limit($template->content,15,'...') !!})</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                {!! Form::label('content', 'Content', array('class' => 'control-label')) !!}
                            </div>
//-->
                            <div class="col-md-8">
                                {!! Form::textarea('content', \Request::old('content'), $attributes = array('class' =>
                           'form-control', 'id' => 'content', 'placeholder' => '', 'rows' => 6, 'style' => '')) !!}
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

@section('javascript')
    <script>
        $('#providers').change(function () {
            var selected_value = $(this).val();
            ;
            var new_receivers = $('#receiver').val() + ', ' + selected_value;
            $('#receiver').val(new_receivers);
            $(this).val('');
            $(this).find('option[value="' + selected_value + '"]').remove();
        });
    </script>
@stop