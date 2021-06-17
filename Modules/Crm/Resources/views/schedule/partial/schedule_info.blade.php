<div class="row">
    <div class="col-md-12">
        <button type="button" class="btn btn-sm btn-danger schedule_delete pull-right m-5" data-href="{{action('\Modules\Crm\Http\Controllers\ScheduleController@destroy', ['id' => $schedule->id])}}">
            <i class="fas fa-trash"></i>
            @lang('messages.delete')
        </button>
        <button type="button" class="btn btn-sm btn-primary schedule_edit pull-right m-5" data-href="{{action('\Modules\Crm\Http\Controllers\ScheduleController@edit', ['id' => $schedule->id])}}">
            <i class="fa fa-edit"></i>
            @lang('messages.edit')
        </button>
    </div>
    @if(!empty($schedule->description))
    <div class="col-md-12 mt-5">
        <div class="box box-solid">
            <div class="box-body">
                {!!$schedule->description!!}
            </div>
        </div>
    </div>
    @endif
    <div class="col-md-12 mt-5">
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3">
                    <strong><i class="fas fa-calendar-check"></i></i>
                        @lang('crm::lang.start_datetime')
                    </strong>
                    <p class="text-muted">
                        {{@format_datetime($schedule->start_datetime)}}
                    </p>
                    <strong><i class="fas fa-calendar-check"></i></i>
                        @lang('crm::lang.end_datetime')
                    </strong>
                    <p class="text-muted">
                        {{@format_datetime($schedule->end_datetime)}}
                    </p>
                </div>
                <div class="col-md-3">
                    @if(!empty($schedule->status))
                        <strong><i class="fas fa-check-circle"></i></i>
                            @lang('sale.status')
                        </strong>
                        <p class="text-muted">
                            @lang('crm::lang.'.$schedule->status)
                        </p>
                    @endif
                    <strong><i class="fas fa-flag"></i></i>
                        @lang('crm::lang.schedule_type')
                    </strong>
                    <p class="text-muted">
                        @lang('crm::lang.'.$schedule->schedule_type)
                    </p>
                    @if($schedule->allow_notification)
                        <strong><i class="fas fa-bell"></i></i>
                            @lang('crm::lang.notify_via')
                        </strong>
                        <p class="text-muted">
                            @if($schedule->notify_via['mail'])
                                @lang('crm::lang.email')
                                @if($schedule->notify_via['sms'])
                                    {{', '}}
                                @endif
                            @endif
                            @if($schedule->notify_via['sms'])
                                @lang('crm::lang.sms')
                            @endif
                        </p>
                    @endif
                </div>
                @if($schedule->allow_notification)
                    <div class="col-md-3">
                        <strong><i class="fas fa-flag-checkered"></i></i>
                            @lang('crm::lang.notify_before')
                        </strong>
                        <p class="text-muted">
                            {{$schedule->notify_before}}
                            @if($schedule->notify_type != 'day')
                                @lang('crm::lang.'.$schedule->notify_type)
                            @else
                                @lang('lang_v1.'.$schedule->notify_type)
                            @endif
                        </p>
                    </div>
                @endif
                <div class="col-md-3">
                    <strong><i class="fas fa-users"></i>
                        @lang('crm::lang.assgined')
                    </strong> <br>
                    <p>
                        @includeIf('components.avatar', ['max_count' => '10', 'members' => $schedule->users])
                    </p>
                </div>
            </div>
        </div><hr>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3">
                    <strong><i class="fa fa-briefcase"></i> @lang('contact.customer')</strong>
                    <p class="text-muted">
                        {{ $schedule->customer->name }}
                    </p>
                </div>
                <div class="col-md-5">
                    <strong><i class="fa fa-map-marker margin-r-5"></i> @lang('business.address')</strong>
                    <p class="text-muted">
                        @if($schedule->customer->landmark)
                            {{ $schedule->customer->landmark }}
                        @endif

                        {{ ', ' . $schedule->customer->city }}

                        @if($schedule->customer->state)
                            {{ ', ' . $schedule->customer->state }}
                        @endif
                        <br>
                        @if($schedule->customer->country)
                            {{ $schedule->customer->country }}
                        @endif
                    </p>
                </div>
                <div class="col-md-2">
                    <strong><i class="fa fa-mobile margin-r-5"></i> @lang('contact.mobile')</strong>
                    <p class="text-muted">
                        {{ $schedule->customer->mobile }}
                    </p>

                    @if(!empty($schedule->customer->email))
                        <strong><i class="fa fa-mobile margin-r-5"></i> @lang('business.email')</strong>
                        <p class="text-muted">
                            {{ $schedule->customer->email }}
                        </p>
                    @endif
                </div>
                <div class="col-md-2">
                    @if($schedule->customer->supplier_business_name)
                        <strong><i class="fa fa-briefcase margin-r-5"></i> 
                        @lang('business.business_name')</strong>
                        <p class="text-muted">
                            {{ $schedule->customer->supplier_business_name }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>