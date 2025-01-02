{{ dump($user ) }}
<table class="table table-striped table-hover">
    <tr>
        <th>{{ trans('labels.backend.access.users.tabs.content.overview.avatar') }}</th>
        <td><img src="{{ $user->picture }}" class="user-profile-image image-respinsive" style="max-width: 200px;" /></td>
    </tr>
    <tr>  
        <th>{{ trans('labels.backend.access.users.tabs.content.overview.name') }}</th>
        <td>{{ getFullName($user) }}</td>
    </tr>

    <tr>
        <th>{{ trans('labels.backend.access.users.tabs.content.overview.email') }}</th>
        <td>{{ $user->email }}</td>
    </tr>

    <tr>
        <th>{{ trans('labels.backend.access.users.tabs.content.overview.status') }}</th>
        <td>{!! $user->status_label !!}</td>
    </tr>

    <tr>
        <th>{{ trans('labels.backend.access.users.tabs.content.overview.confirmed') }}</th>
        <td>{!! $user->confirmed_label !!}</td>
    </tr>

    <tr>
        <th>{{ trans('labels.backend.access.users.tabs.content.overview.created_at') }}</th>
        <td>{{ $user->created_at }} ({{ $user->created_at->diffForHumans() }})</td>
    </tr>

    <tr>
        <th>{{ trans('labels.backend.access.users.tabs.content.overview.last_updated') }}</th>
        <td>{{ $user->updated_at }} ({{ $user->updated_at->diffForHumans() }})</td>
    </tr>

    <tr>
        <th>Phone No</th>
        <td>{{ $user->phone_no??"NA" }}</td>
    </tr>

    <tr>
        <th>Address</th>
        <td>{{ $user->user_profile->address??"NA" }}</td>
    </tr>

    <tr>
        <th>City</th>
        <td>{{ $user->city }}</td>
    </tr>

    <tr>
        <th>County</th>
        <td>{{ $user->county }}</td>
    </tr>

    <tr>
        <th>State</th>
        <td>{{ findState($user->state_id)}}</td>
    </tr>

    <tr>
        <th>Zip Code</th>
        <td>{{ $user->zip_code }}</td>
    </tr>

    <tr>
        <th>Interests</th>
        <td>
            <?php
            if (!empty($user->user_profile->user_interests)) {
                foreach ($user->user_profile->user_interests as $interest) {
                    echo config('constant.interests.' . $interest->interest_type) . " ";
                }
            }
            ?>
    </tr>

    <tr>
        <th>Share Profile:</th>
        <td>{{ (isset($user->user_profile->share_profile) &&  $user->user_profile->share_profile) ? config('constant.share_profile.' . $user->user_profile->share_profile) : "NA" }}</td>
    </tr>

    <tr>
        <th>Loan Status</th>
        <td>{{ isset($user->user_profile->loan_status) && $user->user_profile->loan_status ? config('constant.loan_status.' . $user->user_profile->loan_status) : "NA" }}</td>
    </tr>
    <tr>
        <th>Full Name</th>
        <td>{{ ($user->user_profile->first_name ??"") . ($user->user_profile->middle_name??"") . ($user->user_profile->last_name??"") }}<span style="color:#999;"> (to be used in official documents/contracts)</span></td>  
    </tr>
    @if ($user->trashed())
    <tr>
        <th>{{ trans('labels.backend.access.users.tabs.content.overview.deleted_at') }}</th>
        <td>{{ $user->deleted_at }} ({{ $user->deleted_at->diffForHumans() }})</td>
    </tr>
    @endif
</table>