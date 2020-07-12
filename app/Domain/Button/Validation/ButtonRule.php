<?php


namespace App\Domain\Button\Validation;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Domain\Button\Enum\ButtonEnum;

class ButtonRule implements Rule
{


    public function passes($attribute, $value)
    {
        $buttons = DB::table('button')->count();

        return ButtonEnum::MAX_ALLOWED_BUTTONS > $buttons;
    }

    public function message()
    {
        return sprintf('You can not add more than %d buttons', ButtonEnum::MAX_ALLOWED_BUTTONS);
    }
}
