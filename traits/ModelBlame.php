<?php

namespace fredyns\components\traits;

/**
 * Add blaming for model
 *
 * @property app\models\User $createdByUser
 * @property app\models\User $updatedByUser
 * @property app\models\User $deletedByUser
 * @property app\models\Profile $createdByProfile
 * @property app\models\Profile $updatedByProfile
 * @property app\models\Profile $deletedByProfile
 *
 * @author fredy
 */
trait ModelBlame
{

    public function modelUser()
    {
        $alternatives = [
            'app'      => 'app\models\User',
            'dektrium' => 'dektrium\user\models\User',
            'frontend' => 'frontend\models\User',
            'backend'  => 'backend\models\User',
            'common'   => 'common\models\User',
        ];

        foreach ($alternatives as $value)
        {
            if (class_exists($value))
            {
                return $value;
            }
        }

        return null;
    }

    public function modelProfile()
    {
        $alternatives = [
            'app'      => 'app\models\Profile',
            'dektrium' => 'dektrium\user\models\Profile',
            'frontend' => 'frontend\models\Profile',
            'backend'  => 'backend\models\Profile',
            'common'   => 'common\models\Profile',
        ];

        foreach ($alternatives as $value)
        {
            if (class_exists($value))
            {
                return $value;
            }
        }

        return null;
    }
    /* ======================== global blaming ======================== */

    /**
     * Getting blamable user model based on particular attribute
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlamedUser($attribute)
    {
        $modelName = $this->modelUser();

        if ($this->hasAttribute($attribute) && $modelName)
        {
            return $this->hasOne($modelName, ['id' => $attribute]);
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
        $modelName = $this->modelProfile();

        if ($this->hasAttribute($attribute) && $modelName)
        {
            return $this->hasOne($modelName, ['user_id' => $attribute]);
        }

        return NULL;
    }
    /* ======================== model blaming ======================== */

    /**
     * Getting blamable Profile model based for creating model
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedByProfile()
    {
        return $this->getBlamedProfile('created_by');
    }

    /**
     * Getting blamable Profile model based for updating model
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedByProfile()
    {
        return $this->getBlamedProfile('updated_by');
    }

    /**
     * Getting blamable Profile model based for deleting model
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedByProfile()
    {
        return $this->getBlamedProfile('deleted_by');
    }

    /**
     * Getting blamable User model based for creating model
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedByUser()
    {
        return $this->getBlamedUser('created_by');
    }

    /**
     * Getting blamable User model based for updating model
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedByUser()
    {
        return $this->getBlamedUser('updated_by');
    }

    /**
     * Getting blamable User model based for deleting model
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedByUser()
    {
        return $this->getBlamedUser('deleted_by');
    }

}