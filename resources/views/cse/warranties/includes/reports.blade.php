
                        <h3>Report</h3>
                        <section>
                            <div class="mt-4 form-row">
                                <div class="form-group col-md-12">
                                    <label for="cse_comment">Diagnostic Report</label>
                                    <textarea rows="3" class="form-control @error('cse_comment ') is-invalid @enderror" id="cse_comment " name="cse_comment"></textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-11">
                                    <label>Faulty Image</label>
                                    <div class="custom-file">
                                        <input type="file" accept="image/*" class="custom-file-input @error('image[0]') is-invalid @enderror" name="upload_image[]" id="image">
                                        <label class="custom-file-label" for="image">Upload faulty parts image</label>
                                        @error('image[0]')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group col-md-1 mt-1">
                                    <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 mt-4 add-image" type="button"><i class="fas fa-plus" class="wd-10 mg-r-5"></i></button>
                                </div>
                            </div>

                            <span class="add-image-row"></span>

                        </section>