<?php

class UserController extends \BaseController {

    public function __construct() {
        $this->beforeFilter("admin");
    }

    public function getTableView() {
        $max = Input::get("max") ? intval(Input::get("max")): 10;
        $offset = Input::get("offset") ? intval(Input::get("offset")) : 0;
        $array = array();
        $query = "";
        $text = "";
        if(Input::get("searchText")) {
            $query = $query."name Like ?";
            $text = trim(Input::get("searchText")) ;
            array_push($array, "%".$text."%");
        }
        $users = null;
        $total = 0;
        if(count($array) > 0 ) {
            $users = Admin::whereRaw($query, $array)->take($max)->skip($offset);
            $total = Admin::whereRaw($query, $array)->count();
        } else {
            $users = Admin::take($max)->skip($offset)->orderBy('id', "ASC");
            $total = Admin::count();
        }
        $users = $users->get();
        return View::make("user.tableView", array(
            'users' => $users,
            'total' => $total,
            'max' => $max,
            'offset' => $offset,
            'searchText' => $text
        ));
    }

    public function getCreate() {
        $user = null;
        if(Input::get("id")) {
            $user = Admin::find(intval(Input::get("id")));
        } else {
            $user = new Admin();
        }
        return View::make("user.create", array('user' => $user));
    }

    public function postSave() {
        $admin = null;
        $inputs = Input::all();
        if($inputs["id"]) {
            $admin = Admin::find(intval($inputs["id"]));
        } else {
            $admin = new Admin();
        }
        $rules = array(
            'name' => 'required',
            'username' => 'required|min:5|unique:users,username'.($admin->user ? ",{$admin->user->id}" : ""),
            'email' => 'required|email|unique:admins,email'.($admin->id ? ",{$admin->id}" : ""),
        );
        if(!$admin->id) {
            $rules['password'] = 'required|min:8';
        }
        $validator = Validator::make($inputs, $rules);
        if($validator->fails()) {
            return array('status' => 'error', 'message' => $validator->messages()->all());
        }
        if(!$admin->id && strcmp($inputs["password"], $inputs["confirm_password"]) != 0) {
            return array('status' => 'error', 'message' => 'Password and confirm password did not match');
        }
        $admin->name = $inputs["name"];
        $admin->email = $inputs["email"];
        DB::transaction(function() use ($admin, $inputs) {
            $hasId = $admin->id != null;
            $admin->save();
            if($admin->user == null) {
                $admin->user = new User();
                $admin->user->userable_type = "Admin";
                $admin->user->is_active = true;
            }
            $admin->user->username = $inputs["username"];
            if(!$hasId) {
                $admin->user->password = Hash::make($inputs["password"]);

            }
            $admin->user->userable_id = $admin->id;
            $admin->user->save();
        });
        return array('status' => 'success', 'message' => "User has been created successfully");
    }
}
