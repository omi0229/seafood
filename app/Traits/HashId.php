<?php
namespace App\Traits;

use Balping\HashSlug\HasHashSlug;

trait HashId
{
    use HasHashSlug;

    protected static $minSlugLength = 10;

    public function getHashIdAttribute($value)
    {
        return $this->slug();
    }
}