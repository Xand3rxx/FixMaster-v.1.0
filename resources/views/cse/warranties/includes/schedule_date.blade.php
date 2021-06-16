<h3>Scheduled Fix Date </h3>
                        <section>
                        
                            <div class="mt-4 form-row">
                                <div class="form-group col-md-12">
                                    <label for="preferred_time">Scheduled Fix Date</label> <span style="color:red">(required)</span>
                                    <input id="service-date-time" type="text" readonly min="{{ \Carbon\Carbon::now()->isoFormat('2021-04-13 00:00:00') }}" class="form-control @error('preferred_time') is-invalid @enderror"
                                     name="preferred_time"
                                      placeholder="Click to Enter Scheduled Date" value="{{ old('preferred_time') }}">
                                    
                                    @error('preferred_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </section>