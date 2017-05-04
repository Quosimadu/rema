@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1>{!! $provider->name !!}</h1>
                    </div>
                    <div class="panel-body">

                        {!! Form::open(array('route' => array('providerUpdate', $provider->id), 'method' => 'PUT',
                        'class' => 'form-horizontal')) !!}

                        <div class="form-group">
                            <div class="col-md-2">
                                {!! Form::label('first_name', 'First name', array('class' => 'control-label')) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::text('first_name', $provider->first_name, $attributes = array('class' => 'form-control',
                                'id' =>
                                'first_name', 'placeholder' => '')) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('last_name', 'Last name', array('class' => 'control-label')) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::text('last_name', $provider->last_name, $attributes = array('class' => 'form-control',
                                'id' =>
                                'last_name', 'placeholder' => '')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">
                                {!! Form::label('mobile', 'Mobile', array('class' => 'control-label')) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::text('mobile', $provider->mobile, $attributes = array('class' => 'form-control',
                                'id' =>
                                'mobile', 'placeholder' => '+420777123456')) !!}
                            </div>
                            <div class="col-md-1">
                                {!! Form::label('email', 'Email', array('class' => 'control-label')) !!}
                            </div>
                            <div class="col-md-4">
                                {!! Form::text('email', $provider->email, $attributes = array('class' => 'form-control',
                                'id' =>
                                'email', 'placeholder' => '')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">
                                {!! Form::label('address', 'Address', array('class' => 'control-label')) !!}
                            </div>
                            <div class="col-md-8">
                                {!! Form::textarea('address', $provider->address, $attributes = array('class' =>
                                'form-control', 'id'
                                => 'address', 'placeholder' => 'Praha 7', 'rows' => 3)) !!}

                                {!! $errors->first('address', '
                                <div class="note note-error">:message</div>
                                ') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-2">
                                {!! Form::submit('Update provider', array('class' => 'btn btn-primary')) !!}

                            </div>
                            <div class="pull-right"><a class="btn btn-link" href="{!! route('providers') !!}">Back to
                                    providers overview</a></div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop