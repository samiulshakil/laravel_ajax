<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const VALIDATION_RULES = [
        'role_id' => ['required', 'integer'],
        'name' => ['required', 'string'],
        'email' => ['required', 'email', 'unique:users,email'],
        'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg,webp'],
        'district_id' => ['required', 'integer'],
        'upazila_id' => ['required', 'integer'],
        'address' => ['required', 'string'],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id', 'name', 'email', 'avatar', 'district_id', 'upazila_id',
        'address', 'password', 'status'
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

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
     
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function district()
    {
        return $this->belongsTo(Location::class, 'district_id', 'id');
    }
    public function upazila()
    {
        return $this->belongsTo(Location::class, 'upazila_id', 'id');
    } 

    private $order = array('users.id' => 'desc');
    private $column_order;

    private $name;
    private $email;
    private $role_id;
    private $district_id;
    private $upazila_id;
    private $status;

    public function setName($name)
    {
        $this->name = $name;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setRoleID($role_id)
    {
        $this->role_id = $role_id;
    }
    public function setDistrictID($district_id)
    {
        $this->district_id = $district_id;
    }
    public function setUpazilaID($upazila_id)
    {
        $this->upazila_id = $upazila_id;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }

    private $orderValue;
    private $dirValue;
    private $startValue;
    private $lengthValue;

    public function setOrderValue($orderValue)
    {
        $this->orderValue = $orderValue;
    }
    public function setDirValue($dirValue)
    {
        $this->dirValue = $dirValue;
    }
    public function setStartValue($startValue)
    {
        $this->startValue = $startValue;
    }
    public function setLengthValue($lengthValue)
    {
        $this->lengthValue = $lengthValue;
    }

    private function get_datatable_query()
    {
        $this->column_order = ['', 'users.id', '', 'users.name', 'users.role_id', 'users.email',
        'users.district_id', 'users.upazila_id', 'users.email_verified_at', 'users.status', ''];

        $query = self::with(['role:id,role_name', 'district:id,location_name', 'upazila:id,location_name']);
    

        /* *Search Data **
        ******************/
       if (!empty($this->name)) {
           $query->where('users.name', 'like', '%' . $this->name . '%');
       }
       if (!empty($this->email)) {
           $query->where('users.email', 'like', '%' . $this->email . '%');
       }
       if (!empty($this->role_id)) {
           $query->where('users.role_id', $this->role_id);
       }
       if (!empty($this->district_id)) {
           $query->where('users.district_id', $this->district_id);
       }
       if (!empty($this->upazila_id)) {
           $query->where('users.upazila_id', $this->upazila_id);
       }
       if (!empty($this->status)) {
           $query->where('users.status', $this->status);
       }
       if (isset($this->orderValue) && isset($this->dirValue)) {
           $query->orderBy($this->column_order[$this->orderValue], $this->dirValue);
       } else if (isset($this->order)) {
           $query->orderBy(key($this->order), $this->order[key($this->order)]);
       }
        return $query;
    }

    public function getList()
    {
        $query = $this->get_datatable_query();
        if ($this->lengthValue != -1) {
            $query->offset($this->startValue)->limit($this->lengthValue);
        }
        return $query->get();
    }

    public function count_filtered()
    {
        $query = $this->get_datatable_query();
        return $query->get()->count();
    }

    public function count_all()
    {
        return self::toBase()->get()->count();
    }
  
}
