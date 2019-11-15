<!-- The Modal -->
<div class="modal fade" id="editUserModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Registered User Verified</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <div class="col-md-12">
                <input type="hidden" id="userId"/>
                <input type="hidden" id="fromId" value="{{ Auth::User()->id }}"/>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="email">Email</label>
                        <input type="text" class="form-control form-contol-user" id="email">
                    </div>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="mobilenumber">Mobile Number</label>
                        <input type="number" class="form-control form-contol-user" id="mobilenumber">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 mb-sm-0">
                        <label for="roles">Roles</label>
                        <select name="roles" id="roles" class="form-control"></select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12 mb-sm-0">
                        <label>Send Message</label>
                        <textarea class="form-control" id="sendMessage"></textarea>
                    </div>
                    <div class="col-md-12 row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4" class="float-right">
                            <button type="button" class="btn btn-primary" id="sendMessageBtn">Send Message</button>
                            <button type="button" class="btn btn-primary" id="clearMessageBtn">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="saveEditUser">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
</div>