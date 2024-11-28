<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $fullname
 * @property string $name
 * @property string $password
 * @property resource|null $avatar
 *
 * @property Articles[] $articles
 * @property Comments[] $comments
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $authKey;

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
            [['fullname', 'name', 'password', 'authKey'], 'required'],
            [['fullname', 'name', 'password', 'avatar', 'authKey'], 'string'],
            [['name', 'authKey'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fullname' => 'Fullname',
            'name' => 'Name',
            'password' => 'Password',
            'avatar' => 'Avatar',
            'authKey' => 'AuthKey',
        ];
    }

    /**
     * Finds user by ID.
     * @param int $id
     * @return static|null
     */
    public static function findIdentity($id)
    {
        return static::findOne($id); // Повертаємо користувача за id
    }

    /**
     * Finds user by access token.
     * @param string $token
     * @param null $type
     * @return static|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]); // Повертаємо користувача за токеном
    }

    /**
     * Finds user by username (або name, якщо таке поле у вас використовується).
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = static::findOne(['name' => $username]);

        return $user;  // Повертаємо користувача
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id; // Повертаємо ID користувача
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey; // Повертаємо authKey, якщо є
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey; // Перевіряємо authKey
    }

    /**
     * Validate password.
     * @param string $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password); // Перевіряємо пароль (якщо він зашифрований)
    }

    /**
     * Gets query for [[Articles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Articles::class, ['authorid' => 'id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['authorid' => 'id']);
    }
}
