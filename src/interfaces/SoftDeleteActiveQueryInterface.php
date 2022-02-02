<?php

declare(strict_types=1);

namespace JCIT\softDelete\interfaces;

use yii\db\ActiveQueryInterface;

interface SoftDeleteActiveQueryInterface extends ActiveQueryInterface
{
    public function deleted(string $alias = null): static;
    public function notDeleted(string $alias = null): static;
}
