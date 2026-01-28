<?php

declare(strict_types=1);

namespace JCIT\softDelete\traits;

use JCIT\softDelete\interfaces\SoftDeleteActiveRecordInterface;

trait SoftDeleteActiveQueryTrait
{
    public function notDeleted(string|null $alias = null): static
    {
        /** @var SoftDeleteActiveRecordInterface $model */
        $model = new $this->modelClass();
        $column = is_null($alias)
            ? $model->deletedAtTableColumn()
            : $alias . '.' . $model->deletedAtAttribute();
        return $this->andWhere([$column => null]);
    }

    public function deleted(string|null $alias = null): static
    {
        /** @var SoftDeleteActiveRecordInterface $model */
        $model = new $this->modelClass();
        $column = is_null($alias)
            ? $model->deletedAtTableColumn()
            : $alias . '.' . $model->deletedAtAttribute();
        return $this->andWhere(['not', [$column => null]]);
    }
}
