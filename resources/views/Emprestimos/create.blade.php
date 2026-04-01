@extends('layouts.app') {{-- assume que seu app.blade.php está em resources/views/layouts/app.blade.php --}}

@section('title', 'Cadastrar Novo Livro')

@section('content')

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold text-gray-700 mb-6">Novo Empréstimo</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('emprestimos.store') }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 space-y-6">
        @csrf

        <!-- Seleção de Livro -->
        <div>
            <label for="livro_id" class="block text-sm font-medium text-gray-700 mb-1">Livro</label>
            <select name="livro_id" id="livro_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Selecione um livro disponível</option>
                @foreach($livros as $livro)
                    <option value="{{ $livro->id }}">{{ $livro->titulo }} ({{ $livro->quantidade }} disponíveis)</option>
                @endforeach
            </select>
        </div>

        <!-- Nome do Leitor -->
        <div>
            <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome do Leitor</label>
            <input type="text" name="nome" id="nome" value="{{ old('nome') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Digite o nome do leitor">
        </div>

        <!-- Data de Empréstimo -->
        <div>
            <label for="data_emprestimo" class="block text-sm font-medium text-gray-700 mb-1">Data de Empréstimo</label>
            <input type="date" name="data_emprestimo" id="data_emprestimo" value="{{ old('data_emprestimo') ?? date('Y-m-d') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Data de Devolução -->
        <div>
            <label for="data_devolucao" class="block text-sm font-medium text-gray-700 mb-1">Data de Devolução (opcional)</label>
            <input type="date" name="data_devolucao" id="data_devolucao" value="{{ old('data_devolucao') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Botão -->
        <div class="flex justify-end">
            <a href="{{ route('emprestimos.index') }}" class="mr-3 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">Cancelar</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow-md transition">Registrar Empréstimo</button>
        </div>
    </form>
</div>
@endsection