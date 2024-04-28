<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Equipamento;
use App\Models\PecasEquipamentos;
use App\Models\OrdemServico;

class PecaEquipamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $equipamento)
    {
        //
        $equipamento_id = $equipamento->get('equipamento');
        $pecasEquip = PecasEquipamentos::where('equipamento',  $equipamento_id)->orderby('horas_proxima_manutencao')->get();
        $equipamento = Equipamento::where('id',  $equipamento_id)->get();
        //****filtro ordem de serviço pelo equipamento situacao*****
            $ordens_servicos = OrdemServico::where('equipamento_id',  $equipamento_id)->where('situacao','aberto')->orderby('data_inicio')->orderby('hora_inicio')->get();
           
        return view('app.peca_equipamento.index', ['pecas_equipamento' => $pecasEquip, 'equipamento' => $equipamento,'ordens_servicos'=>$ordens_servicos]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $equipamento_id)
    {
        //
        $equipamentoId = $equipamento_id->get('equipamento');
        $produtos = Produto::all();
        $equipamento = Equipamento::where('id',  $equipamentoId)->get();
        return view('app.peca_equipamento.create', [
            'produtos' => $produtos,
            'equipamento' => $equipamento,
        ]);
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
        PecasEquipamentos::create($request->all());
        $equipamentoId = $request->get('equipamento');
        $equipamento = Equipamento::where('id', $equipamentoId)->get();
        $pecasEquip = PecasEquipamentos::where('equipamento',$equipamentoId)->get();
        return view('app.peca_equipamento.index', ['pecas_equipamento' => $pecasEquip, 'equipamento' => $equipamento]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
