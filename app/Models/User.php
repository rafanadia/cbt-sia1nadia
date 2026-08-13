<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Override;

#[Fillable([
    'name', 
    'email', 
    'password', 
    'username', 
    'phone', 
    'is_staff', 
    'photo_path',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // Autorisasi user agar dapat login ke Filament Panel
    #[Override]
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_staff;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_staff' => 'boolean',
        ];
    }

    // user avatar url
    public function getFilamentAvatarUrl(): ?string
    {
        // cek apakah user punya foto tersimpan
        if ($this->photo_path && Storage::disk('public')->exists($this->photo_path)) {
            return Storage::url($this->photo_path); 
        }
        
        return null;
    }

    // Hapus foto lama saat foto diupdate
    protected static function booted(): void
    {
        static::updating(function (User $user) {
            if ($user->isDirty('photo_path')) {
                $oldPhoto = $user->getOriginal('photo_path');

                if ($oldPhoto && Storage::disk('public')->exists($oldPhoto)) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }
        });
    }
}