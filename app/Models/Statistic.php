<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $device
 * @property bool $mobile
 * @property string $browser
 * @property string $ip
 */
class Statistic extends Model
{
    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
