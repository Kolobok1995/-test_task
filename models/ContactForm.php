<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $subject;
    public $body;
    public $imageFile;
    
    /**
     *
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true],
            [['subject', 'body'], 'required']
        ];
    }

    public function contact()
    {
        if ($this->validate()) {
            $application = new Application();
            $application->user_id = Yii::$app->getUser()->identity->id;
            $application->subject = $this->subject;
            $application->message = $this->body;
            $application->status = Application::STATUS_NOT_VIEWED;
            $application->created_at = time();
            
           
            $filePath = $this->upload();
            if($filePath != false){
                $application->file = $filePath;                
            }

            if ($application->save()) {
                return true;
            }
        }
        return false;
    }
    
    public function upload()
    {
        if(empty($this->imageFile) || !isset($this->imageFile))
            return false;
            
        $name = time()  . '.' . $this->imageFile->extension;
        if ($this->validate()) {
            $path = Yii::getAlias('@webroot'). '/' . 'files' . '/' ;
            $this->imageFile->saveAs($path . $name);
            return $path . $name;
            
        } else {
            return false;
        }
    }
}
