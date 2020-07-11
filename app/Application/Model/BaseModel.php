<?php


namespace App\Application\Model;

use Illuminate\Database\Eloquent\Model;
use App\Application\Model\Contract\ModelInterface;

abstract class BaseModel extends Model implements ModelInterface
{

}
