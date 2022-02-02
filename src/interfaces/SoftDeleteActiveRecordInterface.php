<?php

declare(strict_types=1);

namespace JCIT\softDelete\interfaces;

use yii\db\ActiveRecordInterface;

interface SoftDeleteActiveRecordInterface extends ActiveRecordInterface
{
    public function deletedAtAttribute(): string;
    public function deletedAtTableColumn(): string;
}
