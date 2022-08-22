<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Code;
use App\Models\Block;
use App\Models\Data;

class BlockchainController extends Controller{
	
    public function index(Request $request){

    	//return $request;

        /*
        Genesis Block   

        89eb0ac031a63d2421cd05a2fbe41f3ea35f5c3712ca839cbf6b85c4ee07b7a3

        The quick brown fox jumps over the lazy dog

        d7a8fbb307d7809469ca9abcb0082e4f8d5651e46d3cdb762d02d0bf37c9e592

        JNDPT4G2iJoZsPJlQgAyAXBbgOSUAuZ7k/I7id4xsu4mwhLsOiui3FNwvN7Tp9Qp

        */

    	$hash = Code::latest()->first();

    	$previous_hash = $hash->code; // 89eb0ac031a63d2421cd05a2fbe41f3ea35f5c3712ca839cbf6b85c4ee07b7a3

		$data = Data::latest()->first();

		$data_hash = $data->code; // JNDPT4G2iJoZsPJlQgAyAXBbgOSUAuZ7k/I7id4xsu4mwhLsOiui3FNwvN7Tp9Qp

    	$enc_data_hash = hash('sha256', $data_hash); // afce352472c6d1c33aa078c04a2550cea29a3a979bf101068cbaacf4a769cbdc
    	
    	$json_arr = array('name' => $request->name, 'mobile' => $request->mobile, 'email' => $request->email);     

	    $new_data = json_encode($json_arr); 

        echo "Previous Hash:&nbsp;&nbsp;&nbsp;&nbsp;".$previous_hash;       

        echo "<br/ >";  

        echo "<br/ >";

        echo "Data Hash:&nbsp;&nbsp;&nbsp;&nbsp;".$data_hash;

        echo "<br/ >";  

        echo "<br/ >";

        echo "Encrypt Data Hash:&nbsp;&nbsp;&nbsp;&nbsp;".$enc_data_hash;

        echo "<br/ >";  

        echo "<br/ >";

        echo "New Data Block:&nbsp;&nbsp;&nbsp;&nbsp;".$new_data;        

    	$aes256 = "AES-256-CBC";

		$iv = substr(hash('sha256', $enc_data_hash), 0, 16);

		$new_data_enc = openssl_encrypt($new_data, $aes256, $previous_hash, 0, $iv); 

        echo "<br/ >";  

        echo "<br/ >";

        echo "New Data Encrypt:&nbsp;&nbsp;&nbsp;&nbsp;".$new_data_enc;            	

        $decrypt = openssl_decrypt($new_data_enc, $aes256, $previous_hash, 0, $iv);    

        $arr = json_decode($decrypt);

        echo "<br/ >";  

        echo "<br/ >";

        echo "New Data Decrypt:&nbsp;&nbsp;&nbsp;&nbsp;".$decrypt;    

        $name = $arr->name;

        $mobile = $arr->mobile;   

        $email = $arr->email;

        echo "<br/ >";  

        echo "<br/ >";

        echo "Name:&nbsp;&nbsp;&nbsp;&nbsp;".$name;

        echo "<br/ >";  

        echo "<br/ >";

        echo "Mobile:&nbsp;&nbsp;&nbsp;&nbsp;".$mobile; 

        echo "<br/ >";  

        echo "<br/ >";

        echo "Email:&nbsp;&nbsp;&nbsp;&nbsp;".$email;                                         
                                                
        $new_hash = hash('sha256', $previous_hash);

        $new_data_enc_hash = hash('sha256', $new_data_enc);

        echo "<br/ >";  

        echo "<br/ >";

        echo "New Hash:&nbsp;&nbsp;&nbsp;&nbsp;".$new_hash;   

        echo "<br/ >";  

        echo "<br/ >";

        echo "New Data Encrypt Hash:&nbsp;&nbsp;&nbsp;&nbsp;".$new_data_enc_hash;                                               
                                                    

        /*$insertcode = new Code;
        $insertcode->code = $new_hash;
        $insertcode->save();

        $insertdata = new Data;
        $insertdata->code = $new_block;
        $insertdata->save();*/


        /*$insertblock = new Block;
        $insertblock->code = $encrypt;
        $insertblock->save(); */      

        return view('result', compact('previous_hash','data_hash', 'enc_data_hash', 'new_data', 'new_data_enc', 'name', 'mobile', 'email', 'new_hash', 'new_data_enc_hash')); 
    }     
	
}
