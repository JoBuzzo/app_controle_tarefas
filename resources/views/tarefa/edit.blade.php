@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Atualizar tarefa</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('tarefa.update', $tarefa->id) }}">
                            @method('PUT')
                            @csrf
                            <div class="mb-3">
                                <label for="tarefa" class="form-label">Tarefa</label>
                                <input type="text" class="form-control" id="tarefa" name="tarefa" value="{{ $tarefa->tarefa }}">
                            </div>
                            <div class="mb-3">
                                <label for="data_limite_conclusao" class="form-label">Data limite conclusão</label>
                                <input type="date" class="form-control" id="data_limite_conclusao"
                                    name="data_limite_conclusao" value="{{ $tarefa->data_limite_conclusao }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
