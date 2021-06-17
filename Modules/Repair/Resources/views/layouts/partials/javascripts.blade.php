@php
	$repair = [];
	if (!empty($view_data['job_sheet'])) {
		$repair['repair_status_id'] = $view_data['job_sheet']['status_id'];
		$repair['repair_security_pwd'] = $view_data['job_sheet']['security_pwd'];
		$repair['repair_security_pattern'] = $view_data['job_sheet']['security_pattern'];
		$repair['customer_id'] = $view_data['job_sheet']['contact_id'];
	} elseif (!empty($transaction)) {
		$repair['repair_status_id'] = $transaction['repair_status_id'];
		$repair['repair_security_pwd'] = $transaction['repair_security_pwd'];
		$repair['repair_security_pattern'] = $transaction['repair_security_pattern'];
	}
@endphp
<script type="text/javascript">
	// override the default walk-in-customer
	@if(!empty($repair['customer_id']))
		$("input#default_customer_id").val({{$repair['customer_id']}});
		$("input#default_customer_name").val("{{$view_data['job_sheet']->customer->name}}");
		$("input#default_customer_balance").val({{$view_data['job_sheet']->customer->balance}});
	@endif

	$(document).ready( function() {

		$("#product_service_div").removeClass('hide');

		var lock = new PatternLock("#pattern_container", {
			onDraw:function(pattern){
    			$('input#repair_security_pattern').val(pattern);
			},
			enableSetPattern: true
		});

		//re draw pattern & set pattern code in hidden field
		@if(!empty($repair['repair_security_pattern']))
	        lock.setPattern("{{$repair['repair_security_pattern']}}");
	        $('input#repair_security_pattern').val("{{$repair['repair_security_pattern']}}");
	    @endif

	    //set password in hidden field
	    @if(!empty($repair['repair_security_pwd']))
	        $("input#repair_security_pwd").val("{{$repair['repair_security_pwd']}}");
	    @endif

		$('#repair_completed_on, #repair_due_date').datetimepicker({
	        format: moment_date_format + ' ' + moment_time_format,
	        ignoreReadonly: true,
	    });

		$(document).on('click', '.clear_repair_completed_on', function() {
			$('#repair_completed_on').data("DateTimePicker").clear();
		});

		$(document).on('click', '.clear_repair_due_date', function() {
			$('#repair_due_date').data("DateTimePicker").clear();
		});

		$(document).on('sell_form_reset', function(){
			$('#repair_status_id, #repair_brand_id, #res_waiter_id').change();
		});

		var fileinput_setting = {
	        showUpload: false,
	        showPreview: true,
	        browseLabel: LANG.file_browse_label,
	        removeLabel: LANG.remove,
	        previewSettings: {
	            image: { width: '70px', height: '70px' },
	        },
	    };

		$('#documents').fileinput(fileinput_setting);

		//filter product based on brand & device model
		$(document).on('change', '#repair_brand_id', function() {
			$('select#product_brand').val($("#repair_brand_id").val()).trigger('change');
			getModelForDevice();
		});

		// get models for particular device
		$(document).on('change', '#repair_device_id', function() {
			getModelForDevice();
		});

		// get repair checklist for particular model and get product suggestion based on device model
		$(document).on('change', '#repair_model_id', function() {
			$('input#suggestion_page').val(1);
	        get_product_suggestion_list(
		        null,
		        $("#repair_brand_id").val(),
		        $('input#location_id').val(),
		        null,
		        $("#is_enabled_stock").val(),
		        $("#repair_model_id").val()
		    );

		    getModelRepairChecklists();
		});

		//filter based on service/product
		$('select#is_enabled_stock').on('change', function(e) {
	        $('input#suggestion_page').val(1);
	        get_product_suggestion_list(
		        null,
		        $("#repair_brand_id").val(),
		        $('input#location_id').val(),
		        null,
		        $("#is_enabled_stock").val(),
		        $("#repair_model_id").val()
		    );
	    });

		function getModelForDevice() {
			var data = {
						device_id : $("#repair_device_id").val(),
						brand_id: $("#repair_brand_id").val()
					};

			$.ajax({
		        method: 'GET',
		        url: '/repair/get-device-models',
		        dataType: 'html',
		        data: data,
		        success: function(result) {
					$('select#repair_model_id').html(result);
		        }
		    });
		}

		function getModelRepairChecklists() {
			var data = {
						model_id : $("#repair_model_id").val(),
						transaction_id : $("#repair_transaction_id").val(),
						job_sheet_id : $("#repair_job_sheet_id").val()
					};
			$.ajax({
		        method: 'GET',
		        url: '/repair/models-repair-checklist',
		        dataType: 'html',
		        data: data,
		        success: function(result) {
		            $(".append_repair_checklists").html(result);
		        }
		    });
		}

		@includeIf('repair::repair.partials.repair_status')

		//set repair status
		@if(!empty($repair['repair_status_id']))
			$("select#repair_status_id").val({{$repair['repair_status_id']}}).change();
		@elseif(!empty($view_data['default_status']))
			$("select#repair_status_id").val({{$view_data['default_status']}}).change();
		@endif

		getModelRepairChecklists();

		@if(!empty($view_data['repair_settings']))
		    @php
		        $defects = isset($view_data['repair_settings']['problem_reported_by_customer']) ? explode(',', $view_data['repair_settings']['problem_reported_by_customer']) : [];
		    @endphp
		@else
		    @php
		        $defects = [];
		    @endphp
		@endif
		
		//initialize tags input (tagify)
        var repair_defects = document.querySelector('textarea#repair_defects');
        tagify_rd = new Tagify(repair_defects, {
          whitelist: {!!json_encode($defects)!!},
          maxTags: 100,
          dropdown: {
            maxItems: 100,           // <- mixumum allowed rendered suggestions
            classname: "tags-look", // <- custom classname for this dropdown, so it could be targeted
            enabled: 0,             // <- show suggestions on focus
            closeOnSelect: false    // <- do not hide the suggestions dropdown once an item has been selected
          }
        });
	});
</script>