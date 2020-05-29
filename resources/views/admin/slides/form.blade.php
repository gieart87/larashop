@extends('admin.layout')

@section('content')
	
@php
	$formTitle = !empty($slide) ? 'Update' : 'New'    
@endphp

<div class="content">
	<div class="row">
		<div class="col-lg-6">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom">
						<h2>{{ $formTitle }} Slide</h2>
				</div>
				<div class="card-body">
					@include('admin.partials.flash', ['$errors' => $errors])
					@if (!empty($slide))
						{!! Form::model($slide, ['url' => ['admin/slides', $slide->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
						{!! Form::hidden('id') !!}
					@else
						{!! Form::open(['url' => 'admin/slides', 'enctype' => 'multipart/form-data']) !!}
					@endif
						<div class="form-group">
							{!! Form::label('title', 'Title') !!}
							{!! Form::text('title', null, ['class' => 'form-control']) !!}
						</div>
						<div class="form-group">
							{!! Form::label('url', 'URL') !!}
							{!! Form::text('url', null, ['class' => 'form-control']) !!}
						</div>
					@if (empty($slide))
						<div class="form-group">
							{!! Form::label('image', 'Slide Image (1920x643 pixel)') !!}
							{!! Form::file('image', ['class' => 'form-control-file', 'placeholder' => 'product image']) !!}
						</div>
					@endif
						<div class="form-group">
							{!! Form::label('body', 'Body') !!}
							{!! Form::textarea('body', null, ['class' => 'form-control', 'rows' => 3]) !!}
						</div>
						<div class="form-group">
							{!! Form::label('status', 'Status') !!}
							{!! Form::select('status', $statuses , null, ['class' => 'form-control', 'placeholder' => '-- Set Status --']) !!}
						</div>
						<div class="form-footer pt-5 border-top">
							<button type="submit" class="btn btn-primary btn-default">Save</button>
							<a href="{{ url('admin/slides') }}" class="btn btn-secondary btn-default">Back</a>
						</div>
					{!! Form::close() !!}
				</div>
			</div>  
		</div>
	</div>
</div>
@endsection