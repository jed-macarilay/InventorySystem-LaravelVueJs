<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Notification extends Model
{
    protected $fillable = [
        'data',
    ];

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('l jS F Y, h:i A');
    }
}
