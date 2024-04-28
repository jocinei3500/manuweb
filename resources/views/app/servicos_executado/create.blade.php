@extends('app.layouts.app')

@section('titulo', 'Serviços executados')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div>
                Cadastrar serviço executado
            </div>
            <div>
                <a class="btn btn-sm btn-primary" href="{{ route('marca.index') }}">LISTAGEM</a>
            </div>
        </div>
        <div class="card-body">
            @component('app.servicos_executado._components.form_create_edit', ['ordem_servico'=>$ordem_servico,
            'funcionarios'=>$funcionarios,
            'ordem_servico_id'=>$ordem_servico_id,])
            @endcomponent
        </div>
    </div>
</main>
@endsection