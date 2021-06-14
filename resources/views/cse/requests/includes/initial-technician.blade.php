@php
$useable = $technicians->filter(function ($tech, $key) use ($service_request) {
    return $tech['services']->first(function ($service, $key) use ($service_request) {
        return $service['service_id'] == $service_request['service_id'];
    });
});
@endphp
<h3>Assign Technician </h3>
<section>
    <div class="form-group col-md-12">
        <ul class="list-group wd-md-100p">
            @foreach ($useable as $technicain)
                <li class="list-group-item d-flex align-items-center">
                    <div class="form-row">
                        <img src="{{ asset('assets/images/default-male-avatar.png') }}"
                            class="wd-30 rounded-circle mg-r-15" alt="Technician Avatar">

                        <div class="col-md-6 col-sm-6">
                            <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">
                                {{ $technicain['user']['account']['first_name'] . ' ' . $technicain['user']['account']['last_name'] }}
                            </h6>

                            <span class="d-block tx-11 text-muted">
                                <i class="icon ion-md-star lh-0 tx-orange"></i>
                                <span
                                    class="font-weight-bold ml-2">{{ \App\Traits\CalculateDistance::getDistanceBetweenPoints($service_request['client']['contact']['address_latitude'], $service_request['client']['contact']['address_longitude'], $technicain['user']['contact']['address_latitude'], $technicain['user']['contact']['address_longitude']) }}
                                    km</span>
                            </span>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-row">
                                <div class="form-group col-1 col-md-1 col-sm-1" style="margin-left: 3rem !important;">
                                    <a href="tel:{{ $technicain['user']['contact']['phone_number'] }}"
                                        class="btn btn-primary btn-icon"> <i class="fas fa-phone"></i></a>
                                </div>
                                <div class="form-group col-1 col-md-1 col-sm-1">
                                    <div class="custom-control custom-radio mt-2">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input"
                                                id="technician{{ $loop->iteration }}" name="technician_user_uuid"
                                                value="{{ $technicain['user']['uuid'] }}">
                                            <label class="custom-control-label"
                                                for="technician{{ $loop->iteration }}"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</section>
