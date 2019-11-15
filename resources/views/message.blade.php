@extends('welcome')

@section('content')
    <div class="col-md-12 row">
        <div class="col-md-4" style="border:1px solid gray;">
            <label>Messages Sent</label>
            <div id="messagesBody"></div>
        </div>
        <div class="col-md-8" style="border:1px solid black;">
            <div id="contentBody"></div>
        </div>
    </div>

    <div class="col-md-12 row">
        <div class="col-md-4" style="border:1px solid gray;">
            <label>Messages For Me</label>
            <div id="messagesBodyForMe"></div>
        </div>
        <div class="col-md-8" style="border:1px solid black;">
            <div id="contentBodyForMe"></div>
        </div>
    </div>
    
@endsection

@section('script')
    <script>
        $(document).ready(function(){

            loadMyMessages();
            loadMessageForMe();

            $(document).on('click', '#cardClick', function(){
                var toId = $('#toId').val();
                openMessages(toId);
            });

            $(document).on('click', '#cardClickFor', function(){
                var fromId = $('#fromId').val();
                openMessagesForMe(fromId);
            });

        });

        function loadMyMessages(){
            $.ajax({
                url : "{{ url('api/loadMyMessages') }}",
                method : "GET"
            }).done(function(response){
                if(response.success){
                    $('#messagesBody').append(response.content);
                }
            });
        }

        function openMessages(id){
            $.ajax({
                url : "{{ url('api/openMessages') }}",
                method: "POST",
                data: {
                    id: id
                }
            }).done(function(response){
                if(response.success){
                    $('#contentBody').text('');
                    $('#contentBodyForMe').text('');
                    $('#contentBody').append(response.contents);
                }
            });
        }

        function loadMessageForMe(){
            $.ajax({
                url : "{{ url('api/loadMessageForMe') }}",
                method : "GET"
            }).done(function(response){
                if(response.success){
                    $('#messagesBodyForMe').append(response.content);
                }
            });
        }

        function openMessagesForMe(id){
            $.ajax({
                url : "{{ url('api/openMessagesForMe') }}",
                method : "POST",
                data : {
                    id : id
                }
            }).done(function(response){
                if(response.success){
                    $('#contentBody').text('');
                    $('#contentBodyForMe').text('');
                    $('#contentBodyForMe').append(response.contents);
                }
            });
        }

    </script>
@endsection