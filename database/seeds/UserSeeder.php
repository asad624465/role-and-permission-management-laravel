<?php

use Illuminate\Database\Seeder;
use App\User;
class UserSeeder extends Seeder
{
    public function run()
    {
        $user = User::where("email","az.asifislam@gmail.com")->first();
        if(is_null($user)){
	        User::create([
	        	"name"=>"Asif islam",
	        	"email"=>"az.asifislam@gmail.com",
	        	"password"=>bcrypt("123456")
	        ]);
        }
    }
}
