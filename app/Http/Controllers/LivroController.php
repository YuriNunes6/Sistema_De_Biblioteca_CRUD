<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use Illuminate\Http\Request;

class LivroController extends Controller
{
    /**
     * Lista todos os livros
     */
    public function index()
    {
        $livros = Livro::all();
        return view('livros.index', compact('livros'));
    }

    /**
     * Formulário para criar um novo livro
     */
    public function create()
    {
        return view('livros.create');
    }

    /**
     * Salva um novo livro
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'editora' => 'required|string|max:255',
            'ano' => 'required|digits:4|integer|min:1500|max:' . date('Y'),
            'categoria' => 'required|string|max:255',
            'quantidade' => 'required|integer|min:0',
        ]);

        Livro::create($request->all());

        return redirect()->route('livros.index')->with('success', 'Livro cadastrado com sucesso!');
    }

    /**
     * Mostra detalhes de um livro
     */
    public function show(string $id)
    {
        $livro = Livro::findOrFail($id);
        return view('livros.show', compact('livro'));
    }

    /**
     * Formulário para editar um livro
     */
    public function edit(string $id)
    {
        $livro = Livro::findOrFail($id);
        return view('livros.edit', compact('livro'));
    }

    /**
     * Atualiza um livro
     */
    public function update(Request $request, string $id)
    {
        $livro = Livro::findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'editora' => 'required|string|max:255',
            'ano' => 'required|digits:4|integer|min:1500|max:' . date('Y'),
            'categoria' => 'required|string|max:255',
            'quantidade' => 'required|integer|min:0',
        ]);

        $livro->update($request->all());

        return redirect()->route('livros.index')->with('success', 'Livro atualizado com sucesso!');
    }

    /**
     * Remove um livro
     */
    public function destroy(string $id)
    {
        $livro = Livro::findOrFail($id);

        $livro->delete();

        return redirect()->route('livros.index')->with('success', 'Livro excluído com sucesso!');
    }
}