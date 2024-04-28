@if (isset($equipamento->id))
<form action="{{ route('Peca-equipamento.update', ['pecas_equipamento' => $pecas_equipamento->id]) }}" method="POST">
    @csrf
    @method('PUT')
    @else
    <form action="{{ route('Peca-equipamento.store') }}" method="POST">
        @csrf
        @endif
        <div class="row mb-1">
            <label for="equipamento_id" class="col-md-4 col-form-label text-md-end text-right">ID</label>
            <div class="col-md-6">
                <input id="equipamento" type="nuber" class="form-control-template" name="equipamento" value="@foreach($equipamento as $equipamento_f)
                    {{$equipamento_f['id']}}
                    @endforeach" readonly>
                {{ $errors->has('equipamento') ? $errors->first('equipamento') : '' }}
            </div>
        </div>
        <div class="row mb-1">
            <label for="equipamento_id" class="col-md-4 col-form-label text-md-end text-right">Equipamento</label>
            <div class="col-md-6">
                <input id="equipamento_nome" type="nuber" class="form-control-template" name="equipamento_nome" value="@foreach($equipamento as $equipamento_f)
                    {{$equipamento_f['nome']}}
                    @endforeach" readonly>
                {{ $errors->has('id') ? $errors->first('id') : '' }}
            </div>
        </div>

        <div class="row mb-1">
            <label for="produtos" class="col-md-4 col-form-label text-md-end text-right">Produto</label>
            <div class="col-md-6">
                <select name="produto_id" id="" class="form-control">
                    <option value=""> --Selecione o Produto--</option>
                    @foreach ($produtos as $produto )
                    <option value="{{ $produto ->id}}" {{ ($produto ->nome ?? old('nome')) == $produto ->nome? 'selected' : '' }}>
                    {{ $produto ->id }}.{{ $produto ->nome }}
                    </option>
                    @endforeach
                </select>
                {{ $errors->has('nome') ? $errors->first('nome') : '' }}
            </div>
        </div>
        <div class="row mb-3">
            <label for="data" class="col-md-4 col-form-label text-md-end text-right">Data da ultima manutenção</label>
            <div class="col-md-6">
                <input name="data_substituicao" id="data_substituicao" type="date" class="form-control " value="">
                {{ $errors->has('data') ? $errors->first('data') : '' }}
            </div>
        </div>
        <div class="row mb-3">
            <label for="data" class="col-md-4 col-form-label text-md-end text-right">hora da ultima manutenção</label>
            <div class="col-md-6">
                <input name="hora_substituicao" id="hora_substituicao" type="time" class="form-control " value="">
                {{ $errors->has('data') ? $errors->first('data') : '' }}
            </div>
        </div>
        <div class="row mb-3">
            <label for="intervalo_manutencao" class="col-md-4 col-form-label text-md-end text-right">intervalo manutencao</label>
            <div class="col-md-6">
                <input name="intervalo_manutencao" id="intervalo_manutencao" type="number" class="form-control " value="" onchange="AtualizaProxManut()">
                {{ $errors->has('intervalo_manutencao') ? $errors->first('intervalo_manutencao') : '' }}
            </div>
        </div>
        <script>
            function AtualizaProxManut() {
                let dataUltimaSub, anoUltimasub, diaUltimaSub
                let dataProxManut
                let intervaloMan
                let mesesInter
                let diasInter
                let mesesProxima, diasProxima, anosProxima
                dataUltimaSub = document.getElementById('data_substituicao').value
                intervaloMan = document.getElementById('intervalo_manutencao').value
                let dataUltimaSub_1 = new Date(dataUltimaSub)
                let anoUltima = dataUltimaSub_1.getFullYear();
                let mesUltima = dataUltimaSub_1.getMonth() + 1;
                let diaUltima = dataUltimaSub_1.getDate() + 1;
                if (intervaloMan >= 8700) {
                    let anosInter = (intervaloMan / 8700)
                    let anosInter_1 = (parseInt(anosInter))
                    let getMeses = (parseInt(((anosInter - anosInter_1) * 8700) / 730))
                    mesesProxima = String(getMeses + 1).padStart(2, '0');
                    anosProxima = String(anosInter_1 + anoUltima).padStart(4, '0');
                    diasProxima = String(diaUltima).padStart(2, '0')
                    alert('A data da próxima manutenção será agendada para:' + diasProxima + '-' + mesesProxima + '-' + anosProxima)
                }
                if (intervaloMan >= 720 & intervaloMan < 8700) {
                    mesesInter = (parseInt(intervaloMan / 730))
                    //mesesProxima =( mesesInter + mesUltima).padStart(2, '0')
                    anosProxima = String(anoUltima).padStart(4, '0');
                    mesesProxima = String(mesesInter + mesUltima).padStart(2, '0');
                    diasProxima = String(diaUltima).padStart(2, '0')
                    alert('A data da próxima manutenção será agendada para:' + diasProxima + '-' + mesesProxima + '-' + anosProxima)
                }
                if (intervaloMan >= 1 & intervaloMan < 720) {
                    diasInter = (parseInt(intervaloMan / 24)) + diaUltima
                    if (diasInter >= 30) {
                        mesUltima = mesUltima + 1

                        diasInter = diasInter - 30
                        diasInter = diasInter

                    }
                    anosProxima = anoUltima
                    mesesProxima = String(mesUltima).padStart(2, '0');
                    diasProxima = String(diasInter).padStart(2, '0')
                    alert('A data da próxima manutenção será agendada para:' + diasProxima + '-' + mesesProxima + '-' + anosProxima)
                }
                //var dia = String(data_atual.getDate()).padStart(2, '0');
                //var mes = String(mesesProxima .getMonth() + 1).padStart(2, '0');
                dataProxManut = anosProxima + '-' + mesesProxima + '-' + diasProxima
                document.getElementById('data_proxima_manutencao').value = dataProxManut
                document.getElementById('horas_proxima_manutencao').value = intervaloMan
                document.getElementById('status').value = 'ativo'
                // document.getElementById('link_peca').value='vazio'
                // document.getElementById('forma_medicao').value=1
            }
        </script>
        <div class="row mb-3">
            <label for="data_proxima_manutencao" class="col-md-4 col-form-label text-md-end text-right">Data da próxima manutenção</label>
            <div class="col-md-6">
                <input name="data_proxima_manutencao" id="data_proxima_manutencao" type="date" class="form-control " value="" readonly>
                {{ $errors->has('data') ? $errors->first('data') : '' }}
            </div>
        </div>
        <div class="row mb-3">
            <label for="horas_proxima_manutencao" class="col-md-4 col-form-label text-md-end text-right">horas restantes</label>
            <div class="col-md-6">
                <input name="horas_proxima_manutencao" id="horas_proxima_manutencao" type="number" class="form-control " value="" readonly>
                {{ $errors->has('quantidade') ? $errors->first('quantidade') : '' }}
            </div>
        </div>
        <div class="row mb-3">
            <label for="horimetro" class="col-md-4 col-form-label text-md-end text-right">Horimetro</label>
            <div class="col-md-6">
                <input name="horimetro" id="horimetro" type="number" class="form-control " value="10">
                {{ $errors->has('quantidade') ? $errors->first('quantidade') : '' }}
            </div>
        </div>
        <div class="row mb-3">
            <label for="forma_medicao" class="col-md-4 col-form-label text-md-end text-right">Forma medição</label>
            <div class="col-md-6">
                <input name="forma_medicao" id="forma_medicao" type="number" class="form-control " value="1">
                {{ $errors->has('quantidade') ? $errors->first('quantidade') : '' }}
            </div>
        </div>
        <div class="row mb-3">
            <label for="quantidade" class="col-md-4 col-form-label text-md-end text-right">quantidade</label>
            <div class="col-md-6">
                <input name="quantidade" id="quantidade" type="number" class="form-control " value="">
                {{ $errors->has('quantidade') ? $errors->first('quantidade') : '' }}
            </div>
        </div>
        <div class="row mb-3">
            <label for="status" class="col-md-4 col-form-label text-md-end text-right">Status</label>
            <div class="col-md-6">
                <input name="status" id="status" type="text" class="form-control " value="">
                {{ $errors->has('status') ? $errors->first('status') : '' }}
            </div>
        </div>
        <div class="row mb-3">
            <label for="link_peca" class="col-md-4 col-form-label text-md-end text-right">link_peca</label>
            <div class="col-md-6">
                <input name="link_peca" id="link_peca" type="text" class="form-control " value="vazio">
                {{ $errors->has('link_peca') ? $errors->first('link_peca') : '' }}
            </div>
        </div>
        <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ isset($equipamento) ? 'Atualizar' : 'Cadastrar' }}
                </button>
            </div>
        </div>
    </form>
    <style>
        form{
            background-color: rgb(211,211,211);
        }
    </style>