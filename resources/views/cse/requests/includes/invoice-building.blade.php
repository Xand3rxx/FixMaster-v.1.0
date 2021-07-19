<h3>Invoice building</h3>
<section>
    {{-- <small class="text-danger">This portion will be displayed only if the CSE selects "Completed Diganosis" and the
        Client chooses to continue with the Service Request</small> --}}
    <div class="mt-4 form-row">
        <div class="form-group col-md-6">
            <label for="estimated_hours">Estimated Work Hours</label>
            <select id="estimated_work_hours" class="form-control custom-select @error('estimated_work_hours') is-invalid @enderror" name="estimated_work_hours">
                <option value="" selected>Select...</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>
            @error('estimated_hours')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="category_id">Category</label>
            <input type="text" class="form-control" readonly
                value="{{ $service_request['service']['category']['name'] }}">
        </div>

        <div class="form-group col-md-6">
            <label for="service_id">Service</label>
            <input type="text" class="form-control" readonly value="{{ $service_request['service']['name'] }}">
        </div>
        <div class="form-group col-md-6 position-relative">
            <label for="sub_service_uuid">Sub Service</label>
            <select class="form-control selectpicker" name="sub_service_uuid[]" id="sub_service_uuid" multiple>
                <option disabled value="">Select Sub service</option>
                @foreach ($service_request['sub_services'] as $key => $sub_service_uuid)
                    <option value="{{ $sub_service_uuid['uuid'] }}" data-count="{{ $key }}"
                        data-sub-service-name="{{ \App\Models\SubService::getNameUsingUUID($sub_service_uuid['uuid']) }}">
                        {{ \App\Models\SubService::getNameUsingUUID($sub_service_uuid['uuid']) }} </option>
                @endforeach
            </select>
            @error('sub_service_uuid')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <span class="mt-2 sub-service-report"></span>


    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="root_cause">Root Cause <span class="text-danger">*</span></label>
            <textarea rows="3" class="form-control @error('root_cause') is-invalid @enderror" id="root_cause"
                name="root_cause"></textarea>
        </div>
        <div class="form-group col-md-12">
            <label for="comments">Other Comments(Optional)</label>
            <textarea rows="3" name="other_comments" class="form-control @error('comments') is-invalid @enderror" id="comments"
                name="comments"></textarea>
        </div>
    </div>

</section>

{{-- New RFQ --}}
<h3>New RFQ</h3>
<section>
    <p class="mg-b-0">A request for quotation is a business process in which a company or public entity
        requests a quote from a supplier for the purchase of specific products or services.</p>
    <h4 id="section1" class="mt-4 mb-2">Initiate RFQ?</h4>

    <div class="form-row mt-4">
        <div class="form-group col-md-4">
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="rfqYes" name="intiate_rfq" value="yes">
                <label class="custom-control-label" for="rfqYes">Yes</label><br>
            </div>
        </div>
        <div class="form-group col-md-4 d-flex align-items-end">
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="rfqNo" name="intiate_rfq" value="" checked>
                <label class="custom-control-label" for="rfqNo">No</label><br>
            </div>
        </div>
    </div>

    <div class="d-none d-rfq">
        <h4 id="section1" class="mt-4 mb-2">Make Request</h4>
        <div class="form-row">

            <div class="form-group col-md-4">
                <label for="manufacturer_name">Manufacturer Name</label>
                <input type="text" class="form-control @error('manufacturer_name') is-invalid @enderror"
                    id="manufacturer_name" name="manufacturer_name[]" value="{{ old('manufacturer_name[0]') }}">
                @error('manufacturer_name[0]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-3">
                <label for="model_number">Model Number</label>
                <input type="text" class="form-control @error('model_number') is-invalid @enderror" id="model_number"
                    name="model_number[]" placeholder="" value="{{ old('model_number[0]') }}">
                @error('model_number[0]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="component_name">Component Name</label>
                <input type="text" class="form-control @error('component_name') is-invalid @enderror"
                    id="component_name" name="component_name[]" value="{{ old('component_name[0]') }}">
                @error('component_name[0]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-2">
                <label for="quantity">Quantity</label>
                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity"
                    name="quantity[]" min="1" pattern="\d*" maxlength="2" value="{{ old('quantity[0]') }}">
                @error('quantity[0]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-2">
                <label for="size">Size</label>
                <input type="number" class="form-control @error('size') is-invalid @enderror" id="size" name="size[]"
                    min="1" pattern="\d*" maxlength="2" value="{{ old('size[0]') }}">
                @error('size[0]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="unit_of_measurement">Unit of Measurement</label>
                <input type="text" class="form-control @error('unit_of_measurement') is-invalid @enderror"
                    id="unit_of_measurement" name="unit_of_measurement[]"
                    value="{{ old('unit_of_measurement[0]') }}">
                @error('unit_of_measurement[0]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-3">
                <label>Image</label>
                <div class="custom-file">
                    <input type="file" accept="image/*" class="custom-file-input @error('image.*') is-invalid @enderror"
                        name="image[]" id="image">
                    <label class="custom-file-label" for="image">Component Image</label>
                    @error('image.*')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group col-md-1 mt-1">
                <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 mt-4 add-rfq" type="button"><i
                        class="fas fa-plus" class="wd-10 mg-r-5"></i></button>
            </div>
        </div>
        <span class="add-rfq-row"></span>
    </div>
</section>
{{-- End New RFQ --}}

{{-- New Tools Request --}}
<h3>New Tools Request</h3>
<section>
    <p class="mg-b-0">A request form to procure tools and equipments from <span>FixMaster</span> to properly
        carry out a Service Request.</p>

    <h4 id="section1" class="mt-4 mb-2">Initiate Tools Request?</h4>
    <div class="form-row mt-4 ">
        <div class="form-group col-md-4">
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="trfYes" name="intiate_trf" value="yes">
                <label class="custom-control-label" for="trfYes">Yes</label><br>
            </div>
        </div>
        <div class="form-group col-md-4 d-flex align-items-end">
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="trfNo" name="intiate_trf" value="no" checked>
                <label class="custom-control-label" for="trfNo">No</label><br>
            </div>
        </div>
    </div>

    <div class="d-none d-trf">
        <h4 id="section1" class="mt-4 mb-2">Make Request</h4>
        <div class="form-row tool-request">
            <div class="form-group col-md-4">
                <label for="tool_id">Equipment/Tools Name</label>
                <select class="form-control custom-select @error('tool_id') is-invalid @enderror tool_id" id="tool_id"
                    name="tool_id[]">
                    <option value="" selected>Select...</option>
                    @foreach ($tools as $tool)
                        <option value="{{ $tool->id }}" {{ old('tool_id[0]') == $tool->id ? 'selected' : '' }}
                            data-id="tool_quantity">{{ $tool->name }}</option>
                    @endforeach
                </select>
                @error('tool_id[0]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group quantity-section col-md-2">
                <label for="tool_quantity">Quantity</label>
                <input type="number" class="form-control @error('tool_quantity[0]') is-invalid @enderror tool_quantity"
                    name="tool_quantity[]" id="tool_quantity" min="1" pattern="\d*" maxlength="2"
                    value="{{ old('tool_quantity[0]') }}">
                @error('tool_quantity[0]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-2 mt-1">
                <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 mt-4 add-trf" type="button"><i
                        class="fas fa-plus" class="wd-10 mg-r-5"></i></button>
            </div>
        </div>
        <span class="add-trf-row"></span>
    </div>
</section>
{{-- End Tools Request --}}

@push('scripts')
    <script defer>
        $(function() {
            'use strict'
            $(document).on('change', '#sub_service_uuid', function() {
                let $subServiceUuidList = [];
                let $subServiceUuid = $(this).val();
                $subServiceUuidList.push($subServiceUuid);
                let route = '{{ route('cse.sub_service_dynamic_fields', app()->getLocale()) }}';

                $.ajax({
                    url: route,
                    beforeSend: function() {
                        $(".sub-service-report").html(
                            '<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>'
                        );
                    },
                    data: {
                        "sub_service_list": $subServiceUuidList
                    },
                    // return the result
                    success: function(result) {
                        $('.sub-service-report').html('');
                        $('.sub-service-report').html(result);
                    },
                    error: function(jqXHR, testStatus, error) {
                        var message = error +
                            ' An error occured while trying to retireve sub service details.';
                        var type = 'error';
                        displayMessage(message, type);
                        $("#spinner-icon").hide();
                    },
                    timeout: 8000
                })
            });

            // RFQ begin
            $('#rfqYes').change(function() {
                if ($(this).prop('checked')) {
                    $('.d-rfq').removeClass('d-none');
                }
            });

            $('#rfqNo').change(function() {
                if ($(this).prop('checked')) {
                    $('.d-rfq').addClass('d-none');
                }
            });

            let count = 1;
            function addRFQ(count){
                let html = '<div class="form-row remove-rfq-row"><div class="form-group col-md-4"> <label for="manufacturer_name">Manufacturer Name</label> <input type="text" class="form-control  id="manufacturer_name" name="manufacturer_name[]" value=""> </div><div class="form-group col-md-3"> <label for="model_number">Model Number</label> <input type="text" class="form-control  id="model_number" name="model_number[]" placeholder="" value=""> </div><div class="form-group col-md-4"> <label for="component_name">Component Name</label> <input type="text" class="form-control" id="component_name" name="component_name[]" value=""> </div><div class="form-group col-md-2"> <label for="quantity">Quantity</label> <input type="number" class="form-control " id="quantity" name="quantity[]" min="1" pattern="d*" maxlength="2" value=""> </div><div class="form-group col-md-2"> <label for="size">Size</label> <input type="number" class="form-control " id="size" name="size[]" min="1" pattern="d*" maxlength="2" value=""> </div><div class="form-group col-md-4"> <label for="unit_of_measurement">Unit of Measurement</label> <input type="text" class="form-control " id="unit_of_measurement" name="unit_of_measurement[]" value=""> </div><div class="form-group col-md-3"> <label>Image</label><div class="custom-file"> <input type="file" accept="image/*" class="custom-file-input " name="image[]" id="image"> <label class="custom-file-label" for="image">Component Image</label> </div></div><div class="form-group col-md-1 mt-1"> <button class="btn btn-sm pd-x-15 btn-danger btn-uppercase mg-l-5 mt-4 remove-rfq" type="button"><i class="fas fa-times" class="wd-10 mg-r-5"></i></button></div></div>';
                $('.add-rfq-row').append(html);
            }
                
            //Add and Remove Request for
            $(document).on('click', '.add-rfq', function() {
                count++;
                addRFQ(count);
            });
            $(document).on('click', '.remove-rfq', function() {
                count--;
                $(this).closest(".remove-rfq-row").remove();
            });
            // End RFQ

            // Tool Request Begin
            $('#trfYes').change(function() {
                if ($(this).prop('checked')) {
                    $('.d-trf').removeClass('d-none');
                }
            });
            $('#trfNo').change(function() {
                if ($(this).prop('checked')) {
                    $('.d-trf').addClass('d-none');
                }
            });

            let addTRFcount = 1;
            function addTRF(count){
                let html = '<div class="tool-request form-row remove-trf-row"><div class="form-group col-md-4"> <label for="tool_id">Equipment/Tools Name</label> <select class="form-control custom-select tool_id" id="tool_id" name="tool_id[]" ><option value="0" selected>Select...</option> @foreach($tools as $tool)<option value="{{ $tool->id }}" data-id="tool_quantity'+count+'">{{ $tool->name }}</option> @endforeach </select> </div><div class="form-group quantity-section col-md-2"> <label for="tool_quantity">Quantity</label> <input type="number" class="form-control tool_quantity" name="tool_quantity[]" id="tool_quantity'+count+'" min="1" pattern="\d*" maxlength="2" value=""> </div><div class="form-group col-md-2 mt-1"> <button class="btn btn-sm pd-x-15 btn-danger btn-uppercase mg-l-5 mt-4 remove-trf" type="button"><i class="fas fa-times" class="wd-10 mg-r-5"></i> </button></div></div>';
                $('.add-trf-row').append(html);
            }
            //Add and Remove Tools request form
            $(document).on('click', '.add-trf', function() {
                addTRFcount++;
                addTRF(addTRFcount);
            });
            $(document).on('click', '.remove-trf', function() {
                addTRFcount--;
                $(this).closest(".remove-trf-row").remove();
            });
            //Get available quantity of a particular tool.
            $(document).on('change', '.tool_id', function() {
                let toolId = $(this).find('option:selected').val();
                let toolName = $(this).children('option:selected').text();
                let quantityName = $(this).children('option:selected').data('id');
                $.ajax({
                    url: "{{ route('cse.available.tools', app()->getLocale()) }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "tool_id": toolId
                    },
                    success: function(data) {
                        if (data) {
                            $('#' + quantityName + '').attr({
                                "value": data,
                                "max": data,
                            });
                        } else {
                            var message = 'Error occured while trying to get ' + toolName +
                                ' available quantity';
                            var type = 'error';
                            displayMessage(message, type);
                        }
                    },
                })
            });
            // End Tools Request
        });
    </script>
@endpush
