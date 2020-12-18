<?php

namespace app\models;
use yii\web\UploadedFile;
use Yii;

/**
 * This is the model class for table "userInfo".
 *
 * @property int $pin
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $full_name
 * @property string|null $avatar
 * @property string|null $birth_day
 * @property string|null $place_birth
 * @property string|null $education
 * @property string|null $army
 * @property string|null $marital_status
 * @property string|null $phone
 * @property string|null $place_residence
 * @property string|null $residential_adress
 * @property string|null $pasport_number
 * @property string|null $pasport_issued
 * @property string|null $pasport_issued_date
 * @property int|null $salary
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $department
 *
 * @property User $pin0
 */
class UserInfo extends \yii\db\ActiveRecord
{
    public const DEFAULT_OPTION = 0;
    public const MARITAL_STATUS_SINGLE = 1;
    public const MARITAL_STATUS_MARRIED = 2;
    public const MARITAL_STATUS_MARRIED_GIRL = 3;
    public const MARITAL_STATUS_UNMARRIED = 4;

    public const EDUCATION_HIGH = 1;
    public const EDUCATION_SECONDARY = 2;
    public const EDUCATION_SCHOOL = 3;

    public const ARMY_SERVED = 1;
    public const ARMY_NOT_SERVED = 2;  

    public const DEPARTMENT_UPP = 1;
    public const DEPARTMENT_RECEPTION = 2;
    public const DEPARTMENT_EPOD = 3;
    public const DEPARTMENT_OKK = 4;
    public const DEPARTMENT_CONTROL = 5;
    public const DEPARTMENT_REPRESENT = 6;
    public const DEPARTMENT_IT = 7;
    public const DEPARTMENT_HR = 8;
    public const DEPARTMENT_OWNER = 9;
    

    private const DEFAULT_AVATAR = 'no-image.png';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userInfo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['department', 'required'],
            [['birth_day', 'pasport_issued_date', 'created_at', 'updated_at'], 'safe'],
            [['salary', 'department'], 'integer'],
            ['department', 'integer', 'min' => 1, 'max' => 8],
            [['first_name', 'middle_name', 'last_name', 'full_name', 'avatar', 'place_birth', 'education', 'army', 'marital_status', 'phone', 'place_residence', 'residential_adress', 'pasport_number', 'pasport_issued'], 'string', 'max' => 255],
            [['pin'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['pin' => 'pin']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pin' => 'Pin',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'full_name' => 'Full Name',
            'avatar' => 'Avatar',
            'birth_day' => 'Birth Day',
            'place_birth' => 'Place Birth',
            'education' => 'Education',
            'army' => 'Army',
            'marital_status' => 'Marital Status',
            'phone' => 'Phone',
            'place_residence' => 'Place Residence',
            'residential_adress' => 'Residential Adress',
            'pasport_number' => 'Pasport Number',
            'pasport_issued' => 'Pasport Issued',
            'pasport_issued_date' => 'Pasport Issued Date',
            'salary' => 'Salary',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'department' => 'Department',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->updated_at = date('Y-m-d H:i:s');
        $this->birth_day = $this->convertDateForMySql($this->birth_day);
        $this->pasport_issued_date = $this->convertDateForMySql($this->pasport_issued_date);
        $this->full_name = $this->generateFullname($this);
        return true;
    }

    public function convertDateForMySql($date)
    {
        if (!$date) {
            return null;
        }
        $timestamp = strtotime($date);
        return date('Y-m-d', $timestamp);
    }
    public function getBirthDay(){
        return $this->convertDateForPage($this->birth_day);
    }
    public function getPasportIssuedDate(){
        return $this->convertDateForPage($this->pasport_issued_date);
    }
    public function convertDateForPage($date){
        $timestamp = strtotime($date);
        return date('d.m.Y', $timestamp);
    }
    public function getArmy()
    {
        $armyList = self::getArmyList();
        return $armyList[$this->army];
    }
    public function getMaritalStatus()
    {
        $maritalList = self::getMaritalList();
        return $maritalList[$this->marital_status];
    }
    public function getSalary()
    {
        return $this->salary ? $this->salary : ' - ';
    }
    public function getDepartment()
    {
        $departmentList = self::getDepartmentList();
        return $departmentList[$this->department];
    }

    public function getDepartmentShort(){
        $departmentList = self::getDepartmentShortList();
        return $departmentList[$this->department];
    }
    public function getDepartmentColorClass(){
        $colorClassList = self::getDepartmentColorClassList();
        return $colorClassList[$this->department];
    }
    public function getEducation(){
        $educationList = self::getEducationList();
        return $educationList[$this->education];
    }
    public function getFIO(){
        return $this->middle_name . ' ' . $this->first_name . ' ' . $this->last_name;
    }
    public function getAge()
    {
        if (!$this->birth_day) {
            return ' - ';
        }
        $datetime = new \DateTime($this->birth_day);
        $interval = $datetime->diff(new \DateTime(date("Y-m-d")));
        return $interval->format("%Y");
    }
    public function getPhone()
    {
        return ($this->phone) ? ' +8 ' . $this->phone : '(не указан)';
    }
    public function getAvatar()
    {
        $avatar = $this->avatar ?? self::DEFAULT_AVATAR;
        return '/uploads/' . $avatar;
    }


    public function generateFullname($model)
    {
        return $model->middle_name . ' ' . $model->first_name;
    }
    
    public static function updateUserInfo($model, $imageModel, $id)
    {
        $transaction = Yii::$app->db->beginTransaction();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $imageModel->setImage(UploadedFile::getInstance($imageModel, 'image'));

            if ($imageModel->upload($model)) {
                $transaction->commit();
                return Yii::$app->controller->redirect(['view', 'id' => $id]);
            }

            $transaction->rollBack();
            return json_encode($imageModel->errors);
            
        }

        $transaction->rollBack();
        return json_encode($model->errors);
    }

    public static function getMaritalList()
    {
        return [
            self::DEFAULT_OPTION => 'Не выбрано',
            self::MARITAL_STATUS_SINGLE => 'Холост',
            self::MARITAL_STATUS_MARRIED => 'Женат',
            self::MARITAL_STATUS_MARRIED_GIRL => 'Замужем',
            self::MARITAL_STATUS_UNMARRIED => 'Не замужем',
        ];
    }

    public static function getEducationList()
    {
        return [
            self::DEFAULT_OPTION => 'Не выбрано',
            self::EDUCATION_HIGH => 'Высшее',
            self::EDUCATION_SECONDARY => 'Среднее',
            self::EDUCATION_SCHOOL => 'Школьное',
        ];
    }

    public static function getArmyList()
    {
        return [
            self::DEFAULT_OPTION => 'Не выбрано',
            self::ARMY_SERVED => 'Служил',
            self::ARMY_NOT_SERVED => 'Не служил',
        ];
    }
    public static function getDepartmentList()
    {
        return [
            self::DEFAULT_OPTION => 'Не выбрано',
            self::DEPARTMENT_UPP => 'Юрист первичного приема',
            self::DEPARTMENT_RECEPTION => 'Ресепшен',
            self::DEPARTMENT_EPOD => 'ЭПОД',
            self::DEPARTMENT_OKK => 'Контроль качества',
            self::DEPARTMENT_CONTROL => 'Управление',
            self::DEPARTMENT_REPRESENT => 'Представители',
            self::DEPARTMENT_IT  => 'Информационные технологии',
            self::DEPARTMENT_HR => 'Подбор персонала',
        ];
    }

    public static function getDepartmentShortList()
    {
        return [
            self::DEFAULT_OPTION => 'Не выбрано',
            self::DEPARTMENT_UPP => 'ЮПП',
            self::DEPARTMENT_RECEPTION => 'Респепшен',
            self::DEPARTMENT_EPOD => 'ЭПОД',
            self::DEPARTMENT_OKK => 'ОКК',
            self::DEPARTMENT_CONTROL => 'Управление',
            self::DEPARTMENT_REPRESENT => 'Представитель',
            self::DEPARTMENT_IT  => 'ИТ',
            self::DEPARTMENT_HR => 'HR',
        ];
    }

    public static function getDepartmentColorClassList()
    {
        return [
            self::DEFAULT_OPTION => 'bg-danger',
            self::DEPARTMENT_UPP => 'user-bg-upp',
            self::DEPARTMENT_RECEPTION => 'user-bg-reseption',
            self::DEPARTMENT_EPOD => 'user-bg-epod',
            self::DEPARTMENT_OKK => 'user-bg-okk',
            self::DEPARTMENT_CONTROL => 'user-bg-control',
            self::DEPARTMENT_REPRESENT => 'user-bg-represent',
            self::DEPARTMENT_IT  => 'user-bg-it',
            self::DEPARTMENT_HR => 'user-bg-hr',
        ];
    }
    
    /**
     * Gets query for [[Pin0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPin()
    {
        return $this->hasOne(User::className(), ['pin' => 'pin']);
    }
}
