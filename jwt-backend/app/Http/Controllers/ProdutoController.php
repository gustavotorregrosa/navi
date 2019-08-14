<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;

class ProdutoController extends Controller
{


    function __construct()
    {
        $this->middleware('jwt');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itens = Produto::all();
        return respostaCors($itens, 200);
    }

    public function salvar(Request $request)
    {
        $id = $request->input('id');
        if ($id) {
            return $this->update($request, $id);
        } else {
            return $this->create($request);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($request)
    {
        $produto = new Produto;
        $produto->nome = $request->input('nome');
        $produto->descricao = $request->input('descricao');
        $produto->valor = $request->input('valorSanitizado');
        $produto->quantidade = $request->input('quantidade');

        try {
            $produto->save();
            return respostaCors("Produto " . $produto->nome . " criado", 200);
        } catch (Exception $e) {
            return respostaCors($e->getMessage(), 501);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produto = Produto::find($id);
        $produto->nome = $request->input('nome');
        $produto->descricao = $request->input('descricao');
        $produto->valor = $request->input('valorSanitizado');
        $produto->quantidade = $request->input('quantidade');

        try {
            $produto->save();
            return respostaCors("Produto " . $produto->nome . " modificado", 200);
        } catch (Exception $e) {
            return respostaCors($e->getMessage(), 501);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $produto = Produto::find($id);
            $nome = $produto->nome;
            $produto->delete();
            return respostaCors("Produto " . $nome . " deletado", 200);
        } catch (Exception $e) {
            return respostaCors($e->getMessage(), 501);
        }
    }
}
