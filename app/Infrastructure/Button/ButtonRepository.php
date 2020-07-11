<?php


namespace App\Infrastructure\Button;

use App\Application\Database\Repository\Eloquent\BaseRepository;
use App\Domain\Button\Button;
use App\Domain\Button\ButtonRepositoryInterface;

class ButtonRepository extends BaseRepository implements ButtonRepositoryInterface
{
    public function model()
    {
        return Button::class;
    }
}
