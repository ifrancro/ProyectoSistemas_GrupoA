<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;        // ← importante
use App\Models\Mesa;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'password',
        'mesa_id',
        'mesa_number',
        'circunscripcion_id',
        'rol',
        'cargo',
        'activo',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }

    // --- Helpers de rol/estado ---
    public function isAdmin(): bool
    {
        return $this->rol === 'admin';
    }

    public function isPresidenteTSE(): bool
    {
        return $this->rol === 'presidente_tse';
    }

    public function isActive(): bool
    {
        return (bool) $this->activo;
    }

    // --- Relaciones ---
    public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'mesa_id');
    }

    public function circunscripcion()
    {
        return $this->belongsTo(Circunscripcion::class, 'circunscripcion_id');
    }

    // --- Accessor para mesa_number ---
    public function getMesaNumberAttribute()
    {
        // Si ya tiene mesa_number asignado directamente, lo devuelve
        if (isset($this->attributes['mesa_number']) && $this->attributes['mesa_number'] !== null) {
            return $this->attributes['mesa_number'];
        }
        
        // Si tiene relación con mesa, obtiene el código de la mesa
        if ($this->mesa) {
            return $this->mesa->codigo ?? null;
        }
        
        // Si no tiene nada, devuelve null
        return null;
    }

    // --- Mutator para hashear password automáticamente ---
    public function setPasswordAttribute($value): void
    {
        if (filled($value)) {
            // Evita re-hashear si ya viene hasheado (por seguridad y seeds)
            $this->attributes['password'] = Hash::needsRehash($value)
                ? Hash::make($value)
                : $value;
        }
    }
}
