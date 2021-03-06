<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{

    public function __construct(Marca $marca) {
        $this->marca = $marca;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( )
    {
        //$marcas = Marca::all();
        $marcas = $this->marca->all();
        return response()->json($marcas,200);
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        
        $request->validate($this->marca->rules(),$this->marca->feedback());
        //stateless
        $marca = $this->marca->create($request->all());

        return response()->json($marca,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marca = $this->marca->find($id);
        if($marca === null) {
            return response()->json(['erro' => 'recurso pesquisado não existe'],404);
        }
        return response()->json($marca,200);
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /*print_r($request->all());
        echo '<hr>';
        print_r($marca->getAttributes());*/
        $marca = $this->marca->find($id);
        if($marca === null) {
            return ['erro' => 'impossível realizar atualização o recurso pesquisado não existe!'];
        }

        if($request->method() === 'PATCH') {
            $dinamicRules = array();
            foreach($marca->rules() as $input => $rule) {
                if(array_key_exists($input,$request->all())) {
                    $dinamicRules[$input] = $rule;
                }
            }
            $request->validate($dinamicRules, $marca->feedback());
        } else {
            $request->validate($marca->rules(), $marca->feedback());
        }
        $marca->update($request->all());
        return response()->json($marca,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marca = $this->marca->find($id);
        $marca->delete();
        return response()->json(['msg' => 'A marca foi removida com sucesso!'],200);
    }
}
