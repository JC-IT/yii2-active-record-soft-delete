<?php

declare(strict_types=1);

namespace JCIT\softDelete\traits;

use JCIT\softDelete\interfaces\SoftDeleteActiveQueryInterface;
use JCIT\softDelete\queries\SoftDeleteActiveQuery;
use yii\db\StaleObjectException;

/**
 * @property-read bool $isDeleted
 */
trait SoftDeleteTrait
{
    abstract public function afterDelete();

    abstract public function beforeDelete();

    /**
     * This function must return the attribute that is being set when the model is deleted.
     */
    public function deletedAtAttribute(): string
    {
        return 'deleted_at';
    }

    public function deletedAtTableColumn(): string
    {
        return static::tableName() . ".[[{$this->deletedAtAttribute()}]]";
    }

    protected function deleteInternal(): int|false
    {
        if (!$this->beforeDelete()) {
            return false;
        }

        // we do not check the return value of deleteAll() because it's possible
        // the record is already deleted in the database and thus the method will return 0
        $condition = $this->getOldPrimaryKey(true);
        $lock = $this->optimisticLock();
        if ($lock !== null) {
            $condition[$lock] = $this->$lock;
        }

        //We do nothing, it should be handled by the TimestampBehavior
        $result = $this->updateAttributes([$this->deletedAtAttribute()]);

        if ($lock !== null && !$result) {
            throw new StaleObjectException('The object being deleted is outdated.');
        }
        $this->setOldAttributes(null);
        $this->afterDelete();

        return $result;
    }

    public static function find(): SoftDeleteActiveQueryInterface
    {
        return \Yii::createObject(SoftDeleteActiveQuery::class, [get_called_class()]);
    }

    public function getIsDeleted(): bool
    {
        return $this->{$this->deletedAtAttribute()} !== null;
    }

    abstract public function getOldPrimaryKey($asArray = false);

    abstract public function optimisticLock();

    abstract public function setOldAttributes($values);
}
