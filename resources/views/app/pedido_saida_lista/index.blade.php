@extends('app.layouts.app')
@section('content')
<script src="{{ asset('js/update_datatime.js') }}" defer></script>
<script src="{{ asset('js/timeline_google.js') }}" defer></script>
<main class="content">
    <div class="card">
        Pedido de saída listagem
        <style>
            .card-header {
                background-color: rgb(211, 211, 211);
                opacity: 0.95;
            }
        </style>
        <div class="card-header">
            <script>
                function Funcao() {
                    alert('teste');
                    document.getElementById("t1").value = "{{$funcionarios}}"
                }
            </script>
            <!------------------------------------->
            <!----teste de url--------------------->
            <div class="form-row">
            </div>
            <!------------------------------------------------------------------------------------------->
            <!----datas---------------------------------------------------------------------------------->
            <!------------------------------------------------------------------------------------------->
            <div class="form-row">
                @foreach ($pedidos_saida as $pedido_saida_f)
                @endforeach
                <div class="col-md-2">
                    <label for="id">ID:</label>
                    <input type="number" class="form-control" name="id" id="data_inicio" value="{{$pedido_saida_f->id ?? old('id') }}" required autocomplete="id" autofocus readonly>
                    {{ $errors->has('id') ? $errors->first('id') : '' }}
                </div>
                <!--------------------------------------------------------------------------------------->
                <div class="col-md-2">
                    <label for="data_inicio">Data Emissão:</label>
                    <input type="date" class="form-control" name="data_inicio" id="data_inicio" value="{{$pedido_saida_f->data_emissao ?? old('data_emissao') }}" required autocomplete="data_emissao" autofocus readonly>
                    {{ $errors->has('data_emissao') ? $errors->first('data_emissao') : '' }}
                </div>
                <div class="col-md-2">
                    <label for="hora_inicio">Hora Emissão:</label>
                    <input type="time" class="form-control" name="hora_inicio" id="hora_inicio" value="{{$pedido_saida_f->hora_emissao ?? old('hora_emissao') }}" required autocomplete="hora_emissao" autofocus readonly>
                    {{ $errors->has('hora_emissao') ? $errors->first('hora_emissao') : '' }}
                </div>
                <div class="col-md-2">
                    <label for="dataFim">Data Prevista entrega:</label>
                    <input type="date" class="form-control" name="data_fim" id="dataFim" value="{{$pedido_saida_f->data_prevista ?? old('data_prevista') }}" required autocomplete="data_prevista" autofocus readonly>
                    {{ $errors->has('data_prevista') ? $errors->first('data_prevista') : '' }}
                </div>
                <div class="col-md-2">
                    <label for="horaFim">Hora prevista:</label>
                    <input type="time" class="form-control" name="hora_fim" id="horaFim" value="{{$pedido_saida_f->hora_prevista ?? old('hora_prevista') }}" required autocomplete="hora_prevista" autofocus readonly>
                    {{ $errors->has('hora_prevista') ? $errors->first('hora_prevista') : '' }}
                </div>
                <div class="col-md-2">
                    <label for="emissor">Emissor do pedido:</label>
                    <input type="text" class="form-control" name="emissor" id="emissor" value="{{$pedido_saida_f->funcionarios->primeiro_nome ?? old('hora_prevista') }}" required autocomplete="funcionarios_id " autofocus readonly>
                    {{ $errors->has('funcionarios_id ') ? $errors->first('funcionarios_id ') : '' }}
                </div>

                <div class="col-md-2">
                    <label for="status">Status:</label>
                    <input type="text" class="form-control" name="status" id="status" value="{{$pedido_saida_f->status ?? old('status') }}" required autocomplete="status" autofocus readonly>
                    {{ $errors->has('status') ? $errors->first('status') : '' }}
                </div>
                <!---------Select empresa------------->
                <!------------------------------------>
                <div class="col-md-1">
                    <label for="equipamento">Equipamento:</label>
                    <input type="text" class="form-control" name="equipamento" id="equipamento" value="{{$pedido_saida_f->equipamento->nome ?? old('hora_prevista') }}" required autocomplete="funcionarios_id " autofocus readonly>
                    {{ $errors->has('funcionarios_id ') ? $errors->first('funcionarios_id ') : '' }}
                </div>

                <div class="col-md-1">
                    <label for="ordem_serviço_id">Ordem serviço:</label>
                    <input type="text" class="form-control" name="ordem_servico_id" id="ordem_servico_id" placeholder="ordem_serviço_id" value="{{$pedido_saida_f->ordem_servico_id}}" readonly>
                </div>
                <div class="col-md-0">
                    <label for="equipamento">ir para o.s:</label>
                    <p></p>
                    <a class="btn btn-sm-template btn-outline-primary" href="{{route('ordem-servico.show', ['ordem_servico'=>$pedido_saida_f->ordem_servico_id])}}">
                        <i class="icofont-eye-alt icofont-2x"></i>
                    </a>
                </div>
                <!--------------------------------------->
                <div class="col-md-0">
                    <label for="ordem_servico_id">Voltar:</label>
                    <p>
                        <a href="{{route('pedido-saida.index')}}" class="btn btn-info btn-icon-split">
                            <span class="icon text-white-50 ">
                                <i class="icofont-list"></i>
                            </span>
                            <span class="text">Voltar para pedidos de saída</span>
                        </a>

                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table-template table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="th-title">Id</th>
                        <th scope="col" class="th-title">Cod fabricante</th>
                        <th scope="col" class="th-title">Produto_ID</th>
                        <th scope="col" class="th-title">Descrição</th>
                        <th scope="col" class="th-title">Unidade</th>
                        <th scope="col" class="th-title">Quantidade</th>
                        <th scope="col" class="th-title">Valor Unit</th>
                        <th scope="col" class="th-title">Subtotal</th>
                        <th scope="col" class="th-title">Data</th>
                        <th scope="col" class="th-title">Patrmônio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($saidas_produto as $saida_produto)
                    <tr>
                        <th scope="row">{{$saida_produto->id }}</td>
                        <td>{{ $saida_produto->produto->cod_fabricante}}</td>
                        <td>{{ $saida_produto->produto->id}}</td>
                        <td>{{ $saida_produto->produto->nome}}</td>
                        <td>{{ $saida_produto->unidade_medida}}</td>
                        <td>{{ $saida_produto->quantidade}}</td>
                        <td>{{ $saida_produto->valor}}</td>
                        <td>{{ $saida_produto->subtotal}}</td>
                        <td>{{ $saida_produto->data }}</td>
                        <td>{{ $saida_produto->equipamento->nome}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!--Iframe do subformulario de produtos-->
        <!-- <iframe id="ifm1" src="{{route('item-produto-saida.index',['pedido' => $pedido_saida_f->id,'empresa_id'=>$pedido_saida_f->empresa->id,'equipamento'=>$pedido_saida_f->equipamento->id])}}" width="90%" height="600" style="border:1px solid black;">-->
        <!-- <iframe id="ifm1" src="{{route('item-produto-saida.index',['pedido' => $pedido_saida_f->id,'empresa_id'=>$pedido_saida_f->empresa->id,'equipamento'=>$pedido_saida_f->equipamento->id])}}" width="90%" height="600" style="border:1px solid black;">  
    </iframe>-->
        <iframe id="ifm1" src="{{route('item-produto-saida.index',['pedido' => $pedido_saida_f->id,'empresa_id'=>$pedido_saida_f->empresa->id,'equipamento'=>$pedido_saida_f->equipamento->id])}}" width="90%" height="600" style="border:1px solid black;">
        </iframe>
        @endsection

        <footer>
        </footer>

        </html>