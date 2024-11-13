<?php

namespace app\Models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\Models\Comments;

/**
 * CommentsSearch represents the model behind the search form of `app\Models\Comments`.
 */
class CommentsSearch extends Comments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'articleid', 'authorid', 'commentid'], 'integer'],
            [['message', 'created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Comments::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'articleid' => $this->articleid,
            'authorid' => $this->authorid,
            'commentid' => $this->commentid,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'message', $this->message]);

        return $dataProvider;
    }
}
