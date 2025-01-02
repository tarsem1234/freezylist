<?php

namespace App\Models\Access\User;

use App\Models\Access\User\Traits\Attribute\UserAttribute;
use App\Models\Access\User\Traits\Relationship\UserRelationship;
use App\Models\Access\User\Traits\Scope\UserScope;
use App\Models\Access\User\Traits\UserAccess;
use App\Models\Access\User\Traits\UserSendPasswordReset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User.
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable,
        SoftDeletes,
        UserAccess,
        UserAttribute,
        UserRelationship,
        UserScope,
        UserSendPasswordReset;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'status',
        'confirmation_code', 'confirmed'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @var array
     */

    /**
     * The dynamic attributes from mutators that should be returned with the user object.
     *
     * @var array
     */
    protected $appends = ['full_name', 'name', 'rating'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('access.users_table');
    }

    public function business_profile(): HasOne
    {
        return $this->hasOne(\App\Models\BusinessProfile::class);
    }

    public function user_profile(): HasOne
    {
        return $this->hasOne(\App\Models\UserProfile::class);
    }

    public function signature(): HasOne
    {
        return $this->hasOne(\App\Models\Signature::class);
    }

    public function signatures(): HasMany
    {
        return $this->hasMany(\App\Models\Signature::class);
    }

    public function rentSignature(): HasOne
    {
        return $this->hasOne(\App\Models\RentSignature::class);
    }

    public function forums(): HasMany
    {
        return $this->hasMany(\App\Models\Forum::class);
    }

    public function offer(): HasOne
    {
        return $this->hasOne('App\Models\Offer');
    }

    public function lerning_points(): HasMany
    {
        return $this->hasMany(\App\Models\Backend\UserLearningPoint::class);
    }

    public function network(): HasOne
    {
        return $this->hasOne(\App\Models\Network::class);
    }

    public function signer(): HasOne
    {
        return $this->hasOne(\App\Models\Signer::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(\App\Models\Message::class, 'to_user_id');
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(\App\Models\UserLearningSession::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(\App\Models\ProfileRating::class);
    }

    public function getRatingAttribute()
    {
        return ceil($this->ratings->average('rating'));
    }

    public function subscribeServices(): HasMany
    {
        return $this->hasMany(\App\Models\SubscribeServices::class);
    }

    public function userConditional(): HasMany
    {
        return $this->hasMany(\App\Models\UsersConditionalData::class);
    }
}
