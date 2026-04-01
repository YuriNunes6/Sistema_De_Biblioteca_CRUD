@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-indigo-600 tracking-tight">Biblioteca</h1>
        </div>
        
        <nav class="flex-1 px-4 space-y-2">
            <a href="{{ route('dashboard') }}" class="flex items-center p-3 text-indigo-600 bg-indigo-50 rounded-xl font-semibold">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a11 11 0 003 3h10a1 1 0 001-1V10M9 21h6"></path>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('livros.index') }}" class="flex items-center p-3 text-gray-600 hover:bg-gray-100 rounded-xl transition">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20l9-5-9-5-9 5 9 5z"></path>
                </svg>
                Livros
            </a>
            <a href="{{ route('emprestimos.index') }}" class="flex items-center p-3 text-gray-600 hover:bg-gray-100 rounded-xl transition">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Empréstimos
            </a>
        </nav>

        <div class="p-4 border-t border-gray-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="flex items-center w-full p-3 text-gray-500 hover:text-red-600 transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Sair
                </button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <main class="flex-1 overflow-y-auto">

        <header class="bg-white border-b border-gray-200 sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-700">Olá, {{ Auth::user()->name ?? 'Usuário' }} 👋</h2>
                <div class="flex items-center gap-4">
                    <a href="{{ route('emprestimos.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-md">
                        + Novo Empréstimo
                    </a>
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Cards de resumo -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <p class="text-sm text-gray-500 font-medium">Total de Livros</p>
                    <p class="text-3xl font-bold mt-1">{{ $totalLivros }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm border-l-4 border-l-yellow-400">
                    <p class="text-sm text-gray-500 font-medium">Livros Emprestados</p>
                    <p class="text-3xl font-bold mt-1 text-yellow-600">{{ $livrosEmprestados }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm border-l-4 border-l-green-400">
                    <p class="text-sm text-gray-500 font-medium">Livros Disponíveis</p>
                    <p class="text-3xl font-bold mt-1 text-green-600">{{ $livrosDisponiveis }}</p>
                </div>
            </div>

            <!-- Últimos empréstimos -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-700">Últimos Empréstimos</h3>
                    <div class="flex gap-2">
                        <select class="text-sm border-gray-200 rounded-lg focus:ring-indigo-500">
                            <option>Filtrar por Status</option>
                            <option>Emprestado</option>
                            <option>Devolvido</option>
                        </select>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-400 text-xs uppercase tracking-wider">
                                <th class="px-6 py-4 font-semibold">Livro</th>
                                <th class="px-6 py-4 font-semibold">Leitor</th>
                                <th class="px-6 py-4 font-semibold">Data de Empréstimo</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 font-semibold text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @foreach($ultimosEmprestimos as $emprestimo)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">{{ $emprestimo->livro->titulo }}</td>
                                <td class="px-6 py-4">{{ $emprestimo->nome }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($emprestimo->data_emprestimo)->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">
                                    @if($emprestimo->status == 'emprestado')
                                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-600 uppercase">Emprestado</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-600 uppercase">Devolvido</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('emprestimos.show', $emprestimo->id) }}" class="text-indigo-600 hover:underline text-sm">Ver</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</div>
@endsection