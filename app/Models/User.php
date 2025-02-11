<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'userid',
        'name',
        'password',
        'role_id'
    ];

    /**
     * Relasi ke model Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id'); // ✅ Perbaikan foreign key
    }

    /**
     * Mengecek apakah user memiliki izin tertentu
     */
    public function hasPermission($permission)
    {
        $role = $this->role;

        if (!$role) {
            return false;
        }

        // Daftar izin berdasarkan role_id
        $permissions = [
            0 => ['add_users', 'edit_users', 'delete_users', 'view_users'], // Admin
            1 => ['view_users'], // Kantor Gereja
            2 => ['view_users'], // PHMJ
            3 => ['view_users'], // Majelis
            4 => ['add_jemaat', 'view_jemaat'], // Koordinator Sektor
            5 => ['add_jemaat', 'edit_jemaat', 'delete_jemaat', 'view_jemaat'], // Pengurus Pelkat
        ];

        return in_array($permission, $permissions[$role->role_id] ?? []); // ✅ Perbaikan
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
