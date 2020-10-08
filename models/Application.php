<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "yii2_application".
 *
 * @property int $id
 * @property int $user_id
 * @property string $subject
 * @property string $message
 * @property string $file
 * @property int $status
 * @property int $created_at
 */
class Application extends \yii\db\ActiveRecord
{
    
    
    // Статуc
    const STATUS_NOT_VIEWED = 0;
    const STATUS_VIEWED = 1;
    
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
            [['user_id', 'subject', 'message', 'created_at'], 'required'],
            [['user_id', 'status', 'created_at'], 'integer'],
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
            'user_id' => 'Id User',
            'subject' => 'Subject',
            'message' => 'Message',
            'file' => 'File',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
