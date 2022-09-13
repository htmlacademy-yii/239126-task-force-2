<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $creation_time
 * @property string|null $phone
 * @property string|null $telegram
 * @property string|null $birthday
 * @property string|null $about
 * @property int $city_id
 * @property int|null $avatar_file_id
 *
 * @property Files $avatarFile
 * @property Cities $city
 * @property Responses[] $responses
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 * @property UsersCategories[] $usersCategories
 * @property string $USER [char(32)]
 * @property int $CURRENT_CONNECTIONS [bigint]
 * @property int $TOTAL_CONNECTIONS [bigint]
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password', 'creation_time', 'city_id'], 'required'],
            [['creation_time', 'birthday'], 'safe'],
            [['about'], 'string'],
            [['city_id', 'avatar_file_id'], 'integer'],
            [['name', 'telegram'], 'string', 'max' => 128],
            [['email'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 60],
            [['phone'], 'string', 'max' => 20],
            [['email'], 'unique'],
            [['phone'], 'unique'],
            [['telegram'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['avatar_file_id'], 'exist', 'skipOnError' => true, 'targetClass' => Files::className(), 'targetAttribute' => ['avatar_file_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'creation_time' => 'Creation Time',
            'phone' => 'Phone',
            'telegram' => 'Telegram',
            'birthday' => 'Birthday',
            'about' => 'About',
            'city_id' => 'City ID',
            'avatar_file_id' => 'Avatar File ID',
        ];
    }

    /**
     * Gets query for [[AvatarFile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvatarFile()
    {
        return $this->hasOne(Files::className(), ['id' => 'avatar_file_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Responses::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Tasks::className(), ['worker_id' => 'id']);
    }

    /**
     * Gets query for [[UsersCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersCategories()
    {
        return $this->hasMany(UsersCategories::className(), ['user_id' => 'id']);
    }
}
