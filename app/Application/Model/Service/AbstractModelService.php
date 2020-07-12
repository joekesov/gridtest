<?php


namespace App\Application\Model\Service;

use Illuminate\Container\Container as Application;
use App\Application\Database\Repository\Eloquent\BaseRepository;
use App\Application\Model\Exception\ModelServiceException;

abstract class AbstractModelService
{
    /**
     * @var Application|null
     */
    protected $app = null;

    protected $repository = null;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeRepository();
        $this->prepare();
    }

    abstract public function repository();

    public function prepare()
    {

    }

    public function makeRepository()
    {
        $repository = $this->app->make($this->repository());

        if (!$repository instanceof BaseRepository) {
            throw new ModelServiceException("Class ". $this->repository() ." must be an instance of ". BaseRepository::class);
        }

        return $this->repository = $repository;
    }

    public function getById($nId)
    {
        return $this->repository
            ->find($nId);
    }

    public function getAll()
    {
        return $this->repository
            ->all();
    }

    public function delete($nId)
    {
        return $this->repository->delete($nId);
    }

    public function create(array $arData)
    {
        return $this->repository->create($arData);
    }
}
