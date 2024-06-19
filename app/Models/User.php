<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
/**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin'; // Assuming 'role' is 'admin' for admin users
    }

/**
     * Check if the user is an employee.
     *
     * @return bool
     */
       public function isEmployee()
{
    return $this->role === 'employee'; // Assuming 'role' is 'employee' for employee users
}
 /**
     * Get the email of the employee associated with this user.
     *
     * @return string|null
     */
    public function employeeEmail()
    {
        if ($this->isEmployee()) {
            return $this->email;
        }

        return null;
    }

    /**
     * Get the password of the employee associated with this user.
     *
     * @return string|null
     */
    public function employeePassword()
    {
        if ($this->isEmployee()) {
            return $this->password;
        }

        return null;
    }
    public function employee()
    {
        return $this->hasOne(Employee::class, 'email', 'email');
    }
}    