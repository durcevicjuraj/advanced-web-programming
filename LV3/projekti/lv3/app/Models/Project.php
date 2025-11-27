<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    protected $fillable = [
        'naziv_projekta',
        'opis_projekta',
        'cijena_projekta',
        'obavljeni_poslovi',
        'datum_pocetka',
        'datum_zavrsetka',
        'user_id'
    ];

    // Voditelj projekta
    public function voditelj(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Članovi tima
    public function clanovi(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_user');
    }
}