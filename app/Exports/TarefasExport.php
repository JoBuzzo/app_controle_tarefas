<?php

namespace App\Exports;

use App\Models\Tarefa;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TarefasExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $tarefas = auth()->user()->tarefas;

        foreach($tarefas as $key => $tarefa){
            $tarefas[$key]->data_limite_conclusao = date('d/m/Y', strtotime($tarefa->data_limite_conclusao));
        }      
        return $tarefas;
    }

    public function headings():array
    {
        return [
            'ID da tarefa', 'Tarefa' ,'ID do usuário', 'Data limite conclusão', 'Data criação', 'Data atualização'
        ];
    }
}
