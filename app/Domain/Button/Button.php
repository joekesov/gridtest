<?php


namespace App\Domain\Button;

use App\Application\Model\BaseModel;
use App\Domain\Color\Color;


class Button extends BaseModel
{
    protected $table = 'button';

    protected $fillable = [
        'title',
        'link',
        'color_id',
    ];

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
}
