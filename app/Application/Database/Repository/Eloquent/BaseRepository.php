<?php


namespace App\Application\Database\Repository\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository as Repository;
use App\Application\Database\Repository\Contracts\RepositoryInterface;
use App\Application\Database\Repository\Contracts\RepositoryCriteriaInterface;

abstract class BaseRepository extends Repository implements RepositoryInterface, RepositoryCriteriaInterface
{

}
