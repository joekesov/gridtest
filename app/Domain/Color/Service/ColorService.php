<?php


namespace App\Domain\Color\Service;

use App\Application\Model\Service\AbstractModelService;
use App\Domain\Color\ColorRepositoryInterface;

class ColorService extends AbstractModelService
{
    public function repository()
    {
        return ColorRepositoryInterface::class;
    }
}
