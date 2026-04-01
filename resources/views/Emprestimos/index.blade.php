@extends('layouts.app') {{-- assume que seu app.blade.php está em resources/views/layouts/app.blade.php --}}

@section('title', 'Cadastrar Novo Livro')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-700">Lista de Empréstimos</h1>
        <a href="{{ route('emprestimos.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow-md transition">
            + Novo Empréstimo
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-400 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Livro</th>
                    <th class="px-6 py-4 font-semibold">Leitor</th>
                    <th class="px-6 py-4 font-semibold">Data de Empréstimo</th>
                    <th class="px-6 py-4 font-semibold">Data de Devolução</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($emprestimos as $emprestimo)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">{{ $emprestimo->livro->titulo ?? 'Livro removido' }}</td>
                    <td class="px-6 py-4">{{ $emprestimo->nome }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($emprestimo->data_emprestimo)->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        @if($emprestimo->data_devolucao)
                            {{ \Carbon\Carbon::parse($emprestimo->data_devolucao)->format('d/m/Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($emprestimo->status === 'emprestado')
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-600 uppercase">Emprestado</span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-600 uppercase">Devolvido</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('emprestimos.show', $emprestimo->id) }}" class="text-gray-400 hover:text-indigo-600 transition">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </a>
                        <a href="{{ route('emprestimos.edit', $emprestimo->id) }}" class="text-gray-400 hover:text-yellow-500 transition">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </a>
                        <form action="{{ route('emprestimos.destroy', $emprestimo->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este empréstimo?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-gray-400 hover:text-red-600 transition">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Nenhum empréstimo registrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection