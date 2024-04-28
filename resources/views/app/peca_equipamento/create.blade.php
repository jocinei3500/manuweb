@extends('app.layouts.app')

@section('content')

<main class="content">
    <div class="card">

        <div class="card-footer justify-content-left">
            <a href="" class="btn">
                Cadastro de peças do equipamento
            </a>
        </div>
        <div class="card-body">
            @component('app.peca_equipamento._components.form_create_edit', ['produtos'=>$produtos, 'equipamento'=>$equipamento])
            @endcomponent
        </div>
    </div>

</main>
@endsection