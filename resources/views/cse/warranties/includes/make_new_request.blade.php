

  <div class="divider-text">Create Request  </div>


                                <h4 id="section1" class="mt-4 mb-2">Make Request</h4>
                                <div class="form-row">

                                    <div class="form-group col-md-4">
                                        <label for="manufacturer_name">Manufacturer Name</label>
                                        <input type="text" class="form-control @error('manufacturer_name') is-invalid @enderror" id="new_manufacturer_name" name="new_manufacturer_name[]" value="{{ old('new_manufacturer_name[0]') }}">
                                        @error('manufacturer_name[0]')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="model_number">Model Number</label>
                                        <input type="text" class="form-control @error('model_number') is-invalid @enderror" id="model_number" name="new_model_number[]" placeholder="" value="{{ old('new_model_number[0]') }}">
                                        @error('model_number[0]')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="component_name">Component Name</label>
                                        <input type="text" class="form-control @error('component_name') is-invalid @enderror" id="component_name" name="new_component_name[]" value="{{ old('new_component_name[0]') }}">
                                        @error('component_name[0]')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="new_quantity[]" min="1" pattern="\d*" maxlength="2" value="{{ old('new_quantity[0]') }}">
                                        @error('quantity[0]')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="size">Size</label>
                                        <input type="number" class="form-control @error('size') is-invalid @enderror" id="size" name="new_size[]" min="1" pattern="\d*" maxlength="2" value="{{ old('new_size[0]') }}">
                                        @error('size[0]')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="unit_of_measurement">Unit of Measurement</label>
                                        <input type="text" class="form-control @error('unit_of_measurement') is-invalid @enderror" id="unit_of_measurement" name="new_unit_of_measurement[]" value="{{ old('new_unit_of_measurement[0]') }}">
                                        @error('unit_of_measurement[0]')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Image</label>
                                        <div class="custom-file">
                                            <input type="file" accept="image/*" class="custom-file-input @error('image') is-invalid @enderror" name="new_image[]" id="image">
                                            <label class="custom-file-label" for="image">Component Image</label>
                                            @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group col-md-1 mt-1">
                                        <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 mt-4 add-rfq" type="button"><i class="fas fa-plus" class="wd-10 mg-r-5"></i></button>
                                    </div>
                                </div>

                                <span class="add-rfq-row"></span>

                          
                    