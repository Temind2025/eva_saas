<?php

namespace Modules\Promotion\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Promotion\Database\factories\UserCouponRedeemFactory;

class UserCouponRedeem extends Model
{
    use HasFactory;

    protected $table = 'user_coupon_redeem';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['user_id', 'coupon_code', 'discount', 'coupon_id', 'booking_id'];

   

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_code');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
