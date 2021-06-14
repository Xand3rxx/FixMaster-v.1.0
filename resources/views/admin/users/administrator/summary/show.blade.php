@extends('layouts.dashboard')
@section('title', Str::title($user['account']['last_name'] ." ". $user['account']['first_name'].'\'s Summary'))
@section('content')
@include('layouts.partials._messages')

<div class="content-body">
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.administrator.index', app()->getLocale())}}">Administrators List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ Str::title($user['account']['last_name'] ." ". $user['account']['first_name']) }}</li>
                    </ol>
                </nav>
            </div>

            <div class="d-md-block">
                <a href="{{ route('admin.users.administrator.index', app()->getLocale()) }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>

            </div>
        </div>

        <div class="row row-xs">
            <div class="col-sm-12 col-lg-12">
                <div class="card mg-b-20 mg-lg-b-25">
                    <div class="card-header pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
                        <h6 class="tx-uppercase tx-semibold mg-b-0">{{ Str::title($user['account']['last_name'] ." ". $user['account']['first_name']) }} Summary</h6>
                    </div><!-- card-header -->
                    <div class="card-body pd-25">
                        <div class="media">
                            <div class="pos-relative d-inline-block mg-b-20">
                                <div class="avatar avatar-xxl"><span class="avatar-initial rounded-circle bg-gray-700 tx-normal"><i class="icon ion-md-person"></i></span></div>
                            </div>
                            <div class="media-body pd-l-25">
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm mg-b-0">
                                        <tbody>
                                            <tr>
                                                <td class="tx-medium">Full Name</td>
                                                <td class="tx-color-03">{{ Str::title($user['account']['last_name'] ." ". $user['account']['middle_name'] ." ". $user['account']['first_name']) }} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">E-Mail</td>
                                                <td class="tx-color-03">{{$user['email'] }}</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Phone Number</td>
                                                <td class="tx-color-03">{{$user->contact->phone_number ?? 'UNAVAILABLE' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Designation</td>
                                                <td class="tx-color-03">{{$user['roles'][0]['name']}}</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Status</td>
                                                <td class="tx-color-03">{{is_null($user['deleted_at']) ? 'Active' : InActive}}</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Created By</td>
                                                <td class="tx-color-03">{{ $user['administrator']['created_by'] }} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Date Created</td>
                                                <td class="tx-color-03">{{ Carbon\Carbon::parse($user->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }} ({{$user->created_at->diffForHumans() }})</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Last Edited</td>
                                                <td class="tx-color-03">
                                                    {{!empty($user->updated_at) ? Carbon\Carbon::parse($user->updated_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa')  : 'NEVER'}}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="tx-medium">Requests Supervised</td>
                                                <td class="tx-color-03">{{$requests_supervised}}</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Payments Disbursed</td>
                                                <td class="tx-color-03">{{$payments_disbursed}}</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Messages Sent</td>
                                                <td class="tx-color-03">{{$messages_sent}}</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Login Count</td>
                                                <td class="tx-color-03">{{$logs['logs_count'] }}</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Last Seen</td>
                                                <td class="tx-color-03">{{!empty($last_seen['created_at']) ? Carbon\Carbon::parse($last_seen['created_at'], 'UTC')->diffForHumans()  : 'NEVER'}}</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')

    @endsection

    @endsection
