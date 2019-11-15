<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;

use App\Users;
use App\Posts;
use App\roles;
use App\Messages;

use DB;

class apiController extends Controller
{
    //
    public function index(){
        return view('login');
    }

    public function login(Request $request){

        $validateData = $request->validate([

            'username' => 'required|string',
            'password' => 'required|string'

        ]);

        Auth::attempt([
            'username' => $request->username,
            'password' => $request->password
        ]);

        if(Auth::check()){
            $query = Users::where('username', $request->username)->get();
            if($query[0]->is_validated == 1){
                return redirect()->intended('main');
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }

    // register account
    public function registerAccount(Request $request){

        $validateData = Validator::make($request->all(), [
            'fullname' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'mobilenumber' => 'required|numeric',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string'
        ]);
        
        if($validateData->fails()){
            return response()->json([
                'success' => false,
                'message' => "There's an error. Please check if fields are correctly filled out"
            ]);
        }else{
            $query = Users::registerUser($request);
            $sendEmail = Users::sendEmail($query);
            if($query){
                return response()->json([
                    'success' => true,
                    'message' => "Registration Successful",
                    'data' => $query
                ]);
            }
        }

    }

    // verify account
    public function verifyUser(Request $request){
        $query = Users::verifyAccount($request);
        if($query == "true"){
            return response()->json([
                'success' => true,
                'message' => "Verification Success"
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => "Verification Code Is not correct!"
            ]);
        }
    }

    // get count
    public function getHeadCount(){
        return $query = Users::getHeadCount();
    }

    public function getHeadCountNonVerified(){
        return $query = Users::getHeadCountNonVerified();
    }

    public function pendingRequestCount(){
        return $query = Posts::where('is_posted', 0)->get()->count();
    }

    public function postedRequestCount(){
        return $query = Posts::where('is_posted', 1)->get()->count();
    }

    public function getPendingRequests(){
        $query = Posts::getPendingRequests();
        return response()->json([
            "data" => $query
        ]);
    }

    public function sendAnnouncement(Request $request){
        return $query = Posts::sendAnnouncement($request);
        if($query == "true"){
            return response()->json([
                'success' => true,
                'message' => "Emails sent successfully"
            ]);
        }
    }

    public function registerdUserNotVerified(){
        $query = Users::registerdUserNotVerified();
        if($query){
            return response()->json([
                "data" => $query
            ]);
        }
    }

    public function validateUser(Request $request){
        $query = Users::validateUser($request);
    }

    public function registeredCountGet(){
        $query = Users::registeredCountGet();
        if($query){
            return response()->json([
                'data' => $query
            ]);
        }
    }

    public function editUser(Request $request){
        $roles = roles::get();
        $query = Users::where('id', $request->id)->get();
        if($query){
            return response()->json([
                'success' => true,
                'query' => $query,
                'roles' => $roles
            ]);
        }else{
            return response()->json([
                'success' => false,
                'query' => array(),
                'roles' => array()
            ]);
        }
    }

    public function saveEditedUser(Request $request){
        $query = Users::where('id', $request->id)
        ->update([
            'number' => $request->mobilenumber,
            'email' => $request->email,
            'roles_id' => $request->roles
        ]);
        if($query){
            return response()->json([
                'success' => true,
                'message' => "Editing Successful"
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => "There's an error"
            ]);
        }
    }

    public function requestNotification(Request $request){
        $query = Posts::requestNotification($request);
        if($query){
            return response()->json([
                'success' => true,
                'message' => "Waiting for admin approval"
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => "There's an error!"
            ]);
        }
    }

    public function tableStudents(){
        $query = Posts::tableStudents();
        if($query){
            return response()->json([
                'data' => $query
            ]);
        }else{
            return response()->json([
                'data' => array()
            ]);
        }
    }

    public function sendNotification(Request $request){
        $query = Posts::sendNotification($request);
        if($query == "true"){
            return response()->json([
                'message' => "Sending Notification Successful",
                'success' => true
            ]);
        }else{
            return response()->json([
                'message' => "There's an error",
                'success' => false
            ]);
        }
    }

    public function openFeedBack(Request $request){
        $query = Posts::openFeedBack($request);
        if($query){
            return response()->json([
                'data' => $query,
                'success' => true
            ]);
        }else{
            return response()->json([
                'data' => array(),
                'success' => false
            ]);
        }
    }

    public function saveFeedBack(Request $request){
        $query = Posts::saveFeedBack($request);
        if($query){
            return response()->json([
                'data' => $query,
                'success' => true,
                'message' => 'Posting your feedback successful!'
            ]);
        }else{
            return response()->json([
                'data' => array(),
                'success' => false,
                'message' => "There's an error"
            ]);
        }
    }

    public function tableFeedback(){
        $query = Posts::tableFeedback();
        if($query){
            return response()->json([
                'data' => $query
            ]);
        }else{
            return response()->json([
                'data' => array()
            ]);
        }
    }

    public function sendMessagePTP(Request $request){
        $query =  Messages::createMessage($request);
        if($query){
            return response()->json([
                'success' => true,
                'message' => "Sending Message Successful"
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => "There's an error!"
            ]);
        }
    }

    public function loadMyMessages(){
        $query = Messages::loadMyMessages();

        $content = "";

        foreach($query as $out){
            $content .= "
                <div class='card' style='border:1px solid black;' id='cardClick'>
                    <div class='card-body'>
                    <input type='hidden' id='toId' value='".$out->toId."'/>
                    For: $out->for
                    </div>
                </div>
            ";
        }

        return response()->json([

            'content' => $content,
            'success' => true

        ]);

    }

    public function openMessages(Request $request){
        $query = Messages::openMessages($request);

        $contents = "";

        foreach($query as $out){
            $contents .= "
                <label>Sent By: $out->from</label><br/>
                <label>For: $out->to</label><br/>
                <h3>Message: $out->message</h3><br/>
                <small>Date Sent: $out->datetime</small>
                <hr style='border: 1px solid black;'/>
            ";
        }

        return response()->json([

            'success' => true,
            'contents' => $contents

        ]);

    }

    public function loadMessageForMe(){
        $query = Messages::loadMessageForMe();

        $contents = "";

        foreach($query as $out){
            $contents .= "
                <div class='card' style='border:1px solid black;' id='cardClickFor'>
                    <div class='card-body'>
                    <input type='hidden' id='fromId' value='".$out->fromId."'/>
                    From: $out->from
                    </div>
                </div>
            ";
        }

        return response()->json([
            'success' => true,
            'content' => $contents
        ]);
    }

    public function openMessagesForMe(Request $request){
        $query = Messages::openMessagesForMe($request);

        $contents = "";

        foreach($query as $out){
            $contents .= "
                <label>Sent By: $out->from</label><br/>
                <label>For: $out->to</label><br/>
                <h3>Message: $out->message</h3><br/>
                <small>Date Sent: $out->datetime</small>
                <hr style='border: 1px solid black;'/>
            ";
        }

        return response()->json([

            'success' => true,
            'contents' => $contents

        ]);

    }

    function tableUsersAllStudentGet(){
        $query = Users::get();

        if($query){
            return response()->json([
                'data' => $query
            ]);
        }else{
            return response()->json([
                'data' => array()
            ]);
        }
    }

    function sendMessageMain(Request $request){
        $query = Messages::createMessage($request);
        if($query){
            return response()->json([
                'success' => true,
                'message' => "Successfully sent message"
            ]);
        }else{
            return response()->json([

                'success' => false,
                'message' => "There's an error sending your message!"

            ]);
        }
    }

    function tableStudentsForGradesF(){
        $query = Users::get();

        if($query){
            return response()->json([
                'data' => $query
            ]);
        }else{
            return response()->json([
                'data' => array()
            ]);
        }
    }

    function sendGrade(Request $request){
        $query = DB::connection('mysql')
        ->table('grades')
        ->insert([
            'grade' => $request->sendGradeText,
            'grade_for' => $request->userIdGrade,
            'graded_by' => $request->fromId,
            'created_at' => DB::raw("NOW()")
        ]);
        if($query){
            return response()->json([
                'success' => true,
                'message' => "Sending Grade Successful"
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => "There's an error send"
            ]);
        }
    }

    function getMyGrades(){
        $query = DB::connection('mysql')
        ->table('grades as a')
        ->select(
            'b.fullname as gradedBy',
            'a.grade as grade'
        )
        ->join('users as b', 'a.graded_by', '=', 'b.id')
        ->where('a.grade_for', '=', Auth::User()->id)
        ->get();

        return response()->json([
            'data' => $query,
        ]);

    }

}
