<?php

declare(strict_types=1);

namespace JCIT\softDelete\queries;

use JCIT\softDelete\interfaces\SoftDeleteActiveQueryInterface;
use JCIT\softDelete\traits\SoftDeleteActiveQueryTrait;
use yii\db\ActiveQuery;

class SoftDeleteActiveQuery extends ActiveQuery implements SoftDeleteActiveQueryInterface
{
    use SoftDeleteActiveQueryTrait;
}
