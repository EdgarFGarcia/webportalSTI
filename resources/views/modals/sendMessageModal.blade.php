<!-- The Modal -->
<div class="modal fade" id="sendMessageModal">
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
                    <div class="col-md-12 mb-sm-0">
                        <label>Send Message</label>
                        <textarea class="form-control" id="sendMessageMain"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="sendMessageMainBtn">Send Message</button>

            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
</div>