@extends('layouts.app')

@section('title', __('crm::lang.lead'))

@section('content')
    @include('crm::layouts.nav')
    <!-- Content Header (Page header) -->
    <section class="content-header no-print">
        <h1>@lang('crm::lang.leads')</h1>
    </section>

    <section class="content no-print">
        <div class="row">
            <div class="col-sm-12">
                @component('components.widget', ['class' => 'box-primary'])
                    {!! Form::open(['url' => url('crm/contact-leads-import'), 'method' => 'post', 'enctype' => 'multipart/form-data' ]) !!}
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    {!! Form::label('name', __( 'product.file_to_import' ) . ':') !!}
                                    {!! Form::file('contacts_csv', ['accept'=> '.xls', 'required' => 'required']); !!}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <br>
                                <button type="submit" class="btn btn-primary">@lang('messages.submit')</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                    <br><br>
                    <div class="row">
                        <div class="col-sm-4">
                            <a href="{{ asset('files/import_crm_lead_csv_template.xls') }}" class="btn btn-success"
                               download><i class="fa fa-download"></i> @lang('lang_v1.download_template_file')</a>
                        </div>
                    </div>
                @endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                @component('components.widget', ['class' => 'box-primary', 'title' => __('lang_v1.instructions')])
                    <strong>@lang('lang_v1.instruction_line1')</strong><br>
                    @lang('lang_v1.instruction_line2')
                    <br><br>
                    <table class="table table-striped">
                        <tr>
                            <th>@lang('lang_v1.col_no')</th>
                            <th>@lang('lang_v1.col_name')</th>
                            <th>@lang('lang_v1.instruction')</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>@lang('business.prefix') <small class="text-muted">(@lang('lang_v1.optional'))</small>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>
                                @lang('business.first_name')
                                <small class="text-muted">(@lang('lang_v1.required'))</small>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>@lang('lang_v1.middle_name') <small class="text-muted">(@lang('lang_v1.optional')
                                    )</small></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>@lang('business.last_name') <small class="text-muted">(@lang('lang_v1.optional')
                                    )</small></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>@lang('business.business_name')</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>@lang('lang_v1.contact_id') <small class="text-muted">(@lang('lang_v1.optional')
                                    )</small></td>
                            <td>@lang('lang_v1.contact_id_ins')</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>@lang('contact.tax_no') <small class="text-muted">(@lang('lang_v1.optional'))</small>
                            </td>
                            <td>&nbsp;</td>
                        </tr>

                        <tr>
                            <td>8</td>
                            <td>@lang('business.email') <small class="text-muted">(@lang('lang_v1.optional'))</small>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>@lang('contact.mobile') <small class="text-muted">(@lang('lang_v1.required'))</small>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>@lang('contact.alternate_contact_number') <small
                                        class="text-muted">(@lang('lang_v1.optional'))</small></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>11</td>
                            <td>@lang('contact.landline') <small class="text-muted">(@lang('lang_v1.optional'))</small>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td>@lang('business.city') <small class="text-muted">(@lang('lang_v1.optional'))</small>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>13</td>
                            <td>@lang('business.state') <small class="text-muted">(@lang('lang_v1.optional'))</small>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td>@lang('business.country') <small class="text-muted">(@lang('lang_v1.optional'))</small>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>15</td>
                            <td>@lang('lang_v1.address_line_1') <small class="text-muted">(@lang('lang_v1.optional')
                                    )</small></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>16</td>
                            <td>@lang('lang_v1.address_line_2') <small class="text-muted">(@lang('lang_v1.optional')
                                    )</small></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>17</td>
                            <td>@lang('business.zip_code') <small class="text-muted">(@lang('lang_v1.optional'))</small>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>18</td>
                            <td>@lang('lang_v1.dob') <small class="text-muted">(@lang('lang_v1.optional'))</small></td>
                            <td>@lang('lang_v1.dob_ins') ({{\Carbon::now()->format('Y-m-d')}})</td>
                        </tr>
                        @php
                            $custom_labels = json_decode(session('business.custom_labels'), true);
                        @endphp
                        <tr>
                            <td>19</td>
                            <td>{{ $custom_labels['contact']['custom_field_1'] ?? __('lang_v1.contact_custom_field1') }}
                                <small class="text-muted">(@lang('lang_v1.optional'))</small></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>20</td>
                            <td>{{ $custom_labels['contact']['custom_field_2'] ?? __('lang_v1.contact_custom_field2') }}
                                <small class="text-muted">(@lang('lang_v1.optional'))</small></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>21</td>
                            <td>{{ $custom_labels['contact']['custom_field_3'] ?? __('lang_v1.contact_custom_field3') }}
                                <small class="text-muted">(@lang('lang_v1.optional'))</small></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>22</td>
                            <td>{{ $custom_labels['contact']['custom_field_4'] ?? __('lang_v1.contact_custom_field4') }}
                                <small class="text-muted">(@lang('lang_v1.optional'))</small></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>23</td>
                            <td>@lang('crm::lang.sources')</td>
                            <td>
                                <p><b>Available option</b></p>
                                @foreach($lead_categories->where('category_type','source') as $lead_category)
                                    <p>{{$lead_category->id.'='.$lead_category->name}}</p>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>24</td>
                            <td>@lang('crm::lang.life_stage')</td>
                            <td>
                                <p><b>Available option</b></p>
                                @foreach($lead_categories->where('category_type','life_stage') as $lead_category)
                                    <p>{{$lead_category->id.'='.$lead_category->name}}</p>
                                @endforeach
                            </td>
                        </tr>
                    </table>
                @endcomponent
            </div>
        </div>
    </section>
@endsection
@section('javascript')
    <script type="text/javascript">
    </script>
@endsection