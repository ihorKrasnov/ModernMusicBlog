<?php

namespace tests\unit\models;

use app\models\Articles;
use Yii;
use app\models\Article;
use app\models\Topic;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

class PostsViewTest extends \Codeception\Test\Unit
{
    // Тестування фільтрації публікацій за темою
    public function testFilterByTopic()
    {
        // Створюємо тестові дані
        $topic = Topic::findOne(['name' => 'Platform Guidelines']);
        $articles = Articles::find()->where(['topicid' => $topic->id])->all();
        
        // Перевіряємо, що всі публікації мають правильну тему
        foreach ($articles as $article) {
            $this->assertEquals($topic->id, $article->topicid, "Article topic_id does not match the filtered topic.");
        }
    }

    // Тестування обрізання контенту
    public function testContentTruncation()
    {
        $article = Articles::findOne(25); // Припускаємо, що є публікація з id = 1
        
        // Обрізаємо контент, використовуючи логіку з вашого коду
        $content = Html::encode($article->content);
        $words = explode(' ', $content);

        if (count($words) > 20) {
            $words = array_slice($words, 0, 20);
            $content = implode(' ', $words) . '...';
        } else {
            $content = implode(' ', $words);
        }

        // Перевіряємо, чи текст обрізано після 20 слів
        $this->assertStringEndsWith('...', $content, "Content truncation failed.");
        $this->assertLessThanOrEqual(20, count(explode(' ', $content)), "Content exceeds 20 words.");
    }

    // Тестування правильного відображення тем у меню
    public function testTopicMenu()
    {
        // Отримуємо всі теми
        $topics = Topic::find()->all();
        
        // Перевіряємо, що кожна тема відображається в меню
        foreach ($topics as $topic) {
            $this->assertNotEmpty(Html::encode($topic->name), "Topic name should not be empty.");
        }
    }

    // Тестування формату дати публікації
    public function testDateFormatting()
    {
        // Припускаємо, що публікація з id = 1 є
        $article = Articles::findOne(25);

        // Отримуємо дату публікації і перевіряємо формат
        $formattedDate = Yii::$app->formatter->asDate($article->created_at, 'long');
        
        // Перевіряємо, чи правильний формат дати
        $this->assertMatchesRegularExpression('/\w+\s\d{1,2},\s\d{4}/', $formattedDate, "Date format is incorrect.");
    }
}
