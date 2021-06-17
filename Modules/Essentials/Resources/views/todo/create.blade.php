<div class="modal-dialog" role="document">
  <div class="modal-content">
    {!! Form::open(['url' => action('\Modules\Essentials\Http\Controllers\ToDoController@store'), 'id' => 'task_form', 'method' => 'post']) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'essentials::lang.add_to_do' )</h4>
    </div>

    <div class="modal-body">
    	<div class="row">
    		<div class="col-md-12">
		        <div class="form-group">
		            {!! Form::label('task', __('essentials::lang.task') . ":*")!!}
		            {!! Form::text('task', null, ['class' => 'form-control', 'required']) !!}
		         </div>
		    </div>
		    @can('essentials.assign_todos')
			<div class="col-md-12">
		        <div class="form-group">
					{!! Form::label('users', __('essentials::lang.assigned_to') . ':*') !!}
					<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-user"></i>
						</span>
						{!! Form::select('users[]', $users, null, ['class' => 'form-control select2', 'multiple', 'required', 'style' => 'width: 100%;']); !!}
					</div>
				</div>
			</div>
			@endcan
			<div class="clearfix"></div>
			<div class="col-md-6">
		        <div class="form-group">
					{!! Form::label('priority', __('essentials::lang.priority') . ':') !!}
					{!! Form::select('priority', $priorities, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'style' => 'width: 100%;']); !!}
				</div>
			</div>
			<div class="col-md-6">
		        <div class="form-group">
					{!! Form::label('status', __('sale.status') . ':') !!}
					{!! Form::select('status', $task_statuses, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'style' => 'width: 100%;']); !!}
				</div>
			</div>
			<div class="clearfix"></div>
		    <div class="col-md-6">
		        <div class="form-group">
					{!! Form::label('date', __('business.start_date') . ':*') !!}
					<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</span>
						{!! Form::text('date', @format_date('now'), ['class' => 'form-control datepicker text-center', 'required', 'readonly']); !!}
					</div>
				</div>
			</div>
			<div class="col-md-6">
		        <div class="form-group">
					{!! Form::label('end_date', __('essentials::lang.end_date') . ':') !!}
					<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</span>
						{!! Form::text('end_date', '', ['class' => 'form-control datepicker text-center', 'readonly']); !!}
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="col-md-6">
		        <div class="form-group">
					{!! Form::label('estimated_hours', __('essentials::lang.estimated_hours') . ':') !!}
					<div class="input-group">
						<span class="input-group-addon">
							<i class="fas fa-clock"></i>
						</span>
						{!! Form::text('estimated_hours', null, ['class' => 'form-control']); !!}
					</div>
				</div>
			</div>
		    <div class="clearfix"></div>
	    	<div class="col-md-12">
	    		<div class="form-group">
					{!! Form::label('to_do_description', __('lang_v1.description') . ':') !!}
					{!! Form::textarea('description', null, ['id' => 'to_do_description']); !!}
				</div>
	    	</div>
    	</div>
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary ladda-button" data-style="expand-right">
      	<span class="ladda-label">@lang( 'messages.save' )</span>
      </button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->