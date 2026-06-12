<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telefone',
        'quem_indicou',
        'role',
        'data_pagamento',
        'valor',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'data_pagamento' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Verifica se o usuário é administrador.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'administrador';
    }

    /**
     * Relacionamento: Um usuário tem muitos palpites.
     */
    public function palpites()
    {
        return $this->hasMany(\App\Models\Palpite::class);
    }

    /**
     * Relacionamento: Um usuário tem um palpite de chute de ouro.
     */
    public function chuteDeOuro()
    {
        return $this->hasOne(\App\Models\ChuteDeOuro::class);
    }

    public function getAvatarAttribute($value)
    {
        $timestamp = $this->updated_at?->timestamp ?? time();
        return url('/avatar/' . $this->id . '.svg?t=' . $timestamp);
    }

    /**
     * Cacheia o avatar externo localmente no disco público.
     */
    public function downloadAndCacheAvatar(): bool
    {
        $avatarUrl = $this->getRawOriginal('avatar');
        if (empty($avatarUrl)) {
            return false;
        }

        if (str_contains($avatarUrl, '/storage/avatars/')) {
            return false;
        }

        if (!filter_var($avatarUrl, FILTER_VALIDATE_URL) || !str_starts_with($avatarUrl, 'http')) {
            return false;
        }

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(10)->get($avatarUrl);
            if ($response->successful()) {
                $content = $response->body();

                if (!\Illuminate\Support\Facades\Storage::disk('public')->exists('avatars')) {
                    \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory('avatars');
                }

                $fileName = 'avatars/' . $this->id . '.svg';
                \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $content);
                return true;
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Erro ao cachear avatar do usuário {$this->id}: " . $e->getMessage());
        }

        return false;
    }
}
