<div id="notifyCSE" class="tab-pane pd-20 pd-xl-25">
    <div class="divider-text">Assign CSE</div>

    <ul class="list-group wd-md-100p">
        @foreach ($cses as $cse)
        <li class="list-group-item d-flex align-items-center">

            <div class="form-row">
                @php
                    if ($cse['user']['account']['gender'] == 'male' || $cse['user']['account']['gender'] == 'others') {
                        $cseGenderAvatar = 'default-male-avatar.png' ?? 'default-female-avatar.png';
                    }
                @endphp

                @if (empty($cse['user']['account']['avatar']))
                    <img src="{{ asset('assets/images/' . $cseGenderAvatar) }}" class="wd-30 rounded-circle mg-r-15" alt="Default avatar">
                @elseif(!file_exists(public_path('assets/user-avatars/'.$cse['user']['account']['avatar'])))
                    <img src="{{ asset('assets/images/' . $cseGenderAvatar) }}" class="wd-30 rounded-circle mg-r-15" alt="Profile avatar">
                @else
                    <img src="{{ asset('assets/user-avatars/' . $cse['user']['account']['avatar']) }}"
                        class="wd-30 rounded-circle mg-r-15" alt="Profile avatar">
                @endif
            </div>

            <div class="col-md-6 col-sm-6">
            <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">{{ !empty($cse['user']['account']['first_name']) ? $cse['user']['account']['first_name'] .' '. $cse['user']['account']['last_name'] : 'UNAVAILABLE'}}</h6>

            <span class="d-block tx-11 text-muted">
                @for ($i = 0; $i < round($cse['user']['ratings']->avg('star')); $i++)
                <i class="icon ion-md-star lh-0 tx-orange"></i>
                @endfor
                @for ($x = 0; $x < (5 - round($cse['user']['ratings']->avg('star'))); $x++)
                    <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                @endfor

                <span class="font-weight-bold ml-2">{{ \App\Traits\CalculateDistance::getDistanceBetweenPoints($serviceRequest['client']['contact']['address_latitude'], $serviceRequest['client']['contact']['address_longitude'], $cse['user']['contact']['address_latitude'], $cse['user']['contact']['address_longitude']) }}km</span> from client's residence.
            </span>
            </div>
            <div class="col-md-6 col-sm-6">
            <div class="form-row">
                <div class="form-group col-1 col-md-1 col-sm-1" style="margin-left: 3rem !important;">
                    <a class="btn btn-sm btn-primary btn-icon" title="Call CSE" href="tel:{{ $cse['user']['contact']['phone_number'] }}"><i class="fas fa-phone"></i> </a>
                </div>
                <div class="form-group col-1 col-md-1 col-sm-1">
                        <div class="custom-control">
                            <form action="{{ route('admin.requests-pending.store', app()->getLocale()) }}" method="POST">
                                @csrf
                                <input type="hidden" class="custom-control-input" id="{{ $loop->iteration }}" name="cse_user_uuid" value="{{ $cse['user']['uuid'] }}">
                                <input type="hidden" class="custom-control-input" id="{{ $loop->iteration }}" name="service_request_uuid" value="{{ $serviceRequest['uuid'] }}">
                                <button class="btn btn-sm btn-success btn-icon" title="Assign CSE"><i class="fas fa-user-check"></i> </button>
                            </form>
                        </div>
                </div>

            </div>
            {{-- </div> --}}
        </div>
        </li>
        @endforeach
    </ul>
</div>