@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $tarefa->tarefa }}</div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="data_limite_conclusao" class="form-label">Data limite conclusão</label>
                            <input type="date" disabled class="form-control" id="data_limite_conclusao" value="{{ $tarefa->data_limite_conclusao }}">
                        </div>
                        <a href="{{ url()->previous() }}" class="btn btn-primary">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
