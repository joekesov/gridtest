<?php


namespace App\Domain\Button;

use App\Application\Model\BaseModel;
use App\Domain\Color\Color;


class Button extends BaseModel
{
    protected $table = 'button';

    public function color()
    {
//        print_r('here'); exit;

        return $this->belongsTo(Color::class, 'color_id');
    }
}
