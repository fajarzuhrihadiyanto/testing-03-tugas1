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
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property int $soft_deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSoftDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method int getId()
 * @method void setId(int $id)
 * @method string getName()
 * @method void setName(string $name)
 * @method string getEmail()
 * @method void setEmail(string $email)
 * @method string getPassword()
 * @method void setPassword(string $password)
 * @method string|null getRememberToken()
 * @method void setRememberToken(string $remember_token = null)
 * @method bool|false isSoftDeleted()
 * @method void setSoftDeleted(bool $soft_deleted = false)
 * @method DateTime|null getCreatedAt()
 * @method void setCreatedAt(DateTime $created_at = null)
 * @method DateTime|null getUpdatedAt()
 * @method void setUpdatedAt(DateTime $updated_at = null)
 * @method DateTime|null getEmailVerifiedAt()
 * @method void setEmailVerifiedAt(DateTime $email_verified_at = null)
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
                'created_at' => $this->getCreatedAt() ? $this->getCreatedAt()->getTimestamp() : null,
                'updated_at' => $this->getUpdatedAt() ? $this->getUpdatedAt()->getTimestamp() : (new DateTime())->getTimestamp(),
                'email_verified_at' => $this->getEmailVerifiedAt() ? $this->getEmailVerifiedAt()->getTimestamp() : null
            ],
            'id'
        );
    }

    /**
     * IMPORTANT!
     * karena di db pake timestamp integer (biar universal timezone)
     * jadi harus di cast ke DateTime biar sesuai dengan attribute bikinan kita
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'email_verified_at' => 'datetime'
    ];

    public function __construct()
    {
        $this->setSoftDeleted(false);
        $this->setRememberToken(null);
        $this->setCreatedAt(new DateTime());
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
        'created_at' => DateTime::class.'|null',
        'updated_at' => DateTime::class.'|null',
        'email_verified_at' => DateTime::class.'|null'
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
}
