<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "articles".
 *
 * @property int $id
 * @property int $authorid
 * @property int $topicid
 * @property string $title
 * @property string $content
 * @property string|null $tag
 * @property string|null $created_at
 *
 * @property Users $author
 * @property Comments[] $comments
 * @property Topic $topic
 */
class Articles extends \yii\db\ActiveRecord
{

    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['authorid', 'topicid', 'title', 'content'], 'required'],
            [['authorid', 'topicid'], 'default', 'value' => null],
            [['authorid', 'topicid'], 'integer'],
            [['title', 'content', 'tag'], 'string'],
            [['created_at'], 'safe'],
            [['topicid'], 'exist', 'skipOnError' => true, 'targetClass' => Topic::class, 'targetAttribute' => ['topicid' => 'id']],
            [['authorid'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['authorid' => 'id']],

            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 5 * 1024 * 1024], // максимум 5 МБ
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'authorid' => 'Authorid',
            'topicid' => 'Topicid',
            'title' => 'Title',
            'content' => 'Content',
            'tag' => 'Tag',
            'created_at' => 'Created At',
        ];
    }

    // Метод для збереження зображення у БД
    public function saveImageToDb()
    {
        if ($this->imageFile && $this->validate()) {
            $this->image = file_get_contents($this->imageFile->tempName);  // Читання файлу в бінарному вигляді
            return true;
        }
        return false;
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Users::class, ['id' => 'authorid']);
    }

    public function findeOne($id)
    {
        return static::findOne($id);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['articleid' => 'id']);
    }

    /**
     * Gets query for [[Topic]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(Topic::class, ['id' => 'topicid']);
    }
}
