<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Articles;
use Yii;

class ArticlesSearch extends Articles
{
    public function rules()
    {
        return [
            [['id', 'authorid', 'topicid'], 'integer'],
            [['title', 'content', 'tag'], 'safe'],
            [['created_at'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Articles::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Якщо валідація не пройшла, повертаємо пустий результат
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'authorid' => $this->authorid,
            'topicid' => $this->topicid,
        ]);

        // Фільтрація по полю title
        $query->andFilterWhere(['like', 'title', $this->title]);

        $query->andFilterWhere(['like', 'tag', $this->tag]);

        // Перевірка і фільтрація по даті
        if (!empty($this->created_at)) {
            // Format the created_at input date before comparing
            $formattedDate = date('Y-m-d', strtotime($this->created_at));
            $query->andFilterWhere(['DATE(created_at)' => $formattedDate]); // Use DATE() function for PostgreSQL
        }

        $query->orderBy(['created_at' => SORT_DESC]);

        return $dataProvider;
    }
}
