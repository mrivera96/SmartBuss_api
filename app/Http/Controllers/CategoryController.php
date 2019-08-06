<?php

namespace SmartBuss\Http\Controllers;

use Illuminate\Http\Request;
use SmartBuss\Category;

class CategoryController extends Controller
{
    public function create(Request $request){
        if(!$this->validate($request,
            ['name'=>'string|required',
                'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'])){
            return response()->json('Error al validar los parámetros de consulta. Asegúrese de enviar los parámetros correctamente e intente de nuevo.', 400);
        }else{
            $newCat=new Category();
            $exists=$newCat->where('name','=',$request->name)->get();
            if(count($exists)>0){
                return response()->json('Esta categoría ya existe.', 400);
            }else{
                $newCat->name=$request->name;
                $imageName = time().'.'.request()->image->getClientOriginalExtension();
                request()->image->move(public_path('images'), $imageName);
                $newCat->image = $imageName;

                if($newCat->save()){
                    return response()->json('Categiría creada correctamente', 200);
                }else{
                    return response()->json('Ha ocurrido un error al crear la categoría. Intente de nuevo', 500);
                }
            }

        }
    }

    public function read(){
        $cats=Category::all();
        if($cats){
            return response()->json($cats, 200);
        }else{
            return response()->json('Error al cargar las categorías.', 500);
        }
    }

    public function update(Request $request){
        if(!$this->validate($request,
            ['name'=>'string|required',
                'id'=>'integer|required',
                'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'])){
            return response()->json('Error al validar los parámetros de consulta. Asegúrese de enviar los parámetros correctamente e intente de nuevo.', 400);
        }else{
            $upCat=Category::find($request->id);
            $currname=Category::where('id',$request->id)->get('name')->first();
            if($request->name==$currname){

            }else{
                if(!$this->validateParams($request, ['name'     =>  'unique:categories']))
                    return response()->json('La categoría que intenta ingresar ya existe.', 400);
            }

            $upCat->name=$request->name;
            $imageName = time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('images'), $imageName);
            $upCat->image = $imageName;

            if($upCat->save()){
                return response()->json('Categiría actualizada correctamente', 200);
            }else{
                return response()->json('Ha ocurrido un error al actualizar la categoría. Intente de nuevo', 500);
            }

        }
    }

    public function delete(){

    }


}
