<?php
namespace app\models;
use Yii;
use yii\base\Model;
class UploadImage  extends Model
{
    private const ACTION_UPDATE = 'update';
    private const DEFAULT_IMAGE_NAME = 'no-image.png';
    public $image;
    private $action;
    private $userModel;
    private $imageHashName = null;
    public function rules()
    {
        return [
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    public function __construct()
    {
        $this->action = Yii::$app->controller->action->id;
        parent::__construct();
    }
    public function setImage($UploadFile)
    {
        $this->image = $UploadFile;
    }

    public function upload($userInfo)
    {
        if (!$this->validate()) {
            return false;
        }

        $this->userModel = $userInfo;
        
        if ($this->image === null) {
            if ($this->action == self::ACTION_UPDATE) {
                return true;
            }
            return $this->saveDefaultImage();
        }
        
        
        $this->generateImageName();
        return $this->saveImage();
    }



    private function saveDefaultImage()
    {
        $this->userModel->avatar = self::DEFAULT_IMAGE_NAME;
        return $this->userModel->save();
    }
    private function saveImage()
    {
        $this->image->saveAs($this->getImagePath());
        $this->userModel->avatar = $this->getImageName();
        return $this->userModel->save();
    }
   
    private function getImagePath()
    {
        return '@app/web/uploads/' . $this->getImageName();
    }
    private function getImageName()
    {
        return $this->imageHashName;
    }
    private function generateImageName()
    {   
        $name = $this->userModel->pin . '_' . Yii::$app->security->generateRandomString(20);
        $this->imageHashName =  $name . '.' . $this->image->extension;
    }
}
