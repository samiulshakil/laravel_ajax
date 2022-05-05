<div class="col-md-12 text-center">
    @if (!empty($data->avatar))
    <img src="{{asset('storage/user_image/'.$data->avatar)}}" alt="{{$data->name}}" style="width:250px;"/>
    @else
    <img src="{{asset('svg/user.svg')}}" alt="Default Image"  style="width:250px;">
    @endif
    
</div>
<div class="col-md-12">
    <table class="table table-borderless">
        <tr>
            <td><b>Name:</b></td>
            <td>{{$data->name}}</td>
        </tr>
        <tr>
            <td><b>Role:</b></td>
            <td>{{$data->role->role_name}}</td>
        </tr>
        <tr>
            <td><b>Email:</b></td>
            <td>{{$data->email}}</td>
        </tr>
        <tr>
            <td><b>Email Verified:</b></td>
            <td>
                @if (!empty($data->email_verified_at))
                    <span class="badge bg-success">Verified</span>
                @else
                    <span class="badge bg-danger">Unverified</span>
                @endif
            </td>
        </tr>
        <tr>
            <td><b>Status:</b></td>
            <td>
                @if ($data->status == 1)
                <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Unactive</span>
                @endif
            </td>
        </tr>
        <tr>
            <td><b>District:</b></td>
            <td>{{$data->district->location_name}}</td>
        </tr>
        <tr>
            <td><b>Upazila:</b></td>
            <td>{{$data->upazila->location_name}}</td>
        </tr>
        <tr>
            <td><b>Address:</b></td>
            <td>{{$data->address}}</td>
        </tr>
    </table>
</div>