<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    {!! Form::open(['url' => action('CashRegisterController@postCloseRegister'), 'method' => 'post' ]) !!}

    {!! Form::hidden('user_id', $register_details->user_id); !!}
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h3 class="modal-title">@lang( 'cash_register.current_register' ) ( {{ \Carbon::createFromFormat('Y-m-d H:i:s', $register_details->open_time)->format('jS M, Y h:i A') }} - {{ \Carbon::now()->format('jS M, Y h:i A') }})</h3>
    </div>

    <div class="modal-body">
      <div class="row">
        <div class="col-sm-12">
          <table class="table">
            <tr>
              <td>
                @lang('cash_register.cash_in_hand'):
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->cash_in_hand }}</span>
              </td>
            </tr>
            <tr>
              <td>
                @lang('cash_register.cash_payment'):
              </th>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_cash }}</span>
              </td>
            </tr>
            <tr>
              <td>
                @lang('cash_register.checque_payment'):
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_cheque }}</span>
              </td>
            </tr>
            <tr>
              <td>
                @lang('cash_register.card_payment'):
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_card }}</span>
              </td>
            </tr>
            <tr>
              <td>
                @lang('cash_register.bank_transfer'):
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_bank_transfer }}</span>
              </td>
            </tr>
            <tr>
              <td>
                @lang('lang_v1.advance_payment'):
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_advance }}</span>
              </td>
            </tr>
            @if(array_key_exists('custom_pay_1', $payment_types))
              <tr>
                <td>
                  {{$payment_types['custom_pay_1']}}:
                </td>
                <td>
                  <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_1 }}</span>
                </td>
              </tr>
            @endif
            @if(array_key_exists('custom_pay_2', $payment_types))
              <tr>
                <td>
                  {{$payment_types['custom_pay_2']}}:
                </td>
                <td>
                  <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_2 }}</span>
                </td>
              </tr>
            @endif
            @if(array_key_exists('custom_pay_3', $payment_types))
              <tr>
                <td>
                  {{$payment_types['custom_pay_3']}}:
                </td>
                <td>
                  <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_3 }}</span>
                </td>
              </tr>
            @endif
            @if(array_key_exists('custom_pay_4', $payment_types))
              <tr>
                <td>
                  {{$payment_types['custom_pay_4']}}:
                </td>
                <td>
                  <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_4 }}</span>
                </td>
              </tr>
            @endif
            @if(array_key_exists('custom_pay_5', $payment_types))
              <tr>
                <td>
                  {{$payment_types['custom_pay_5']}}:
                </td>
                <td>
                  <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_5 }}</span>
                </td>
              </tr>
            @endif
            @if(array_key_exists('custom_pay_6', $payment_types))
              <tr>
                <td>
                  {{$payment_types['custom_pay_6']}}:
                </td>
                <td>
                  <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_6 }}</span>
                </td>
              </tr>
            @endif
            @if(array_key_exists('custom_pay_7', $payment_types))
              <tr>
                <td>
                  {{$payment_types['custom_pay_7']}}:
                </td>
                <td>
                  <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_7 }}</span>
                </td>
              </tr>
            @endif
            <tr>
              <td>
                @lang('cash_register.other_payments'):
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_other }}</span>
              </td>
            </tr>
            <tr>
              <td>
                @lang('cash_register.total_sales'):
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_sale }}</span>
              </td>
            </tr>
            <tr class="success">
              <th>
                @lang('cash_register.total_refund')
              </th>
              <td>
                <b><span class="display_currency" data-currency_symbol="true">{{ $register_details->total_refund }}</span></b><br>
                <small>
                @if($register_details->total_cash_refund != 0)
                  Cash: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_cash_refund }}</span><br>
                @endif
                @if($register_details->total_cheque_refund != 0) 
                  Cheque: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_cheque_refund }}</span><br>
                @endif
                @if($register_details->total_card_refund != 0) 
                  Card: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_card_refund }}</span><br> 
                @endif
                @if($register_details->total_bank_transfer_refund != 0)
                  Bank Transfer: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_bank_transfer_refund }}</span><br>
                @endif
                @if(array_key_exists('custom_pay_1', $payment_types) && $register_details->total_custom_pay_1_refund != 0)
                    {{$payment_types['custom_pay_1']}}: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_1_refund }}</span>
                @endif
                @if(array_key_exists('custom_pay_2', $payment_types) && $register_details->total_custom_pay_2_refund != 0)
                    {{$payment_types['custom_pay_2']}}: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_2_refund }}</span>
                @endif
                @if(array_key_exists('custom_pay_3', $payment_types) && $register_details->total_custom_pay_3_refund != 0)
                    {{$payment_types['custom_pay_3']}}: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_3_refund }}</span>
                @endif
                @if($register_details->total_other_refund != 0)
                  Other: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_other_refund }}</span>
                @endif
                </small>
              </td>
            </tr>
            <tr class="success">
              <th>
                @lang('lang_v1.total_payment')
              </th>
              <td>
                <b><span class="display_currency" data-currency_symbol="true">{{ $register_details->cash_in_hand + $register_details->total_cash - $register_details->total_cash_refund }}</span></b>
              </td>
            </tr>
            <tr class="success">
              <th>
                @lang('lang_v1.credit_sales'):
              </th>
              <td>
                <b><span class="display_currency" data-currency_symbol="true">{{ $details['transaction_details']->total_sales - $register_details->total_sale }}</span></b>
              </td>
            </tr>
            <tr class="success">
              <th>
                @lang('cash_register.total_sales'):
              </th>
              <td>
                <b><span class="display_currency" data-currency_symbol="true">{{ $details['transaction_details']->total_sales }}</span></b>
              </td>
            </tr>
          </table>
        </div>
      </div>

      @include('cash_register.register_product_details')

      <div class="row">
        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('closing_amount', __( 'cash_register.total_cash' ) . ':*') !!}
              {!! Form::text('closing_amount', @num_format($register_details->cash_in_hand + $register_details->total_cash - $register_details->total_cash_refund), ['class' => 'form-control input_number', 'required', 'placeholder' => __( 'cash_register.total_cash' ) ]); !!}
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('total_card_slips', __( 'cash_register.total_card_slips' ) . ':*') !!} @show_tooltip(__('tooltip.total_card_slips'))
              {!! Form::number('total_card_slips', $register_details->total_card_slips, ['class' => 'form-control', 'required', 'placeholder' => __( 'cash_register.total_card_slips' ), 'min' => 0 ]); !!}
          </div>
        </div> 
        <div class="col-sm-4">
          <div class="form-group">
            {!! Form::label('total_cheques', __( 'cash_register.total_cheques' ) . ':*') !!} @show_tooltip(__('tooltip.total_cheques'))
              {!! Form::number('total_cheques', $register_details->total_cheques, ['class' => 'form-control', 'required', 'placeholder' => __( 'cash_register.total_cheques' ), 'min' => 0 ]); !!}
          </div>
        </div> 
        <hr>
        <div class="col-md-8 col-sm-12">
          <h3>@lang( 'lang_v1.cash_denominations' )</h3>
          @if(!empty($pos_settings['cash_denominations']))
            <table class="table table-slim">
              <thead>
                <tr>
                  <th width="20%" class="text-right">@lang('lang_v1.denomination')</th>
                  <th width="20%">&nbsp;</th>
                  <th width="20%" class="text-center">@lang('lang_v1.count')</th>
                  <th width="20%">&nbsp;</th>
                  <th width="20%" class="text-left">@lang('sale.subtotal')</th>
                </tr>
              </thead>
              <tbody>
                @foreach(explode(',', $pos_settings['cash_denominations']) as $dnm)
                <tr>
                  <td class="text-right">{{$dnm}}</td>
                  <td class="text-center" >X</td>
                  <td>{!! Form::number("denominations[$dnm]", null, ['class' => 'form-control cash_denomination input-sm', 'min' => 0, 'data-denomination' => $dnm, 'style' => 'width: 100px; margin:auto;' ]); !!}</td>
                  <td class="text-center">=</td>
                  <td class="text-left">
                    <span class="denomination_subtotal">0</span>
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="4" class="text-center">@lang('sale.total')</th>
                  <td><span class="denomination_total">0</span></td>
                </tr>
              </tfoot>
            </table>
          @else
            <p class="help-block">@lang('lang_v1.denomination_add_help_text')</p>
          @endif
        </div>
        <hr>
        <div class="col-sm-12">
          <div class="form-group">
            {!! Form::label('closing_note', __( 'cash_register.closing_note' ) . ':') !!}
              {!! Form::textarea('closing_note', null, ['class' => 'form-control', 'placeholder' => __( 'cash_register.closing_note' ), 'rows' => 3 ]); !!}
          </div>
        </div>
      </div> 

      <div class="row">
        <div class="col-xs-6">
          <b>@lang('report.user'):</b> {{ $register_details->user_name}}<br>
          <b>@lang('business.email'):</b> {{ $register_details->email}}<br>
          <b>@lang('business.business_location'):</b> {{ $register_details->location_name}}<br>
        </div>
        @if(!empty($register_details->closing_note))
          <div class="col-xs-6">
            <strong>@lang('cash_register.closing_note'):</strong><br>
            {{$register_details->closing_note}}
          </div>
        @endif
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.cancel' )</button>
      <button type="submit" class="btn btn-primary">@lang( 'cash_register.close_register' )</button>
    </div>
    {!! Form::close() !!}
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->