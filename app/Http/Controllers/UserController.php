<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
class UserController extends Controller
{
    public function create(Request $request)
    {
		if ($request->isMethod('post')) {
	    	$post = $request->all();
	    	if(!isset($post['Account'])){$post['Account']='';}
	    	if(!isset($post['Password'])){$post['Password']='';}
	    	$validator = Validator::make(
			    [
			    	'Account' => $post['Account'],
			    	'Password' => $post['Password'],
			    ],
			    [
			    	'Account' => 'required|max:50|unique:users',
			    	'Password' => 'required|max:50',
			    ]
			);
			if ($validator->fails())
			{
		        $data = array(
		        	"Code" => 2,
		        	"Message" => $validator->errors(),
		        	"Result" => array("IsOK"=>false)
		        );
			}
			else if($validator->passes())
			{
				DB::insert('insert into users (Account, Password) values (?, ?)', array($post['Account'], $post['Password']));
		        $data = array(
		        	"Code" => 0,
		        	"Message" => "",
		        	"Result" => array("IsOK"=>true)
		        );
			}
		}
		else
		{
	        $data = array(
	        	"Code" => 2,
	        	"Message" => "MethodNotAllowed",
	        	"Result" => array("IsOK"=>false)
	        );
		}
        return response()->json($data);
    }
    public function delete(Request $request)
    {
    	if($request->isMethod('post'))
    	{
	    	$post = $request->all();
	    	if(!isset($post['Account'])){$post['Account']='';}
	    	$validator = Validator::make(
			    [
			    	'Account' => $post['Account'],
			    ],
			    [
			    	'Account' => 'required|max:50',
			    ]
			);
			if ($validator->fails())
			{
		        $data = array(
		        	"Code" => 2,
		        	"Message" => $validator->errors(),
		        	"Result" => array("IsOK"=>false)
		        );
			}
			else if($validator->passes())
			{
				$r = DB::table('users')->where('Account', $post['Account'])->delete();
				if($r == 0)
				{
			        $data = array(
			        	"Code" => 2,
			        	"Message" => "User Not Exist!",
			        	"Result" => array("IsOK"=>false)
			        );
				}
				else
				{
			        $data = array(
			        	"Code" => 0,
			        	"Message" => "",
			        	"Result" => array("IsOK"=>true)
			        );
				}
			}
    	}
    	else
    	{
	        $data = array(
	        	"Code" => 2,
	        	"Message" => "MethodNotAllowed",
	        	"Result" => array("IsOK"=>false)
	        );
    	}
        return response()->json($data);
    }
    public function change(Request $request)
    {
		if ($request->isMethod('post')) {
	    	$post = $request->all();
	    	if(!isset($post['Account'])){$post['Account']='';}
	    	if(!isset($post['Password'])){$post['Password']='';}
	    	$validator = Validator::make(
			    [
			    	'Account' => $post['Account'],
			    	'Password' => $post['Password'],
			    ],
			    [
			    	'Account' => 'required|max:50',
			    	'Password' => 'required|max:50',
			    ]
			);
			if ($validator->fails())
			{
		        $data = array(
		        	"Code" => 2,
		        	"Message" => $validator->errors(),
		        	"Result" => array("IsOK"=>false)
		        );
			}
			else if($validator->passes())
			{
				$r = DB::update('update users set Password = ? where Account = ?', array($post['Password'], $post['Account']));
				if($r == 0)
				{
			        $data = array(
			        	"Code" => 2,
			        	"Message" => "User Not Exist!",
			        	"Result" => array("IsOK"=>false)
			        );
				}
				else
				{
			        $data = array(
			        	"Code" => 0,
			        	"Message" => "",
			        	"Result" => array("IsOK"=>true)
			        );
				}
			}
		}
		else
		{
	        $data = array(
	        	"Code" => 2,
	        	"Message" => "MethodNotAllowed",
	        	"Result" => array("IsOK"=>false)
	        );
		}
        return response()->json($data);
    }
    public function login(Request $request)
    {
		if ($request->isMethod('get')) {
	        $status = 200;
	    	$get = $request->all();
	    	if(!isset($get['Account'])){$get['Account']='';}
	    	if(!isset($get['Password'])){$get['Password']='';}
	    	$validator = Validator::make(
			    [
			    	'Account' => $get['Account'],
			    	'Password' => $get['Password'],
			    ],
			    [
			    	'Account' => 'required|max:50',
			    	'Password' => 'required|max:50',
			    ]
			);
			if ($validator->fails())
			{
		        $data = array(
		        	"Code" => 2,
		        	"Message" => $validator->errors(),
		        	"Result" => null
		        );
			}
			else if($validator->passes())
			{
				$r = DB::select('select * from users where Account = ?', array($get['Account']));
				if($r === 0)
				{
			        $data = array(
			        	"Code" => 2,
			        	"Message" => "Login Failed",
			        	"Result" => null
			        );
				}
				else
				{
					if($get['Password'] != $r[0]->Password)
					{
						$status = 400;
				        $data = array(
				        	"Code" => 2,
				        	"Message" => "Login Failed",
				        	"Result" => null
				        );
					}
					else
					{
				        $data = array(
				        	"Code" => 0,
				        	"Message" => "",
				        	"Result" => null
				        );
					}
				}
			}
		}
		else
		{
	        $status = 403;
	        $data = array(
	        	"Code" => 2,
	        	"Message" => "MethodNotAllowed",
	        	"Result" => null
	        );
		}
        return response()->json($data,$status);
    }
}
