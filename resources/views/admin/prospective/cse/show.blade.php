@extends('layouts.dashboard')
@section('title', 'Prospective Customer Service Executive List')
@include('layouts.partials._messages')

@section('content')
<div class="content-body">
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item"><a href="{{route('admin.index', app()->getLocale())}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.prospective.cse.index', app()->getLocale())}}">CSE List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{Str::title($user['form_data']['first_name']." ".$user['form_data']['last_name'])}}</li>
                </ol>
            </nav>

            <div class="d-md-block">
                <a href="{{route('admin.prospective.cse.index', app()->getLocale())}}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
                @if ($user['status'] == \App\Models\Applicant::STATUSES[0])
                <a href="#" data-user="{{$user['uuid']}}" data-action="approve" class="cse-decision-making btn btn-success"><i class="fas fa-check"></i> Approve </a>
                <a href="#" data-user="{{$user['uuid']}}" data-action="decline" class="cse-decision-making btn btn-danger"><i class="fas fa-ban"></i> Decline </a>
                @endif
            </div>
        </div>

        <div class="contact-content-body">
            <div class="d-flex align-items-center justify-content-between mg-b-25">
                <h5 class="mg-b-0">Prospective Customer Service Executive Details</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm mg-b-0">
                    <tbody>
                        @foreach ($user['form_data'] as $data => $filled)
                        <tr>
                            <td class="tx-medium"> {{ Str::title(Str::of($data)->replace('_', ' ',)->replace('cse', ' ')) }} </td>
                            <td class="tx-color-03"> {{ Str::title($filled) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-md-block">
                <a href="{{asset($user['form_data']['cv'])}}" download class="btn btn-success mt-3"><i class="fas fa-download"> </i> Download CV </a>
            </div>
        </div>
    </div>
</div>
<x-cse.decision/>
@endsection