<?php

namespace SmartBuss\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use SmartBuss\User;

class UserController extends Controller
{

    public function create(Request $request){
        $newUSer = new User();
        $validate = ['name'     =>  'string|required',
                    'email'     =>  'string|unique:users|required',
                    'password'  =>  'string|required|min:8',
                    'image'     =>  'nullable|string',
                    'active'    =>  'boolean|required',
                    'role'      =>  'integer|required'];

       if(!$this->validateParams($request, $validate)){
           return response()->json('Error al validar los parámetros de consulta. Asegúrese de enviar los parámetros correctamente e intente de nuevo.', 400);
       }else{
           $newUSer->name=$request->input('name');
           $newUSer->email=$request->input('email');
           $newUSer->password=$request->input('password');

           $newUSer->name=$request->input('name');
       }

    }


    private function validateParams($request, $array){
        try{
            $this->validate($request,$array);
            return true;
        }catch (ValidationException $ex){
            return false;
        }
    }
}
