<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserActivityLog;
use Auth;

class UserActivityLogController extends Controller
{
    public function index() {
    	return UserActivityLog::where('user_activity_logs.user_id', Auth::id())
    		->join('users', 'users.id', '=', 'user_activity_logs.user_id')
    		->select('users.name',
    			'user_activity_logs.user_id',
    			'user_activity_logs.message',
    			'user_activity_logs.invoice_id',
    			'user_activity_logs.created_at'
    		)
    		->limit(100)
    		->orderBy('user_activity_logs.created_at', 'desc')
    		->get()
    		->each(function ($result) {
    			$result->created_at = $result->created_at->format('Y-m-d H:i:s');
    		})
    		->toArray();
    }
}
