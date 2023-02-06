<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $name
 * @property integer $type
 *
 * @property Repo[] $repos
 */
class User extends \yii\db\ActiveRecord
{
    const TYPE_GITHUB = 1;
    const TYPE_GITLAB = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Пользователь',
            'type' => 'Тип',
        ];
    }

    /**
     * @return string[]
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_GITHUB => 'github',
            self::TYPE_GITLAB => 'gitlab',
        ];
    }

    /**
     * Gets query for [[Repos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRepos()
    {
        return $this->hasMany(Repo::class, ['user_id' => 'id']);
    }
}
