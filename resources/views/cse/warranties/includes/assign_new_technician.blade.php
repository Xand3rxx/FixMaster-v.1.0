@foreach ($technician_list as $technician)
                                        <li class="list-group-item d-flex align-items-center">
                                            
                                            <div class="form-row">
                                            <img src="{{ asset('assets/user-avatars/'.$technician['user']['account']['avatar']??'default-male-avatar.png') }}" class="wd-30 rounded-circle mg-r-15" alt="Technician Avatar">
                                            
                                            <div class="col-md-6 col-sm-6">
                                            <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">{{ !empty($technician['user']['account']['first_name']) ? $technician['user']['account']['first_name'] .' '. $technician['user']['account']['last_name'] : 'UNAVAILABLE'}}</h6>
                                            
                                            <span class="d-block tx-11 text-muted">
                                                {{-- @foreach ($technicians as $item)
                                                    <i class="icon ion-md-star lh-0 tx-orange"></i>
                                                @endforeach --}}
                                                <span class="font-weight-bold ml-2">{{ \App\Traits\CalculateDistance::getDistanceBetweenPoints($service_request['client']['contact']['address_latitude'], $service_request['client']['contact']['address_longitude'], $technician['user']['contact']['address_latitude'], $technician['user']['contact']['address_longitude']) }}
                                                    km</span>
                                            </span>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                            <div class="form-row">
                                                <div class="form-group col-1 col-md-1 col-sm-1" style="margin-left: 3rem !important;">
                                                    <a href="tel:{{$technician['user']['account']['contact']['phone_number']}} " class="btn btn-primary btn-icon"><i class="fas fa-phone"></i></a>
                                                </div>
                                                <div class="form-group col-1 col-md-1 col-sm-1">
                                                    <div class="custom-control custom-radio mt-2">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" id="{{ $loop->iteration }}" name="technician_user_uuid" value="{{$technician['user']['id']}}">
                                                            <label class="custom-control-label" for="{{ $loop->iteration }}"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        </li>
                                        @endforeach