@extends('main')

@section('title', '| Edit Post')
@section('stylesheets')

	{!! Html::style('css/select2.css') !!}
	
@endsection

@section('content')

	<div class="row">

		{!! Form::model($post,['route' => ['posts.update',$post->id],'method' => 'PUT']) !!}
		<div class="col-md-8">
			{{ Form::label('title', 'Title:') }}
			{{ Form::text('title', null, ['class' => 'form-control input-lg']) }}

			{{ Form::label('slug', 'Slug:', ['class' => 'form-spacing-top']) }}
			{{ Form::text('slug', null, ['class' => 'form-control input-lg']) }}
			{{ Form::label('category_id', 'Category:', ['class' => 'form-spacing-top']) }}

			{{ Form::select('category_id', $categories,null,['class' => 'form-control']) }}

			{{ Form::label('tags', 'Tags:', ['class' => 'form-spacing-top']) }}
			{{ Form::select('tags[]', $tags,null, ['class' => 'select2-multi form-control','multiple' => 'multiple']) }}

			{{-- <select class="form-control select2-multi" name="tags[]" multiple="multiple">
				@foreach ($tags as $tag)
				  <option value='{{ $tag->id }}'>{{ $tag->name }}</option>
				@endforeach
			</select> --}}

			{{ Form::label('body', 'Body:', ['class' => 'form-spacing-top']) }}
			{{ Form::textarea('body', null,['class' => 'form-control input-lg']) }}

		</div>
		<div class="col-md-4">
			<div class="well">
				<dl class="dl-horizontal">
					<dt>Created At:</dt>
					<dd>{{ date( 'M j, Y H:i' , strtotime($post->created_at)) }} </dd>
				</dl>
				<dl class="dl-horizontal">
					<dt>Last Updated:</dt>
					<dd>{{ date( 'M j, Y H:i' , strtotime( $post->updated_at)) }}</dd>
				</dl>
				<hr>
				<div class="row">
					<div class="col-sm-6">
					{!!  Html::linkRoute('posts.show','Cancel',array($post->id),array('class' => 'btn btn-danger btn-block')) !!}
						
					</div>
					<div class="col-sm-6">
						
						{{ Form::submit('Save Changes',array('class' => 'btn btn-success btn-block')) }}

					</div>
				</div>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
	
	
@stop
@section('scripts')

	{!! Html::script('js/select2.full.js')!!}
	<script type="text/javascript">
		$('.select2-multi').select2();
		$('.select2-multi').select2().val({!! json_encode($post->tags()->getRelatedIds()) !!}).trigger('change');
	</script>

@endsection
