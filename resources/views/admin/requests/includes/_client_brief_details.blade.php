<div class="media align-items-center">
    <span class="tx-color-03 d-none d-sm-block">

        @php
            if ($serviceRequest['client']['account']['gender'] == 'male' || $serviceRequest['client']['account']['gender'] == 'others') {
                $genderAvatar = 'default-male-avatar.png' ?? 'default-female-avatar.png';
            }
        @endphp

        @if (empty($serviceRequest['client']['account']['avatar']))
            <img src="{{ asset('assets/images/' . $genderAvatar) }}" class="avatar rounded-circle"
                alt="Default avatar">
        @elseif(!file_exists(public_path('assets/user-avatars/'.$serviceRequest['client']['account']['avatar'])))
            <img src="{{ asset('assets/images/' . $genderAvatar) }}" class="avatar rounded-circle"
                alt="Profile avatar">
        @else
            <img src="{{ asset('assets/user-avatars/' . $serviceRequest['client']['account']['avatar']) }}"
                class="avatar rounded-circle" alt="Profile avatar">
        @endif

    </span>
    <div class="media-body mg-sm-l-20">
        <h4 class="tx-18 tx-sm-20 mg-b-2">
            {{ ucfirst($serviceRequest['client']['account']['first_name']) }}
            {{ ucfirst($serviceRequest['client']['account']['last_name']) }}
            <a class="btn btn-sm btn-primary btn-icon" title="Call Client"
        @if($serviceRequest['contactme_status'] == 1) href="tel:{{ $serviceRequest['client']['account']['contact']['phone_number'] }}" @else href="#" @endif id="contact-me" data-contact-me="{{ $serviceRequest['contactme_status'] }}"><i class="fas fa-phone"></i> </a>

        </h4>

        <p class="tx-13 tx-color-03 mg-b-0">Scheduled Date:
            {{ !empty($serviceRequest['preferred_time']) ? Carbon\Carbon::parse($serviceRequest['preferred_time'], 'UTC')->isoFormat('MMMM Do YYYY') : 'UNSCHEDULED' }}
        </p>
        <p class="tx-13 tx-color-03 mg-b-0">Job Ref.: {{ $serviceRequest['unique_id'] }} </p>
    </div>
</div><!-- media -->