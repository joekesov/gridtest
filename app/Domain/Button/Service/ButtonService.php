<?php


namespace App\Domain\Button\Service;

use App\Application\Model\Service\AbstractModelService;
use App\Domain\Button\ButtonRepositoryInterface;

class ButtonService extends AbstractModelService
{
    public function repository()
    {
        return ButtonRepositoryInterface::class;
    }

    public function update(int $id, array $parameters)
    {
        $model = $this->getById($id);
        $model->update($parameters);

        return $model;
    }
}
