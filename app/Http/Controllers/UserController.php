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
                    'email'     =>  'string|required',
                    'password'  =>  'string|required',
                    'image'     =>  'nullable|string',
                    'active'    =>  'boolean|required',
                    'role'      =>  'integer|required'];

       if(!$this->validateParams($request, $validate)){
           return response()->json('Error al validar los parámetros de consulta. Asegúrese de enviar los parámetros correctamente e intente de nuevo.', 400);
       }else{

           if(!$this->validateParams($request, ['email'     =>  'unique:users']))
               return response()->json('El usuario que intenta crear ya existe.', 400);

           if(!$this->validateParams($request, ['password'  =>  'min:8']))
               return response()->json('La contraseña debe tener una longitud mínima de 8 caracteres.', 400);

           $newUSer->name=$request->input('name');
           $newUSer->email=$request->input('email');
           $newUSer->password=$request->input('password');
            if( $request->has('image') && !empty($request->input('image')))
                $newUSer->image = $request->input('image');

           $newUSer->active=$request->input('active');
           $newUSer->role=$request->input('role');

           if($newUSer->save()){
               return response()->json('Usuario creado correctamente', 200);
           }else{
               return response()->json('Ha ocurrido un error al crear el usuario. Intente de nuevo', 500);
           }
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
