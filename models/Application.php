<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "yii2_application".
 *
 * @property int $id
 * @property int $id_user
 * @property string $subject
 * @property string $message
 * @property string $file
 * @property int $status
 * @property int $created_at
 */
class Application extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yii2_application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'subject', 'message', 'file', 'created_at'], 'required'],
            [['id_user', 'status', 'created_at'], 'integer'],
            [['message'], 'string'],
            [['subject', 'file'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'subject' => 'Subject',
            'message' => 'Message',
            'file' => 'File',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
