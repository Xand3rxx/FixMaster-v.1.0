<div class="mg-t-10 mg-md-t-0">
    <div class="card">
        <div class="card-header pd-b-0 pd-t-20 bd-b-0">
            <h6 class="tx-uppercase tx-spacing-1 tx-semibold tx-20 tx-color-02 mg-b-15"><strong>Full Name:</strong> @if(!empty($fullName)) {{ $fullName }} @else UNAVAILABLE @endif <small class="form-text text-muted" >(@if(!empty($designation)) {{ $designation }} @else ROLE UNAVAILABLE @endif)<small></h6>

            <h3 class="tx-20 lh-1 tx-normal tx-spacing--2 mg-b-5 mg-r-5">Activity Type: {{ $activityLogDetails->type }}</h3>

        </div><!-- card-header -->

        <div class="card-body pd-y-10">
        <div class="d-flex align-items-baseline tx-rubik">
        </div>

        <div class="progress bg-transparent op-7 ht-10 mg-b-15">
            <div class="progress-bar bg-primary wd-50p" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-bar bg-success wd-25p bd-l bd-white" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-bar bg-warning wd-5p bd-l bd-white" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-bar bg-pink wd-5p bd-l bd-white" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-bar bg-teal wd-10p bd-l bd-white" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-bar bg-purple wd-5p bd-l bd-white" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
        </div>

        <table class="table-dashboard-two">
            <tbody>
            <tr>
                <td>
                    @if($activityLogDetails->severity == 'Informational')
                        <div class="wd-12 ht-12 rounded-circle bd bd-3 bd-success"></div>
                    @elseif($activityLogDetails->severity == 'Warning')
                        <div class="wd-12 ht-12 rounded-circle bd bd-3 bd-warning"></div>
                    @elseif($activityLogDetails->severity == 'Error')
                        <div class="wd-12 ht-12 rounded-circle bd bd-3 bd-danger"></div>
                    @endif
                </td>
                <td class="tx-medium"> Status</td>
                <td class="text-right">{{ $activityLogDetails->severity }}</td>
            </tr>
            <tr>
                <td><div class="wd-12 ht-12 bd-success"></div></td>
                <td class="tx-medium">IP Address</td>
                <td class="text-right">{{ $activityLogDetails->ip_address }}</td>
            </tr>
            <tr>
                <td><div class="wd-12 ht-12 bd-warning"></div></td>
                <td class="tx-medium">Action Path</td>
                <td class="text-right">{{ $activityLogDetails->request_url }}</td>
            </tr>
            <tr>
                <td><div class="wd-12 ht-12 bd-pink"></div></td>
                <td class="tx-medium">Controller Method</td>
                <td class="text-right">{{ $activityLogDetails->action_url }}</td>
            </tr>
            <tr>
                <td><div class="wd-12 ht-12 bd-teal"></div></td>
                <td class="tx-medium">Timestamp</td>
                <td class="text-right">{{ Carbon\Carbon::parse($activityLogDetails->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
            </tr>
            <tr>
                <td><div class="wd-12 ht-12 bd-purple"></div></td>
                <td class="tx-medium">User Agent</td>
                <td class="text-right">{{ $activityLogDetails->user_agent }}</td>
            </tr>
            <tr>
                <td><div class="wd-12 ht-12 bd-purple"></div></td>
                <td class="tx-medium">Message</td>
                <td class="text-right">{{ $activityLogDetails->message }}</td>
            </tr>
            </tbody>
        </table>
        </div><!-- card-body -->
    </div><!-- card -->
</div>