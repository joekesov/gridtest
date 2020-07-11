<?php


namespace App\Domain\Color;

use App\Application\Model\BaseModel;
use App\Domain\Button\Button;

class Color extends BaseModel
{
    protected $table = 'color';

    public function button()
    {
        return $this->hasMany(Button::class, 'color_id');
    }
}
