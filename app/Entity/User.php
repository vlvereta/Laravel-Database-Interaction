<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * Table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * Defines the need for time stamps for the model.
     *
     * @var bool
     */
    public $timestamps = false;

    public function wallet() {
        return $this->hasOne('Wallet');
    }
}
