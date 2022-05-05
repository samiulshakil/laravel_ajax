<div id="myModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="storeForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="update_id" id="update_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <span class="text-danger">All (*) mark fields are required.</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <x-textbox labelName="Name" name="name" required="required" col="col-md-12" placeholder="Enter name"/>
                            <x-textbox type="email" labelName="Email" name="email" required="required" col="col-md-12" placeholder="Enter email"/>
                            <x-textbox type="password" labelName="Password" name="password" required="required" col="col-md-12" placeholder="Enter password"/>
                            <x-textbox type="password" labelName="Confirm Password" name="password_confirmation" required="required" col="col-md-12" placeholder="Enter password again"/>
                            <div class="form-group col-md-12">
                                <label for="district_id" class="card-title">Select District</label>
                                <select onchange="upazilaList(this.value,'storeForm')" class="form-control col-md-12" id="district_id" name="district_id" required="required">
                                    <option value="">Select Please</option>
                                    @foreach ($districts as $district)
                                        <option value="{{$district->id}}">{{$district->location_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <x-selectbox  labelName="Upazila" name="upazila_id" required="required" col="col-md-12"/>
                            <x-textarea labelName="Address" name="address" required="required" col="col-md-12" placeholder="Enter address"/>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group col-md-12">
                                <label for="avatar">Select Avatar</label>
                                <input type="file" class="dropify" name="avatar" id="avatar" data-show-errors="true" data-errors-position="outside"
                                data-allowed-file-extensions="jpg jpeg png svg webp gif">
                                <input type="hidden" name="old_avatar" id="old_avatar">
                            </div>
                            <x-selectbox  labelName="Role" name="role_id" required="required" col="col-md-12">
                                <option value="">Select Please</option>   
                                @foreach ($roles as $role)
                                        <option value="{{$role->id}}">{{$role->role_name}}</option>
                                    @endforeach
                            </x-selectbox>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="saveBtn" class="btn btn-primary"></button>
                </div>
            </form>
        </div>
    </div>
</div>