{{-- resources/views/livros/create.blade.php --}}
@extends('layouts.app') {{-- assume que seu app.blade.php está em resources/views/layouts/app.blade.php --}}

@section('title', 'Cadastrar Novo Livro')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold text-gray-700 mb-6">Cadastrar Novo Livro</h1>

    <!-- Exibir erros de validação -->
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('livros.store') }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 space-y-6">
        @csrf

        <!-- Título -->
        <div>
            <label for="titulo" class="block text-sm font-medium text-gray-700 mb-1">Título</label>
            <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Digite o título do livro">
        </div>

        <!-- Autor -->
        <div>
            <label for="autor" class="block text-sm font-medium text-gray-700 mb-1">Autor</label>
            <input type="text" name="autor" id="autor" value="{{ old('autor') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Digite o nome do autor">
        </div>

        <!-- Editora -->
        <div>
            <label for="editora" class="block text-sm font-medium text-gray-700 mb-1">Editora</label>
            <input type="text" name="editora" id="editora" value="{{ old('editora') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Digite o nome da editora">
        </div>

        <!-- Ano -->
        <div>
            <label for="ano" class="block text-sm font-medium text-gray-700 mb-1">Ano de Publicação</label>
            <input type="number" name="ano" id="ano" value="{{ old('ano') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Digite o ano (ex: 2026)" min="1500" max="{{ date('Y') }}">
        </div>

        <!-- Categoria -->
        <div>
            <label for="categoria" class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
            <input type="text" name="categoria" id="categoria" value="{{ old('categoria') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Digite a categoria do livro">
        </div>

        <!-- Quantidade -->
        <div>
            <label for="quantidade" class="block text-sm font-medium text-gray-700 mb-1">Quantidade</label>
            <input type="number" name="quantidade" id="quantidade" value="{{ old('quantidade') ?? 1 }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" min="0">
        </div>

        <!-- Botões -->
        <div class="flex justify-end">
            <a href="{{ route('livros.index') }}" class="mr-3 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">Cancelar</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow-md transition">Cadastrar Livro</button>
        </div>
    </form>
</div>
@endsection