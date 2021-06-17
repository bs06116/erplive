@extends('layouts.app')

@section('title', __('crm::lang.lead'))

@section('content')
@include('crm::layouts.nav')
<!-- Content Header (Page header) -->
<section class="content-header no-print">
   <h1>@lang('crm::lang.leads')</h1>
</section>

<section class="content no-print">
    @component('components.filters', ['title' => __('report.filters')])
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('source', __('crm::lang.source') . ':') !!}
                    {!! Form::select('source', $sources, null, ['class' => 'form-control select2', 'id' => 'source', 'placeholder' => __('messages.all')]); !!}
                </div>    
            </div>
            @if($lead_view != 'kanban')
                <div class="col-md-4">
                    <div class="form-group">
                         {!! Form::label('life_stage', __('crm::lang.life_stage') . ':') !!}
                        {!! Form::select('life_stage', $life_stages, null, ['class' => 'form-control select2', 'id' => 'life_stage', 'placeholder' => __('messages.all')]); !!}
                    </div>
                </div>
            @endif
        </div>
    @endcomponent
	@component('components.widget', ['class' => 'box-primary', 'title' => __('crm::lang.all_leads')])
        @slot('tool')
            <div class="box-tools">
                <button type="button" class="btn btn-sm btn-primary btn-add-lead pull-right m-5" data-href="{{action('\Modules\Crm\Http\Controllers\LeadController@create')}}">
                    <i class="fa fa-plus"></i> @lang('messages.add')
                </button>
                <a href="{{url('crm/contact-leads-import')}}"
                       class="btn btn-sm btn-success pull-right m-5">
                        <i class="fa fa-upload"></i> Import

                    </a>

                <div class="btn-group btn-group-toggle pull-right m-5" data-toggle="buttons">
                    <label class="btn btn-info btn-sm active list">
                        <input type="radio" name="lead_view" value="list_view" class="lead_view" data-href="{{action('\Modules\Crm\Http\Controllers\LeadController@index').'?lead_view=list_view'}}">
                        @lang('project::lang.list_view')
                    </label>
                    <label class="btn btn-info btn-sm kanban">
                        <input type="radio" name="lead_view" value="kanban" class="lead_view" data-href="{{action('\Modules\Crm\Http\Controllers\LeadController@index').'?lead_view=kanban'}}">
                        @lang('project::lang.kanban_board')
                    </label>
                </div>
            </div>
        @endslot
        @if($lead_view == 'list_view')
            <div class="table-responsive">
            	<table class="table table-bordered table-striped" id="leads_table">
    		        <thead>
    		            <tr>
    		                <th> @lang('messages.action')</th>
    		                <th>@lang('lang_v1.contact_id')</th>
    		                <th>@lang('contact.name')</th>
                            <th>@lang('business.email')</th>
                            <th>@lang('crm::lang.source')</th>
                            <th>@lang('crm::lang.life_stage')</th>
                            <th>@lang('lang_v1.assigned_to')</th>
                            <th>@lang('contact.mobile')</th>
                            <th>@lang('contact.tax_no')</th>
                            <th>@lang('lang_v1.added_on')</th>
                            <th>
                                @lang('lang_v1.contact_custom_field1')
                            </th>
                            <th>
                                @lang('lang_v1.contact_custom_field2')
                            </th>
                            <th>
                                @lang('lang_v1.contact_custom_field3')
                            </th>
                            <th>
                                @lang('lang_v1.contact_custom_field4')
                            </th>
    		            </tr>
    		        </thead>
    		    </table>
            </div>
        @endif
        @if($lead_view == 'kanban')
            <div class="lead-kanban-board">
                <div class="page">
                    <div class="main">
                        <div class="meta-tasks-wrapper">
                            <div id="myKanban" class="meta-tasks">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endcomponent
    <div class="modal fade contact_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>
</section>
@endsection
@section('javascript')
	<script src="{{ asset('modules/crm/js/crm.js?v=' . $asset_v) }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var lead_view = urlSearchParam('lead_view');

            //if lead view is empty, set default to list_view
            if (_.isEmpty(lead_view)) {
                lead_view = 'list_view';
            }

            if (lead_view == 'kanban') {
                $('.kanban').addClass('active');
                $('.list').removeClass('active');
                initializeLeadKanbanBoard();
            } else if(lead_view == 'list_view') {
                initializeLeadDatatable();
            }
        });
    </script>
@endsection