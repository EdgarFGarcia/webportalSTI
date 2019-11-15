@extends('welcome')

@section('content')
    <!-- admin -->
    @if(Auth::User()->roles_id == 1)
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Registered Users (Verified)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="registeredCount"></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4" id="registerdUserNotVerified">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Registered Users (Not Verified)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="registeredCount2"></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4" id="pendingRequestsDiv">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pending Requests</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="pendingCount"></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Posted Announcement</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="postedRequestCount"></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <label for="announcement">Make an announcement</label><br/>
                <textarea id="announcement" class="form-control"></textarea>
                <button type="button" id="sendAnnouncement" class="btn btn-primary float-right">Send</button>
            </div>
            <div class="col-md-12">
                <table class="table table-bordered table-striped" id="tableFeedback">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Announcement</th>
                            <th>Feedback</th>
                            <th>Feedback Created At</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        
        @include('modals.pendingRequestModal')
        @include('modals.userNotVerified')
        @include('modals.registeredCount')
        @include('modals.editUser')
        <!-- faculty -->

    @elseif(Auth::User()->roles_id == 2) 
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard Faculty</h1>
        </div>
        <div class="col-md-12">
            <label for="announcementFaculty">Make an announcement</label><br/>
            <textarea id="announcementFaculty" class="form-control"></textarea>
            <button type="button" id="sendAnnouncementFaculty" class="btn btn-primary float-right">Send</button>
        </div>
        <br/><br/><br/>
        <div class="col-md-12">
            <label>Send Message</label>
            <table class="table table-sm table-condensed table-stripped" id="tableUsersAllStudent">
            <thead>
                    <tr>
                        <th>Fullname</th>
                    </tr>
                </thead>
            </table>
        </div>
        <br/><br/><br/>
        <div class="col-md-12">
            <label>Send Grades To Student</label>
            <table class="table table-sm table-condensed table-stripped" id="tableStudentsForGrades">
            <thead>
                    <tr>
                        <th>Fullname</th>
                    </tr>
                </thead>
            </table>
        </div>
    <!-- student -->
    @elseif(Auth::User()->roles_id == 3)
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard Students</h1>
        </div>
        <br/><br/><br/>
        <div class="col-md-12">
            <label>Send Message</label>
            <table class="table table-sm table-condensed table-striped" id="tableStudents">
                <thead>
                    <tr>
                        <th>Message</th>
                        <th>Posted By</th>
                        <th>My Feedback</th>
                    </tr>
                </thead>
            </table>
        </div>
        <br/><br/><br/>
        <div class="col-md-12">
            <table class="table table-sm table-condensed table-stripped" id="tableUsersAllStudent">
            <thead>
                    <tr>
                        <th>Fullname</th>
                    </tr>
                </thead>
            </table>
        </div>
        <br/><br/><br/>
        <div class="col-md-12">
            <table class="table table-sm table-condensed table-stripped" id="myGrades">
            <thead>
                    <tr>
                        <th>My Grade</th>
                        <th>Graded By</th>
                    </tr>
                </thead>
            </table>
        </div>
        @include('modals.feedbackAnnouncement')
    @endif
@endsection
@include('modals.sendMessageModal')
@include('modals.sendGradeModal')
@section('script')
    <script>

        var registerdUserNotVerifiedTable = $('#registerdUserNotVerifiedTable').DataTable();
        var registeredCountTable = $('#registeredCountTable').DataTable();
        var pendingRequestsTable = $('#pendingRequestsTable').DataTable();
        var tableStudents = $('#tableStudents').DataTable();
        var tableFeedback = $('#tableFeedback').DataTable();
        var tableUsersAllStudent = $('#tableUsersAllStudent').DataTable();
        var tableStudentsForGrades = $('#tableStudentsForGrades').DataTable();
        var myGrades = $('#myGrades').DataTable();
        var postId;
        var userId = {{Auth::User()->id}}

        $(document).ready(function(){
            // start admin
            getRegisteredCount();
            getRegisteredCountNonVerified();
            pendingRequestCount();
            postedRequestCount();
            tableFeedbackGet();
            tableUsersAllStudentGet();
            tableStudentsForGradesGet();
            myGradesGet();

            $(document).on('click', '#pendingRequestsDiv', function(){
                getPendingRequests();
            });

            $(document).on('click', '#sendAnnouncement', function(){
                sendAnnouncement();
            });

            $(document).on('click', '#registerdUserNotVerified', function(){
                registerdUserNotVerified();
            });

            $(document).on('click', '#registeredCount', function(){
                registeredCountTableCallBack();
            });
            
            $('#tableStudentsForGrades tbody').on('click', 'tr', function(){
                var data = tableStudentsForGrades.row(this).data();
                var id = data['id'];
                openSendGradeModal(id);
            });

            $('#tableUsersAllStudent tbody').on('click', 'tr', function(){
                var data = tableUsersAllStudent.row(this).data();
                var id = data['id'];
                openSendMessageModal(id);
            });

            $('#registerdUserNotVerifiedTable tbody').on('click', 'tr', function(){
                var data = registerdUserNotVerifiedTable.row(this).data();
                var id = data['userId'];
                validateUser(id);
            });

            $('#pendingRequestsTable tbody').on('click', 'tr', function(){
                var data = pendingRequestsTable.row(this).data();
                var id = data['id'];
                sendNotification(id);
            });

            $('#registeredCountTable tbody').on('click', 'tr', function(){
                var data = registeredCountTable.row(this).data();
                var id = data['userId'];
                editUser(id);
            });
            

            $(document).on('click', '#saveEditUser', function(){
                saveEditedUser();
            });

            $(document).on('click', '#sendMessageBtn', function(){
                sendMessageFunction();
            })

            // end admin

            // start faculty
            $(document).on('click', '#sendAnnouncementFaculty', function(){
                requestNotification();
            });
            // end faculty

            // start student

            tableStudentsLoad();

            $('#tableStudents').on('click', 'tbody tr', function(){
                var data = tableStudents.row(this).data();
                postId = data["postsId"];
                openFeedBack(postId);
            });

            $(document).on('click', '#saveMyFeedback', function(){
                saveFeedBack(postId);
            });

            $(document).on('click', '#sendMessageMainBtn', function(){
                sendMessageTo();
            });

            $(document).on('click', '#sendGradeBtn', function(){
                sendGrade();
            });

            // end student
        });
        // start admin

        function myGradesGet(){
            myGrades = $('#myGrades').DataTable().destroy();
            myGrades = $('#myGrades').DataTable({
                "ajax": {
                    url : "{{ url('api/getMyGrades') }}",
                    method : "GET"
                },
                "columns": [
                    {"data": "grade"},
                    {"data": "gradedBy"}
                ]
            });
        }

        function tableStudentsForGradesGet(){
            tableStudentsForGrades = $('#tableStudentsForGrades').DataTable().destroy();
            tableStudentsForGrades = $('#tableStudentsForGrades').DataTable({
                "ajax": {
                    url : "{{ url('api/tableStudentsForGradesF') }}",
                    method : "GET"
                },
                "columns": [
                    {"data": "fullname"}
                ]
            });
        }

        function openSendGradeModal(id){
            $('#sendGradeModal').modal('show');
            $('#userIdGrade').val(id);
        }

        function sendGrade(){
            var userIdGrade = $('#userIdGrade').val();
            var fromId = $('#fromId').val();
            var sendGradeText = $('#sendGradeText').val();
            $.ajax({
                url : "{{ url('api/sendGrade') }}",
                method : "POST",
                data : {
                    userIdGrade : userIdGrade,
                    fromId : fromId,
                    sendGradeText : sendGradeText
                }
            }).done(function(response){
                if(response.success){
                    toastr.success(response.message);
                    $('#sendGradeModal').modal('hide');
                }else{
                    toastr.error(response.message);
                }
            });
        }

        function tableUsersAllStudentGet(){
            tableUsersAllStudent = $('#tableUsersAllStudent').DataTable().destroy();
            tableUsersAllStudent = $('#tableUsersAllStudent').DataTable({
                "ajax": {
                    url: "{{ url('api/tableUsersAllStudentGet') }}",
                    method: "GET"
                },
                "columns" : [
                    {"data": "fullname"}
                ]
            });
        }

        function openSendMessageModal(id){
            $('#userId').val(id);
            $('#sendMessageModal').modal("toggle");
        }

        function sendMessageTo(){
            var userId = $('#userId').val();
            var fromId = $('#fromId').val();
            var sendMessageMain = $('#sendMessageMain').val();
            
            $.ajax({
                url : "{{ url('api/sendMessageMain') }}",
                method : "POST",
                data : {
                    userId : userId,
                    fromId : fromId,
                    message : sendMessageMain
                }
            }).done(function(response){
                if(response.success){
                    $('#sendMessageModal').modal("toggle");
                    toastr.success(response.message);
                }else{
                    toastr.error(response.message);
                }
            });

        }

        function tableFeedbackGet(){
            tableFeedback = $('#tableFeedback').DataTable().destroy();
            tableFeedback = $('#tableFeedback').DataTable({
                "ajax": {
                    url: "{{ url('api/tableFeedbackGet') }}",
                    method : "GET"
                },
                "columns": [
                    {"data": "fullname"},
                    {"data": "announcement"},
                    {"data": "feedback"},
                    {"data": "feedback_created"}
                ]
            });
        }

        function getRegisteredCount(){
            $.ajax({
                url : "{{ url('api/getHeadCount') }}",
                method : "GET",
                dataType : "JSON"
            }).done(function(response){
                $('#registeredCount').append(response);
            });
        }
        function getRegisteredCountNonVerified(){
            $.ajax({
                url : "{{ url('api/getHeadCountNonVerified') }}",
                method : "GET",
                dataType : "JSON"
            }).done(function(response){
                $('#registeredCount2').text('');
                $('#registeredCount2').append(response);
            });
        }
        function pendingRequestCount(){
            $.ajax({
                url : "{{ url('api/pendingRequestCount') }}",
                method : "GET",
                dataType : "JSON"
            }).done(function(response){
                $('#pendingCount').append(response);
            });
        }
        function postedRequestCount(){
            $.ajax({
                url : "{{ url('api/postedRequestCount') }}",
                method : "GET",
                dataType : "JSON"
            }).done(function(response){
                $('#postedRequestCount').text('');
                $('#postedRequestCount').append(response);
            });
        }

        function sendAnnouncement(){
            var announcement = $('#announcement').val();
            $.ajax({
                url : "{{ url('api/sendAnnouncement') }}",
                method : "POST",
                dataType : "JSON",
                data : {
                    announcement : announcement
                }
            }).done(function(response){

            });
        }

        function getPendingRequests(){
            $('#pendingRequestModal').modal("show");
            pendingRequestsTable = $('#pendingRequestsTable').DataTable().destroy();
            pendingRequestsTable = $('#pendingRequestsTable').DataTable({
                "ajax": {
                    url: "{{ url('api/getPendingRequests') }}",
                    method : "GET"
                },
                "columns": [
                    {"data": "message"},
                    {"data": "fullname"}
                ]
            });
        }

        function registerdUserNotVerified(){
            $('#registerdUserNotVerifiedModal').modal("show");
            registerdUserNotVerifiedTable = $('#registerdUserNotVerifiedTable').DataTable().destroy();
            registerdUserNotVerifiedTable = $('#registerdUserNotVerifiedTable').DataTable({
                "ajax": {
                    url: "{{ url('api/registerdUserNotVerified') }}",
                    method: "GET"
                },
                "columns" : [
                    {data : "fullname", name: "fullname"},
                    {data : "username", name: "username"},
                    {data : "email", name: "email"},
                    {data : "role", name: "role"}
                ]
            });
        }

        function validateUser(userId){
            $.ajax({
                url : "{{ url('api/validateUser') }}",
                method : "POST",
                data : {
                    id: userId
                }
            }).done(function(response){
                $('#registerdUserNotVerifiedTable').DataTable().ajax.reload();
                getRegisteredCountNonVerified();
            });
        }

        function registeredCountTableCallBack(){
            $('#registeredCountModal').modal("show");
            registeredCountTable = $('#registeredCountTable').DataTable().destroy();
            registeredCountTable = $('#registeredCountTable').DataTable({
                "ajax": {
                    url : "{{ url('api/registeredCountGet') }}",
                    method : "GET"
                },
                "columns": [
                    {data : "fullname", name: "fullname"},
                    {data : "username", name: "username"},
                    {data : "email", name: "email"},
                    {data : "role", name: "role"}
                ]
            });
        }

        function editUser(userId){
            // TODO
            $.ajax({
                url : "{{ url('api/editUser') }}",
                method : "GET",
                dataType : "JSON",
                data : {
                    id : userId
                }
            }).done(function(response){
                if(response.success){
                    console.log(response.query.number);
                    $('#emailEdit').val(response.query.email);
                    $('#mobilenumberEdit').val(response.query.number);
                    $('#userId').val(response.query.id);
                    $('#roles').find('option').remove().end();
                    $.each(response.roles, function(key, value){
                        $('#roles').append($("<option></option")
                                .attr("value", value.id)
                                .text(value.name)
                            );
                    });
                    $('#editUserModal').modal("show");
                }
            });
        }

        function sendMessageFunction(){
            var sendMessage = $('#sendMessage').val();
            var userId = $('#userId').val();
            var fromId = $('#fromId').val();
            $.ajax({
                url : "{{ url('api/sendMessagePTP') }}",
                method : "POST",
                data : {
                    message : sendMessage,
                    userId : userId,
                    fromId : fromId
                }
            }).done(function(response){
                if(response.success){
                    toastr.success(response.message);
                    $('#editUserModal').modal("hide");
                }else{
                    toastr.error(response.message);
                }
            });
        }

        function saveEditedUser(){
            var email = $('#emailEdit').val();
            // var mobilenumber= $('#mobilenumberEdit').val();
            var roles = $('#roles').val();
            var id = $('#userId').val();
            $.ajax({
                url : "{{ url('api/saveEditedUser') }}",
                method : "POST",
                data : {
                    email : email,
                    // mobilenumber : mobilenumber,
                    roles : roles,
                    id : id
                }
            }).done(function(response){
                if(response.success){
                    toastr.success(response.message);
                    $('#editUserModal').modal("hide");
                }else{
                    toastr.error(response.message);
                    $('#editUserModal').modal("hide");
                }
            });
        }

        function sendNotification(id){
            $.ajax({
                url : "{{ url('api/sendNotification') }}",
                method : "POST",
                data : {
                    id : id
                }
            }).done(function(response){
                if(response.success){
                    toastr.success(response.message);
                    $('#pendingRequestsTable').DataTable().ajax.reload();
                    postedRequestCount();
                }else{
                    toastr.error(response.message);
                }
            });
        }

        // end admin
        
        // start faculty
        function requestNotification(){
            var announcementFaculty = $('#announcementFaculty').val();
            $.ajax({
                url : "{{ url('api/requestNotification') }}",
                method : "POST",
                data : {
                    message : announcementFaculty
                }
            }).done(function(response){
                if(response.success){
                    toastr.info(response.message);
                }else{
                    toastr.error(response.message);
                }
            });
        }
        // end faculty

        // start student
        function tableStudentsLoad(){
            tableStudents = $('#tableStudents').DataTable().destroy();
            tableStudents = $('#tableStudents').DataTable({
                "ajax": {
                    url : "{{ url('api/tableStudents') }}",
                    method : "GET"
                },
                "columns": [
                    {data : "message", name: "message"},
                    {data : "postedby", name: "postedby"},
                    {data : "feedback", name: "feedback"},
                ]
            });
        }

        function openFeedBack(postId){
            $('#feedbackAnnouncementM').modal("show");
            $.ajax({
                url : "{{ url('api/openFeedBack') }}",
                method : "POST",
                data : {
                    userId : userId,
                    postId : postId
                }
            }).done(function(response){
                if(response.success){
                    console.log(response.data);
                    $('#announcement').val(response.data[0].message);
                }
            });
        }

        function saveFeedBack(postId){
            // console.log(userId);
            // console.log(postId);
            var myfeedback = $('#myfeedback').val();

            $.ajax({
                url : "{{ url('api/saveFeedBack') }}",
                method : "POST",
                data : {
                    postId : postId,
                    userId : userId,
                    myfeedback : myfeedback
                }
            }).done(function(response){
                if(response.success){
                    toastr.success(response.message);
                    $('#feedbackAnnouncementM').modal("hide");
                    $('#tableStudents').DataTable().ajax.reload();
                }
            });

        }

        // end student
        
    </script>
@endsection