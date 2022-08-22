<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OpenSSLController extends Controller{

    public function index(){

    }



    public function sha256($input){

    	$encrypt = hash('sha256', $input);

    	return $encrypt;

    }

}
