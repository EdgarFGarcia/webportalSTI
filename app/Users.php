<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Mail;

use DB;

class Users extends Model
{
    //
    protected $table = 'users';
    protected $fillable = [
        'fullname', 'number', 'email', 'username', 'password', 'roles_id', 'is_validated', "created_at", "updated_at"
    ];

    public static function registerUser($data){
        $newPassword = bcrypt($data->password);
        return Users::insertGetId([
            'fullname' => $data->fullname,
            'number' => $data->mobilenumber,
            'email' => $data->email,
            'username' => $data->username,
            'password' => $newPassword,
            'roles_id' => 3,
            'validation_code' => $data->verificationcode
        ]);
    }

    public static function sendEmail($userId){
        $query = Users::where('id', $userId)->get();

        $emailTo = $query[0]->email;
        $name = $query[0]->fullname;
        $verification_code = $query[0]->validation_code;

        $data = [
            "name" => $name,
            "verification_code" => $verification_code
        ];

        Mail::send('sendverification', $data, function($message) use ($name, $emailTo) {
            $message->to($emailTo, $name)->subject("Verify Your Account");
            $message->from("rhianjane16@gmail.com", "Welcome To Web Portal");
        });

    }

    public static function verifyAccount($data){
        $query = Users::where('id', $data->userId)
        ->where('validation_code', $data->verification_input)
        ->get();

        if(count($query) > 0){
            $updateUser = Users::where('id', $data->userId)
            ->update([
                'is_validated' => 1,
                'updated_at' => DB::raw("NOW()")
            ]);
            return "true";
        }else{
            return "false";
        }

    }

    public static function getHeadCount(){
        return Users::where('is_validated', 1)->get()->count();
    }

    public static function getHeadCountNonVerified(){
        return Users::where('is_validated', 0)->get()->count();
    }

    public static function registerdUserNotVerified(){
        return $query = DB::connection("mysql")
        ->table("users as a")
        ->select(
            'a.fullname as fullname',
            'a.email as email',
            'a.username as username',
            'b.name as role',
            'a.id as userId'
        )
        ->join('roles as b', 'a.roles_id', '=', 'b.id')
        ->where('a.is_validated', 0)
        ->get();
    }

    public static function validateUser($data){
        return $query = DB::connection('mysql')
        ->table('users')
        ->where('id', $data->id)
        ->update([
            'is_validated' => 1
        ]);
    }

    public static function registeredCountGet(){
        return $query = DB::connection('mysql')
        ->table('users as a')
        ->select(
            'a.fullname as fullname',
            'a.email as email',
            'b.name as role',
            'a.username as username',
            'a.id as userId'
        )
        ->join('roles as b', 'a.roles_id', '=', 'b.id')
        ->where('a.is_validated', 1)
        ->get();
    }
}
