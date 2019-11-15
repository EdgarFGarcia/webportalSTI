<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

use Auth;

class Messages extends Model
{
    //
    protected $table = "messages";

    public static function createMessage($data){
        return Messages::insert([
            'message' => $data->message,
            'from_id' => $data->fromId,
            'to_id' => $data->userId,
            'created_at' => DB::raw("NOW()")
        ]);
    }

    public static function loadMyMessages(){
        return DB::connection('mysql')
        ->table('messages as a')
        ->select(
            'c.fullname as for',
            'a.to_id as toId',
            'a.id'
        )
        ->join('users as b', 'a.from_id', '=', 'b.id')
        ->join('users as c', 'a.to_id', '=', 'c.id')
        ->where('a.from_id', Auth::User()->id)
        ->groupBy('a.to_id')
        ->get();
    }

    public static function openMessages($data){
        return DB::connection('mysql')
        ->table('messages as a')
        ->select(
            'a.message as message',
            DB::raw("DATE_FORMAT(a.created_at, '%m-%d-%Y %h:%i:%s %p') as datetime"),
            'c.fullname as from',
            'b.fullname as to'
        )
        ->join('users as b', 'a.to_id', '=', 'b.id')
        ->join('users as c', 'a.from_id', '=', 'c.id')
        ->where('a.to_id', '=', $data->id)
        ->get();
    }

    public static function loadMessageForMe(){
        return DB::connection('mysql')
        ->table('messages as a')
        ->select(
            'b.fullname as from',
            'a.from_id as fromId',
            'a.id'
        )
        ->join('users as b', 'a.from_id', '=', 'b.id')
        ->join('users as c', 'a.to_id', '=', 'c.id')
        ->where('a.to_id', Auth::User()->id)
        ->groupBy('a.from_id')
        ->get();
        
    }

    public static function openMessagesForMe($data){
        return DB::connection('mysql')
        ->table('messages as a')
        ->select(
            'a.message as message',
            DB::raw("DATE_FORMAT(a.created_at, '%m-%d-%Y %h:%i:%s %p') as datetime"),
            'c.fullname as from',
            'b.fullname as to'
        )
        ->join('users as b', 'a.to_id', '=', 'b.id')
        ->join('users as c', 'a.from_id', '=', 'c.id')
        ->where('a.from_id', '=', $data->id)
        ->where('a.to_id', '=', Auth::User()->id)
        ->get();
    }
}
