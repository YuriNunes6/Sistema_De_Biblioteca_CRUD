<?php

namespace App\Http\Controllers;

use App\Models\Emprestimo;
use App\Models\Livro;
use Illuminate\Http\Request;

class EmprestimoController extends Controller
{
    /**
     * Lista todos os empréstimos.
     */
    public function index()
    {
        // Carrega empréstimos com dados do livro
        $emprestimos = Emprestimo::with('livro')->get();
        return view('emprestimos.index', compact('emprestimos'));
    }

    /**
     * Formulário para criar um novo empréstimo
     */
    public function create()
    {
        $livros = Livro::where('quantidade', '>', 0)->get(); // livros disponíveis
        return view('emprestimos.create', compact('livros'));
    }

    /**
     * Salva um novo empréstimo
     */
    public function store(Request $request)
    {
        $request->validate([
            'livro_id' => 'required|exists:livros,id',
            'nome' => 'required|string|max:255',
            'data_emprestimo' => 'required|date',
            'data_devolucao' => 'nullable|date|after_or_equal:data_emprestimo',
        ]);

        // Cria o empréstimo
        Emprestimo::create([
            'livro_id' => $request->livro_id,
            'nome' => $request->nome,
            'data_emprestimo' => $request->data_emprestimo,
            'data_devolucao' => $request->data_devolucao,
            'status' => 'emprestado',
        ]);

        // Atualiza quantidade do livro
        $livro = Livro::find($request->livro_id);
        $livro->decrement('quantidade');

        return redirect()->route('emprestimos.index')->with('success', 'Empréstimo registrado com sucesso!');
    }

    /**
     * Mostra detalhes de um empréstimo
     */
    public function show(string $id)
    {
        $emprestimo = Emprestimo::with('livro')->findOrFail($id);
        return view('emprestimos.show', compact('emprestimo'));
    }

    /**
     * Formulário para editar um empréstimo
     */
    public function edit(string $id)
    {
        $emprestimo = Emprestimo::findOrFail($id);
        $livros = Livro::all();
        return view('emprestimos.edit', compact('emprestimo', 'livros'));
    }

    /**
     * Atualiza um empréstimo
     */
    public function update(Request $request, string $id)
    {
        $emprestimo = Emprestimo::findOrFail($id);

        $request->validate([
            'livro_id' => 'required|exists:livros,id',
            'nome' => 'required|string|max:255',
            'data_emprestimo' => 'required|date',
            'data_devolucao' => 'nullable|date|after_or_equal:data_emprestimo',
            'status' => 'required|in:emprestado,devolvido',
        ]);

        // Se status mudou para devolvido, aumenta quantidade do livro
        if ($request->status === 'devolvido' && $emprestimo->status !== 'devolvido') {
            $livro = Livro::find($emprestimo->livro_id);
            $livro->increment('quantidade');
        }

        $emprestimo->update($request->all());

        return redirect()->route('emprestimos.index')->with('success', 'Empréstimo atualizado com sucesso!');
    }

    /**
     * Remove um empréstimo
     */
    public function destroy(string $id)
    {
        $emprestimo = Emprestimo::findOrFail($id);

        // Se ainda estiver emprestado, devolve o livro antes de apagar
        if ($emprestimo->status === 'emprestado') {
            $livro = Livro::find($emprestimo->livro_id);
            $livro->increment('quantidade');
        }

        $emprestimo->delete();

        return redirect()->route('emprestimos.index')->with('success', 'Empréstimo excluído com sucesso!');
    }
}
