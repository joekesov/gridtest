<?php


namespace App\Infrastructure\Color;

use App\Application\Database\Repository\Eloquent\BaseRepository;
use App\Domain\Color\Color;
use App\Domain\Color\ColorRepositoryInterface;

class ColorRepository extends BaseRepository implements ColorRepositoryInterface
{
    public function model()
    {
        return Color::class;
    }
}
