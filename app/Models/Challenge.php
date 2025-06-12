<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    /**
     * Attributs pouvant être assignés en masse lors de la création ou mise à jour.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titre',
        'contenu',
    ];
}