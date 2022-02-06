<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 * @property string $link
 * @property string $short_link
 *
 */
class Link extends Model
{
    const DOMAIN = 'http://127.0.0.1:8000/api/show/';

    protected $fillable = ['link', 'short_ink'];

    /**
     * @return HasMany
     */
    public function statistics()
    {
        return $this->hasMany(Statistic::class);
    }

    public static function boot() {
        parent::boot();

        static::creating(function (Link $item) {
            $item->short_link = self::generateShortLink();
        });
    }

    private static function generateShortLink()
    {
        $shortLink = rand(1000000000, 9999999999);

        return !Link::where('short_link', $shortLink)->exists() ? $shortLink : self::generateShortLink();
    }
}
