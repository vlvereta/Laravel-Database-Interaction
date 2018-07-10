<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /**
     * Table associated with the model.
     *
     * @var string
     */
    protected $table = 'currency';

    /**
     * Defines the need for time stamps for the model.
     *
     * @var bool
     */
    public $timestamps = false;

    public function money() {
        return $this->hasone('Money');
    }
}
