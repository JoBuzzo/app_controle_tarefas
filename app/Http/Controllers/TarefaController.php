<?php

namespace App\Http\Controllers;

use App\Exports\TarefasExport;
use App\Http\Requests\TarefaStoreUpdateFormRequest;
use App\Mail\NovaTarefaMail;
use App\Models\Tarefa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class TarefaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth()->user()->id;
        $tarefas = Tarefa::where('user_id', $user_id)->paginate(2);
        return view('tarefa.index', ['tarefas' => $tarefas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tarefa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TarefaStoreUpdateFormRequest $request)
    {
        $dados = $request->all();
        $dados['user_id'] = auth()->user()->id;

        $tarefa = Tarefa::create($dados);
        $destinatario = auth()->user()->email;
        Mail::to($destinatario)->send(new NovaTarefaMail($tarefa));

        return redirect()->route('tarefa.show', $tarefa->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function show(Tarefa $tarefa)
    {
        return view('tarefa.show', ['tarefa' => $tarefa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function edit(Tarefa $tarefa)
    {
        if(!auth()->user()->id == $tarefa->user_id){
            return view('acesso-negado');
        }

        return view('tarefa.edit', ['tarefa' => $tarefa]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function update(TarefaStoreUpdateFormRequest $request, Tarefa $tarefa)
    {
        if(!auth()->user()->id == $tarefa->user_id){
            return view('acesso-negado');
        }

        $tarefa->update($request->all());

        return redirect()->route('tarefa.show', $tarefa->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tarefa $tarefa)
    {
        if(!auth()->user()->id == $tarefa->user_id){
            return view('acesso-negado');
        }
        
        $tarefa->delete();

        return redirect()->route('tarefa.index');
    }

    public function exportacao($extensao)
    {
        if(in_array($extensao, ['xlsx', 'csv', 'pdf'])){
            return Excel::download(new TarefasExport, "lista_de_tarefas.$extensao");     
        }
        return redirect()->route('tarefa.index');
        
    }
    public function exportar()
    {
        $tarefas = auth()->user()->tarefas;
        $pdf = Pdf::loadView('tarefa.pdf', ['tarefas' => $tarefas]);
        // return $pdf->download('lista_de_tarefas.pdf');
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('lista_de_tarefas.pdf');
        
    }

}
