@extends('app.layouts.app')

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div>VISUALIZAÇÃO DO EQUIPAMENTO</div>
            <diV>
                <a class="btn btn-sm btn-primary" href="{{route('equipamento.index')}}" class="btn">
                    LISTAGEM
                </a>

                <a class="btn btn-sm btn-primary" href="{{route('equipamento.create')}}" class="btn">
                    Cadastrar novo patrimônio
                </a>
                <a href="{{ route('Peca-equipamento.create',['equipamento' => $equipamento->id]) }}" class="btn btn-sm btn-primary">
                    Novo Componente<span class="material-symbols-outlined">
                        create_new_folder
                    </span>
                </a>
                <a href="{{route('ordem-servico.create', ['equipamento'=>$equipamento->id,'empresa'=>2])}}" class=" btn btn-sm btn-success">
                    <span class="icon text-white-50">
                    </span>
                    <span class="text">Nova O.S</span>
                    <span class="material-symbols-outlined">
                        add_ad
                    </span>
                </a>
                <a href="{{route('pedido-compra.create',['equipamento_id' => $equipamento->id])}}" class="btn btn-sm btn-primary">
                    Pedido Compra <span class="material-symbols-outlined">
                        list_alt_add
                    </span>

                </a>
                <a class="btn btn-sm-template btn-outline-primary" href="{{ route('app.home') }}">
                    <i class="icofont-dashboard"></i> dashboard
                </a>
            </div>
        </div>
    </div>
    {{-------------------------------------------------------------------------}}
    {{--Inicio do bloco que contém o continer dos gráficos---------------------}}
    <div class="container-chart">
        {{--Box 1--}}
        <div class="item">
            Qrcode
            <hr>
            <div class="card-body">
                <?php
                $protocolo = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == "on") ? "https" : "http");
                $url = '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $urlPaginaAtual = $protocolo . $url
                //echo $protocolo.$url;
                ?>
                {!! QrCode::size(100)->backgroundColor(255,90,0)->generate( $urlPaginaAtual ) !!}
                {!! QrCode::size(100)->backgroundColor(255,90,0)->generate( $equipamento->id.'--'.$equipamento->nome) !!}
            </div>
        </div>
        {{--Box 2--}}
        <div class="item">
            Patrimonio
            <hr>

            ID:
            <h5>{{$equipamento->id}}</h5>
            <p></p>

            Nome:
            <h5>{{$equipamento->nome}}</h5>
            <p></p>

            DESCRIÇÂO:
            <h5>{{$equipamento->descricao}}</h5>

            <p></p>

            MARCA:
            {{$equipamento->marca->nome}}
            <p></p>

            Empresa:
            <h6> {{$equipamento->Empresa->razao_social}}</h6>

            <p></p>

            Data de fabricação:
            {{$equipamento->data_fabricacao}}
            <p></p>

            <hr>
        </div>
        {{--Box 3--}}
        <div class="item">
            Arquivos anexado documentação
            <hr>
            <a href="/patrimonios/{{$equipamento->anexo_1}}" target="_blank">Anexo 1 | {{$equipamento->anexo_2}}<span class="material-symbols-outlined">
                    open_in_new
                </span></a>
            <p></p>
            <a href="/patrimonios/{{$equipamento->anexo_2}}" target="_blank">Anexo 2 | {{$equipamento->anexo_2}} <span class="material-symbols-outlined">
                    open_in_new
                </span></a>
        </div>
        {{--fim card--}}

        {{--------------------------------------------------------------------}}
        {{--Ordens de serviço em andamento -----------------------------------}}
        <hr>
        <h6>Ordem de serviço deste equipamento em andamento</h6>

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Tabela Modelo</title>
        </head>

        <body>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data de Início</th>
                        <th>Hora de Início</th>
                        <th>Data de Fim</th>
                        <th>Hora de Fim</th>
                        <th>Empresa</th>
                        <th>Patrimônio</th>
                        <th>Emissor</th>
                        <th>Responsável</th>
                        <th>Descrição</th>
                        <th>Status</th>
                        <th>Valor</th>
                        <th>Operações</th>
                        <th>check</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ordens_servicos_1 as $ordem_servico)
                    @php
                    // Definir o fuso horário para America/Sao_Paulo
                    date_default_timezone_set('America/Sao_Paulo');

                    // Obter o horário atual de Brasília
                    $dataAtual = \Illuminate\Support\Carbon::now();
                    //-------------------------------------------------//
                    $dataFim = \Carbon\Carbon::parse($ordem_servico->data_fim);
                    $horaFim = \Carbon\Carbon::parse($ordem_servico->hora_fim);
                    $dataAtual = \Carbon\Carbon::now();
                    $classData = '';
                    $classHora = '';

                    // Regras para data de fim verde//
                    if ($dataFim->greaterThan($dataAtual)) {
                    $classData = 'bg-green';
                    $classHora = 'bg-green';//seta para verde
                    }
                    // Regras para data de fim amarelo
                    if ($dataFim->isSameDay($dataAtual)) {
                    $classData = 'bg-yellow';
                    // -----------Regras para hora de fim
                    $horaFimSemSegundos = $horaFim->copy()->second(0); // Define os segundos como 0
                    $horaAtualSemSegundos = $dataAtual->copy()->second(0); // Define os segundos como 0
                    if ($horaFimSemSegundos->greaterThan($horaAtualSemSegundos)) {
                    $classHora = 'bg-green'; // seta para verde
                    } elseif ($horaFimSemSegundos->equalTo($horaAtualSemSegundos)) {
                    $classHora = 'bg-yellow'; // seta para amarelo
                    } elseif ($horaFimSemSegundos->lessThan($horaAtualSemSegundos)) {
                    $classHora = 'bg-red'; // seta para vermelho
                    }
                    // Regras para data de fim vermelho//
                    } elseif ($dataFim->lessThan($dataAtual)) {
                    $classData = 'bg-red';
                    // -----------Regras para hora de fim
                    $classHora = 'bg-red';//seta para vermelho
                    }
                    @endphp

                    <tr>
                        <td>{{ $ordem_servico->id }}</td>
                        <td> {{ date( 'd/m/Y' , strtotime($ordem_servico['data_inicio']))}}</td>
                        <td>{{ $ordem_servico->hora_inicio }}</td>
                        <td class="{{ $classData }}">{{ date( 'd/m/Y' , strtotime($ordem_servico['data_fim']))}}</td>
                        <td class="{{ $classHora }}">{{ $ordem_servico->hora_fim }}</td>
                        <td>
                            {{ $ordem_servico->Empresa->razao_social}}
                        </td>
                        <td>{{ $ordem_servico->equipamento->nome}}</td>
                        <td>{{ $ordem_servico->emissor}}</td>
                        <td>{{ $ordem_servico->responsavel}}</td>
                        <td id="descricao">

                            {{ $ordem_servico->descricao}}

                        </td>
                        <td>{{ $ordem_servico->situacao}}
                            <div class="progress mb-3" role="progressbar" aria-label="Success example with label" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar text-bg-warning">{{ $ordem_servico->status_servicos}}%</div>
                            </div>
                        </td>
                        <td id="valor" value="{{ $ordem_servico->valor}}">{{ $ordem_servico->valor}}</td>
                        <!--Div operaçoes do registro da ordem des serviço-->
                        <td>
                            <div {{-- class="div-op" --}} class="btn-group btn-group-actions visible-on-hover">
                                <a class="btn btn-sm-template btn-outline-primary" href="{{route('ordem-servico.show', ['ordem_servico'=>$ordem_servico->id])}}">
                                    <i class="icofont-eye-alt"></i>
                                </a>

                                <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="{{route('ordem-servico.edit', ['ordem_servico'=>$ordem_servico->id])}}">

                                    <i class="icofont-ui-edit"></i> </a>

                                <!--Condoçes para deletar a os-->
                                <form id="form_{{ $ordem_servico->id }}" method="post" action="{{route('ordem-servico.destroy', ['ordem_servico'=>$ordem_servico->id])}}">
                                    @method('DELETE')
                                    @csrf

                                </form>
                                <a class="btn btn-sm-template btn-outline-danger @can('user') disabled @endcan" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick=" DeletarOs()">
                                    <i class="icofont-ui-delete"></i>
                                    <script>
                                        function DeletarOs() {
                                            var x;
                                            var r = confirm("Deseja deletar a ordem de serviço?");
                                            if (r == true) {

                                                document.getElementById('form_{{$ordem_servico->id }}').submit()
                                            } else {
                                                x = "Você pressionou Cancelar!";
                                            }
                                            document.getElementById("demo").innerHTML = x;
                                        }
                                    </script>
                                </a>
                                <!------------------------------>

                            </div>
                        <td>
                            <div class="col-md-2 mb-0">
                                <input type="checkbox" name="" id="">
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
</main>

@endsection
{{------------------------------teste pinta campo  tabela aberto-----------------------------}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<h6>Ordens em aberto</h6>

<body>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Data de Início</th>
                <th>Hora de Início</th>
                <th>Data de Fim</th>
                <th>Hora de Fim</th>
                <th>Empresa</th>
                <th>Patrimônio</th>
                <th>Emissor</th>
                <th>Responsável</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Valor</th>
                <th>Operações</th>
                <th>check</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ordens_servicos as $ordem_servico)
            @php
            // Definir o fuso horário para America/Sao_Paulo
            date_default_timezone_set('America/Sao_Paulo');

            // Obter o horário atual de Brasília
            $dataAtual = \Illuminate\Support\Carbon::now();
            //-------------------------------------------------//
            $dataFim = \Carbon\Carbon::parse($ordem_servico->data_fim);
            $horaFim = \Carbon\Carbon::parse($ordem_servico->hora_fim);
            $dataAtual = \Carbon\Carbon::now();
            $classData = '';
            $classHora = '';
            // Regras para data de fim verde//
            if ($dataFim->greaterThan($dataAtual)) {
            $classData = 'bg-green';
            $classHora = 'bg-green';//seta para verde
            }
            // Regras para data de fim amarelo
            if ($dataFim->isSameDay($dataAtual)) {
            $classData = 'bg-yellow';
            // -----------Regras para hora de fim
            $horaFimSemSegundos = $horaFim->copy()->second(0); // Define os segundos como 0
            $horaAtualSemSegundos = $dataAtual->copy()->second(0); // Define os segundos como 0
            if ($horaFimSemSegundos->greaterThan($horaAtualSemSegundos)) {
            $classHora = 'bg-green'; // seta para verde
            } elseif ($horaFimSemSegundos->equalTo($horaAtualSemSegundos)) {
            $classHora = 'bg-yellow'; // seta para amarelo
            } elseif ($horaFimSemSegundos->lessThan($horaAtualSemSegundos)) {
            $classHora = 'bg-red'; // seta para vermelho
            }
            // Regras para data de fim vermelho//
            } elseif ($dataFim->lessThan($dataAtual)) {
            $classData = 'bg-red';
            // -----------Regras para hora de fim
            $classHora = 'bg-red';//seta para vermelho
            }
            @endphp
            <tr>
                <td>{{ $ordem_servico->id }}</td>
                <td> {{ date( 'd/m/Y' , strtotime($ordem_servico['data_inicio']))}}</td>
                <td>{{ $ordem_servico->hora_inicio }}</td>
                <td class="{{ $classData }}">{{ date( 'd/m/Y' , strtotime($ordem_servico['data_fim']))}}</td>
                <td class="{{ $classHora }}">{{ $ordem_servico->hora_fim }}</td>
                <td>
                    {{ $ordem_servico->Empresa->razao_social}}
                </td>
                <td>{{ $ordem_servico->equipamento->nome}}</td>
                <td>{{ $ordem_servico->emissor}}</td>
                <td>{{ $ordem_servico->responsavel}}</td>
                <td id="descricao">

                    {{ $ordem_servico->descricao}}

                </td>
                <td>{{ $ordem_servico->situacao}}
                    <div class="progress mb-3" role="progressbar" aria-label="Success example with label" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar text-bg-warning">{{ $ordem_servico->status_servicos}}%</div>
                    </div>
                </td>
                <td id="valor" value="{{ $ordem_servico->valor}}">{{ $ordem_servico->valor}}</td>
                <!--Div operaçoes do registro da ordem des serviço-->
                <td>
                    <div {{-- class="div-op" --}} class="btn-group btn-group-actions visible-on-hover">
                        <a class="btn btn-sm-template btn-outline-primary" href="{{route('ordem-servico.show', ['ordem_servico'=>$ordem_servico->id])}}">
                            <i class="icofont-eye-alt"></i>
                        </a>

                        <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="{{route('ordem-servico.edit', ['ordem_servico'=>$ordem_servico->id])}}">

                            <i class="icofont-ui-edit"></i> </a>

                        <!--Condoçes para deletar a os-->
                        <form id="form_{{ $ordem_servico->id }}" method="post" action="{{route('ordem-servico.destroy', ['ordem_servico'=>$ordem_servico->id])}}">
                            @method('DELETE')
                            @csrf

                        </form>
                        <a class="btn btn-sm-template btn-outline-danger @can('user') disabled @endcan" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick=" DeletarOs()">
                            <i class="icofont-ui-delete"></i>
                            <script>
                                function DeletarOs() {
                                    var x;
                                    var r = confirm("Deseja deletar a ordem de serviço?");
                                    if (r == true) {

                                        document.getElementById('form_{{$ordem_servico->id }}').submit()
                                    } else {
                                        x = "Você pressionou Cancelar!";
                                    }
                                    document.getElementById("demo").innerHTML = x;
                                }
                            </script>
                        </a>
                        <!------------------------------>

                    </div>
                <td>
                    <div class="col-md-2 mb-0">
                        <input type="checkbox" name="" id="">
                    </div>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</body>
<style>
    #graficoPizza {
        background-color: transparent;
    }

    body,
    html {
        height: 100%;
        margin: 0;
        padding: 0;
        width: auto;
    }

    .container-chart {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;

        align-items: flex-start;
        background-color: #f2f2f2;
    }

    .item {
        width: 33%;
        /* Define a largura das caixas */
        height: 400px;
        margin-bottom: 1px;
        background-color: #ccc;
        border-radius: 5px;
        padding: 5px;
        /*height: 40vh; /* 100% da altura da janela do navegador */
    }

    .box {
        display: flex;
        width: 100%;
        /* Define a largura das caixas */
        height: auto;
        margin-bottom: 1px;
        background-color: #ccc;
        border-radius: 5px;
        padding: 5px;
        /*height: 40vh; /* 100% da altura da janela do navegador */
    }

    @media (max-width: 900px) {
        .item {
            width: 45%;
            height: auto;
            /* Redefine a largura das caixas para ocupar a largura total da tela */
        }
    }

    @media (max-width: 900px) {
        .item {
            width: 100%;
            height: auto;
            /* Redefine a largura das caixas para ocupar a largura total da tela */
        }
    }
</style>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    .bg-green {
        background-color: #a3e6a3;
    }

    .bg-yellow {
        background-color: #ffff99;
    }

    .bg-red {
        background-color: #f08080;
    }
</style>
<style>
    #tblOs {
        flex-wrap: wrap;
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: auto;
        background-color: rgb(211, 211, 211);
    }

    #tblPecas {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        background-color: rgb(211, 211, 211);
    }

    thead {
        background-color: rgb(169, 169, 169);
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }

    tr:hover {
        background-color: rgb(169, 169, 169);

    }
</style>
{{------------------------------------------------}}
{{--Tabela de peças dos equipamento---------------}}
<table class="table table-striped table-hover" id="tblPecas">
    <thead>
        <tr>
            <th>ID</th>
            <th>ID Produto </th>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Link</th>
            <th>intervalo</th>
            <th>data ultima substituação</th>
            <th>Hora</th>
            <th>data proxima</th>
            <th>horas proxima</th>
            <th>horimetro</th>
            <th>status</th>
            <th>Operaçoes</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($pecas_equipamento as $peca_equipamento)
        <tr>
            <td scope="row">{{ $peca_equipamento->id }}</td>
            <td>{{ $peca_equipamento->produto->id}}
                <a class="btn btn-sm-template btn-outline-primary" href="{{ route('produto.show', ['produto' =>$peca_equipamento->produto->id]) }}">
                    <i class="icofont-eye-alt"></i>
                </a>
            </td>
            <td>{{ $peca_equipamento->produto->nome}}</td>
            <td>{{ $peca_equipamento->quantidade}}</td>
            <td>{{ $peca_equipamento->link_peca}}</td>
            <td>{{ $peca_equipamento->intervalo_manutencao}}</td>
            <td>{{ date( 'd/m/Y' , strtotime($peca_equipamento['data_substituicao']))}}</td>
            <td>{{ $peca_equipamento->hora_substituicao}}</td>
            <td>{{ date( 'd/m/Y' , strtotime($peca_equipamento['data_proxima_manutencao']))}}</td>
            <td class="
    @if($peca_equipamento->horas_proxima_manutencao >= 48)
        bg-success
    @elseif($peca_equipamento->horas_proxima_manutencao < 48 && $peca_equipamento->horas_proxima_manutencao > 0)
        bg-warning
    @else
        bg-danger
    @endif
">
                {{ $peca_equipamento->horas_proxima_manutencao }}
            </td>
            <td>{{ $peca_equipamento->horimetro}}</td>
            <td>{{ $peca_equipamento->status}}</td>


            </div>
            </td>
            <!--Div operaçoes do registro da ordem des serviço-->
            <td>
                <div {{-- class="div-op" --}} class="btn-group btn-group-actions visible-on-hover">
                    <a class="btn btn-sm-template btn-outline-primary" href="">
                        <i class="icofont-eye-alt"></i>
                    </a>
                    <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="">
                        <i class="icofont-ui-edit"></i> </a>
                    <!--Condoçes para deletar a os-->
                    <form id="" method="post" action="">
                        @method('DELETE')
                        @csrf
                    </form>
                    <a class="btn btn-sm-template btn-outline-danger @can('user') disabled @endcan" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick=" DeletarOs()">
                        <i class="icofont-ui-delete"></i>
                        <script>
                            function DeletarOs() {
                                var x;
                                var r = confirm("Deseja deletar a ordem de serviço?");
                                if (r == true) {

                                    // document.getElementById('').submit()
                                } else {
                                    x = "Você pressionou Cancelar!";
                                }
                                document.getElementById("demo").innerHTML = x;
                            }
                        </script>
                    </a>
                    <!------------------------------>
                </div>
                @endforeach
    </tbody>
</table>