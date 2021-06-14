@php
    if(Auth::user()['account']['gender'] == 'male' || Auth::user()['account']['gender'] == 'others'){
        $genderAvatar = 'default-male-avatar.png';
    }else{
        $genderAvatar = 'default-female-avatar.png';
    }
@endphp

@if(empty(Auth::user()['account']['avatar']))
    <img src="{{ asset('assets/images/'.$genderAvatar) }}" class="rounded-circle" alt="Default avatar">
@elseif(!file_exists(public_path('assets/user-avatars/'.Auth::user()['account']['avatar'])))
    <img src="{{ asset('assets/images/'.$genderAvatar) }}" class="rounded-circle" alt="Profile avatar">
@else
    <img src="{{ asset('assets/user-avatars/'.Auth::user()['account']['avatar']) }}" class="rounded-circle" alt="Profile avatar">
@endif
