<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Shared\SimontokClassTrait;
use DateTime;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @mixin \Eloquent
 * @method int getId()
 * @method void setId($id)
 * @method string getName()
 * @method void setName($name)
 * @method string getEmail()
 * @method void setEmail($email)
 * @method string getPassword()
 * @method void setPassword($password)
 * @method string getRememberToken()
 * @method void setRememberToken($remember_token = null)
 * @method bool isSoftDeleted()
 * @method void setSoftDeleted($soft_deleted = false)
 * @method int getCreatedAt()
 * @method void setCreatedAt($created_at = null)
 * @method int getUpdatedAt()
 * @method void setUpdatedAt($updated_at = null)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SimontokClassTrait;

    protected $table = 'users';

    public $timestamps = false;

    public function persist(): void
    {
        DB::table($this->table)->upsert(
            [
                'id' => $this->getId(),
                'name' => $this->getName(),
                'email' => $this->getEmail(),
                'password' => $this->getPassword(),
                'remember_token' => $this->getRememberToken(),
                'soft_deleted' => $this->isSoftDeleted(),
                'created_at' => $this->getCreatedAt(),
                'updated_at' => $this->getUpdatedAt() ?? (new DateTime())->getTimestamp(),
            ],
            'id'
        );
    }

    public function __construct()
    {
        $this->setSoftDeleted(false);
        $this->setRememberToken(null);
        $this->setCreatedAt((new DateTime())->getTimestamp());
        parent::__construct();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public const ATTRIBUTES = [
        'id' => 'int',
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'remember_token' => 'string|null',
        'soft_deleted' => 'bool|false',
        'created_at' => 'int|null',
        'updated_at' => 'int|null',
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
}
