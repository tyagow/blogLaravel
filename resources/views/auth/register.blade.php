@extends('main')

@section('title','| Register')

@section('content')

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			{!! Form::open() !!}

				{{ Form::label('name', 'Name:', ['class' => 'btn-h1-spacing' ]) }}
				{{ Form::text('name',null,['class' => 'form-control' ]) }}

				{{ Form::label('email', 'Email:', ['class' => 'btn-h1-spacing' ]) }}
				{{ Form::email('email',null,['class' => 'form-control' ]) }}

				{{ Form::label('password', 'Password:', ['class' => 'btn-h1-spacing' ]) }}
				{{ Form::password('password',['class' => 'form-control' ]) }}

				{{ Form::label('password_confirmation', 'Confirm Password:' , ['class' => 'btn-h1-spacing' ]) }}
				{{ Form::password('password_confirmation',['class' => 'form-control' ]) }}

				<br>
				{{ Form::submit('Register', ['class' => 'btn btn-primary btn-block btn-h1-spacing' ]) }}

			{!! Form::close() !!}
		</div>
	</div>



@endsection