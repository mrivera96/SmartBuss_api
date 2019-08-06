<?php

namespace SmartBuss\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use SmartBuss\User;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{

    public function create(Request $request){
        $newUSer = new User();
        $validate = ['name'     =>  'string|required',
                    'email'     =>  'string|required',
                    'password'  =>  'string|required',
                    'image'     =>  'nullable|image',
                    'active'    =>  'boolean|required',
                    'role'      =>  'integer|required'];

       if(!$this->validateParams($request, $validate)){
           return response()->json('Error al validar los parámetros de consulta. Asegúrese de enviar los parámetros correctamente e intente de nuevo.', 400);
       }else{

           if(!$this->validateParams($request, ['email'     =>  'unique:users']))
               return response()->json('El usuario que intenta crear ya existe.', 400);

           if(!$this->validateParams($request, ['password'  =>  'min:8']))
               return response()->json('La contraseña debe tener una longitud mínima de 8 caracteres.', 400);

           $newUSer->name=$request->name;
           $newUSer->email=$request->email;
           $newUSer->password=Crypt::encrypt($request->password);
            if( $request->has('image') && !empty($request->image)){
               if(!$this->validate($request,['image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048'])){
                   return response()->json('La imagen debe pesar por máximo 2 MB y ser de formato jpeg, png, jpg, gif o svg.', 400);
               }else{
                   $imageName = time().'.'.request()->image->getClientOriginalExtension();
                   request()->image->move(public_path('images'), $imageName);
                   $newUSer->image = $imageName;
               }
           }

           $newUSer->active=$request->active;
           $newUSer->role=$request->role;

           if($newUSer->save()){
               return response()->json('Usuario creado correctamente', 200);
           }else{
               return response()->json('Ha ocurrido un error al crear el usuario. Intente de nuevo', 500);
           }
       }
    }

    public function readAll(){
        $users=User::all();
        if($users){
            return response()->json($users, 200);
        }else{
            return response()->json('Error al cargar los usuarios', 500);
        }

    }

    public function readById(Request $request){
        $id = $request->id;
        $user=User::find($id);
        if($user){
            return response()->json($user, 200);
        }else{
            return response()->json('Error al cargar datos del usuario', 500);
        }

    }

    public function update(Request $request){

        $validate = [
            'id'        =>  'integer|required',
            'name'     =>  'string|required',
            'email'     =>  'string|required',
            'image'     =>  'nullable|image',
            'active'    =>  'boolean|required',
            'role'      =>  'integer|required'];

        if(!$this->validateParams($request, $validate)){
            return response()->json('Error al validar los parámetros de consulta. Asegúrese de enviar los parámetros correctamente e intente de nuevo.', 400);
        }else{
            $id=$request->id;
            $upUSer = User::find($id);
            $currmail = User::where('id','=',$id)->get('email')->first();

            if($request->email == $currmail->email){

            }else{
                if(!$this->validateParams($request, ['email'     =>  'unique:users']))
                    return response()->json('El email que intenta ingresar ya existe.', 400);
            }



            $upUSer->name=$request->name;
            $upUSer->email=$request->email;
            $upUSer->password=Crypt::encrypt($request->password);

            if( $request->has('image') && !empty($request->image)){
                if(!$this->validate($request,['image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048'])){
                    return response()->json('La imagen debe pesar por máximo 2 MB y ser de formato jpeg, png, jpg, gif o svg.', 400);
                }else{
                    $imageName = time().'.'.request()->image->getClientOriginalExtension();
                    request()->image->move(public_path('images'), $imageName);
                    $upUSer->image = $imageName;
                }
            }

            $upUSer->active=$request->active;
            $upUSer->role=$request->role;

            if($upUSer->save()){
                return response()->json('Usuario actualizado correctamente', 200);
            }else{
                return response()->json('Ha ocurrido un error al actualizar el usuario. Intente de nuevo', 500);
            }
        }
    }

    public function delete(Request $request){
        if(!$this->validateParams($request, ['id'=>'integer|required'])){
            return response()->json('Error al validar los parámetros de consulta. Asegúrese de enviar los parámetros correctamente e intente de nuevo.', 400);
        }else {
            $id = $request->id;
            $delUSer = User::find($id);
            if($delUSer->delete()){
                return response()->json('Usuario eliminado correctamente', 200);
            }else{
                return response()->json('Ha ocurrido un error al eliminar el usuario. Intente de nuevo', 500);
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
