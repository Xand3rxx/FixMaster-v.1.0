<h3>Re-Categorization </h3>
<section>
    <div class="mt-4 form-row">
        <div class="form-group col-md-6">
            <label for="category_uuid">Category</label>
            <select id="catogorized-category"
                class="form-control custom-select @error('category_uuid') is-invalid @enderror" name="category_uuid">
                <option selected disabled value="0" selected>Select Category</option>
                @foreach ($categories as $key => $category)
                    <option {{ $service_request['service']['category']['id'] == $category['id'] ? 'selected' : '' }}
                        value="{{ $category['uuid'] }}">{{ $category['name'] }} </option>
                @endforeach
            </select>
            @error('category_uuid')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="service_uuid">Service</label>
            <select id="service_uuid" class="form-control custom-select @error('service_uuid') is-invalid @enderror"
                name="service_uuid">
                <option selected disabled value="0" selected>Select Service</option>
                {{-- @foreach ($services as $key => $service)
                    <option value="{{ $service['uuid'] }}">{{ $service['name'] }} </option>
                @endforeach --}}
            </select>
            @error('service_uuid')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group col-md-12 position-relative">
            <label for="sub_service_uuid">Sub Service</label>
            <select required id="sub_service_uuid"
                class="form-control sub_service_picker @error('sub_service_uuid') is-invalid @enderror"
                name="sub_service_uuid[]" id="sub_service_uuid" multiple>
                <option disabled value="0">Select Sub service</option>
            </select>
            @error('sub_service_uuid')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group col-md-12">
            <label for="other_comments">Other Comments(Optional)</label>
            <textarea rows="3" class="form-control @error('other_comments') is-invalid @enderror" id="other_comments"
                name="other_comments"></textarea>
        </div>
    </div>
</section>
@push('scripts')
<script defer>
    $(function() {
        'use strict'
        // Re-Categorization
        $('.sub_service_picker').selectpicker(); //Initiate multiple dropdown select

        const services_list = @json($services, JSON_PRETTY_PRINT);
        const category_list = @json($categories, JSON_PRETTY_PRINT);
        // console.log(services_list, category_list);
        const client_selected_category = "{{ $service_request['service']['category']['uuid'] ?? null }}";
        const client_selected_service = "{{ $service_request['service']['uuid'] ?? null }}";

        if (client_selected_category !== null) {
            populate_service_options(client_selected_category)
            $("#service_uuid").val(client_selected_service).change();
            populate_sub_service(client_selected_service);
        }

        $(document).on('change', '#catogorized-category', function() {
            let selected_category_uuid = $(this).val();
            populate_service_options(selected_category_uuid)
            return  populate_sub_service($('#service_uuid').val());
        });

        function populate_service_options(selected_category_uuid) {
            let selectedCategory = category_list.find(function(category, index, arr) {
                return category.uuid === selected_category_uuid
            })
            let selected_category_service = services_list.filter(function(service, index, arr) {
                return service.category_id === selectedCategory.id
            }, selectedCategory);

            $('#service_uuid').find('option').not(':first').remove();
            selected_category_service.forEach((service, index) => {
                $('#service_uuid').append(new Option(service.name, service.uuid));
            });
        }


        function populate_sub_service(selected_service_uuid) {
            let selectedService = services_list.find(function(service, index) {
                return service.uuid === selected_service_uuid
            })
            $.ajax({
                url: "{{ route('cse.needed.sub_service', app()->getLocale()) }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "service_id": selectedService.id
                },
                success: function(data) {
                    $('#sub_service_uuid').find('option').remove();
                    data.sub_services.forEach((sub_service, index) => {
                        $('#sub_service_uuid').append(new Option(sub_service.name,
                            sub_service.uuid));
                    })
                    $('.sub_service_picker').selectpicker('refresh');
                },
                catch: function(error) {
                    return displayMessage('Error finding Sub Service List ', 'error');
                }
            })
        }

        $(document).on('change', '#service_uuid', function() {
            let selected_service_uuid = $(this).val();
            return populate_sub_service(selected_service_uuid)
        });
        // End Re-Categorization
    });
</script>
@endpush

