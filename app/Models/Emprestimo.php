<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprestimo extends Model
{
    use HasFactory;

    protected $fillable = [
        'livro_id',
        'nome',
        'data_emprestimo',
        'data_devolucao',
        'status',
    ];

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }

    protected $casts = [
        'data_emprestimo' => 'date',
        'data_devolucao' => 'date',
    ];
}
