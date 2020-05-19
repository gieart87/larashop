{!! Form::open(['url'=> Request::path(),'method'=>'GET','class' => 'input-daterange form-inline']) !!}
<div class="row"> 
	<div class="col-md-3 col-sm-3">
		<input type="text" class="form-control input-block" name="q" value="{{ !empty(request()->input('q')) ? request()->input('q') : '' }}" placeholder="Type code or name"> 
	</div>
	<div class="col-md-3 col-sm-3">
		<div class="input-group input-block">
			<input type="text" class="form-control datepicker" readonly="" value="{{ !empty(request()->input('start')) ? request()->input('start') : '' }}" name="start" placeholder="from">
			<span class="input-group-addon">
				<i class="fa fa-calendar fa-fw"></i>
			</span>
		</div>
	</div>
	<div class="col-md-3 col-sm-3">
		<div class="input-group input-block">
			<input type="text" class="form-control datepicker" readonly="" value="{{ !empty(request()->input('end')) ? request()->input('end') : '' }}" name="end" placeholder="to">
			<span class="input-group-addon">
				<i class="fa fa-calendar fa-fw"></i>
			</span>
		</div>
	</div>
	<div class="col-md-2 col-sm-2">
		{{ Form::select('status', $statuses, !empty(request()->input('status')) ? request()->input('status') : null, ['placeholder' => 'All Status', 'class' => 'form-control input-block']) }}
	</div>
	<div class="col-md-1 col-sm-1">
		<button type="submit" class="btn btn-primary btn-default">Show</button>
	</div>
</div>
{!! Form::close() !!}