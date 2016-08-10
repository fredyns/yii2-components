<?php

namespace fredyns\components\traits;

/**
 * Add blaming for model
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property User $deletedBy
 * @property User $createdByProfile
 * @property User $updatedByProfile
 * @property User $deletedByProfile
 *
 * @author fredy
 */
trait ModelBlame
{

    public function modelUser()
    {
        $options = [
            'dektrium\user\models\User',
            'app\models\User',
            'frontend\models\User',
            'backend\models\User',
            'common\models\User',
        ];

        foreach ($options as $value)
        {
            if (class_exists($value))
            {
                return $value;
            }
        }

        return 'app\models\User';
    }

    public function modelProfile()
    {
        $options = [
            'dektrium\user\models\Profile',
            'app\models\Profile',
            'frontend\models\Profile',
            'backend\models\Profile',
            'common\models\Profile',
        ];

        foreach ($options as $value)
        {
            if (class_exists($value))
            {
                return $value;
            }
        }

        return 'app\models\User';
    }
    /* ======================== global blaming ======================== */

    /**
     * Getting blamable user model based on particular attribute
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlamedUser($attribute)
    {
        if ($this->hasAttribute($attribute))
        {
            return $this->hasOne($this->modelUser(), ['id' => $attribute]);
        }

        return NULL;
    }

    /**
     * Getting blamable profile model based on particular attribute
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlamedProfile($attribute)
    {
        if ($this->hasAttribute($attribute))
        {
            return $this->hasOne($this->modelProfile(), ['user_id' => $attribute]);
        }

        return NULL;
    }
    /* ======================== model blaming ======================== */

    /**
     * Getting blamable user model based for creating model
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->getBlamedUser('createdBy_id');
    }

    /**
     * Getting blamable user model based for updating model
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->getBlamedUser('updatedBy_id');
    }

    /**
     * Getting blamable user model based for deleting model
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedBy()
    {
        return $this->getBlamedUser('deletedBy_id');
    }

    /**
     * Getting blamable profile model based for creating model
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedByProfile()
    {
        return $this->getBlamedProfile('createdBy_id');
    }

    /**
     * Getting blamable profile model based for updating model
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedByProfile()
    {
        return $this->getBlamedProfile('updatedBy_id');
    }

    /**
     * Getting blamable profile model based for deleting model
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedByProfile()
    {
        return $this->getBlamedProfile('deletedBy_id');
    }

}