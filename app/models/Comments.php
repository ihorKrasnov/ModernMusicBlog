<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property int $articleid
 * @property int $authorid
 * @property int|null $commentid
 * @property string $message
 * @property string|null $created_at
 *
 * @property Articles $article
 * @property Users $author
 * @property Comments $comment
 * @property Comments $comment0
 * @property Comments[] $comments
 * @property Comments[] $comments0
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['articleid', 'authorid', 'message'], 'required'],
            [['articleid', 'authorid', 'commentid'], 'default', 'value' => null],
            [['articleid', 'authorid', 'commentid'], 'integer'],
            [['message'], 'string'],
            [['created_at'], 'safe'],
            [['articleid'], 'exist', 'skipOnError' => true, 'targetClass' => Articles::class, 'targetAttribute' => ['articleid' => 'id']],
            [['commentid'], 'exist', 'skipOnError' => true, 'targetClass' => Comments::class, 'targetAttribute' => ['commentid' => 'id']],
            [['commentid'], 'exist', 'skipOnError' => true, 'targetClass' => Comments::class, 'targetAttribute' => ['commentid' => 'id']],
            [['authorid'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['authorid' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'articleid' => 'Articleid',
            'authorid' => 'Authorid',
            'commentid' => 'Commentid',
            'message' => 'Message',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Article]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Articles::class, ['id' => 'articleid']);
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

    /**
     * Gets query for [[Comment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComment()
    {
        return $this->hasOne(Comments::class, ['id' => 'commentid']);
    }

    /**
     * Gets query for [[Comment0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComment0()
    {
        return $this->hasOne(Comments::class, ['id' => 'commentid']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['commentid' => 'id']);
    }

    /**
     * Gets query for [[Comments0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments0()
    {
        return $this->hasMany(Comments::class, ['commentid' => 'id']);
    }
}
