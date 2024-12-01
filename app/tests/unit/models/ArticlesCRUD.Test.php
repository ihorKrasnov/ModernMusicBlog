<?php 

namespace tests\unit\models;

use app\models\Articles;
use app\models\Users;
use app\models\Topic;
use Yii;

class ArticlesTest extends \Codeception\Test\Unit
{
    private $article;

    protected function _before()
    {
        $this->article = new Articles([
            'authorid' => 1,
            'topicid' => 1,
            'title' => 'Test Article',
            'content' => 'This is a test article content.',
            'tag' => 'Test',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    protected function _after()
    {
        $this->article->delete();
    }

    // Test Create (Insert) Article
    public function testCreateArticle()
    {
        $this->assertTrue($this->article->save(), 'Article should be saved successfully.');

        // Verify the article was saved correctly
        $articleFromDb = Articles::findOne($this->article->id);
        $this->assertNotNull($articleFromDb, 'Article should exist in the database.');
        $this->assertEquals($this->article->title, $articleFromDb->title, 'Article title should match.');
    }

    // Test Read (Find) Article
    public function testFindArticle()
    {
        $this->article->save();

        $articleFromDb = Articles::findOne($this->article->id);
        $this->assertNotNull($articleFromDb, 'Article should be found in the database.');
        $this->assertEquals($this->article->title, $articleFromDb->title, 'Article title should match.');
    }

    // Test Update Article
    public function testUpdateArticle()
    {
        $this->article->save();

        $this->article->title = 'Updated Title';
        $this->assertTrue($this->article->save(), 'Article should be updated successfully.');

        $articleFromDb = Articles::findOne($this->article->id);
        $this->assertEquals('Updated Title', $articleFromDb->title, 'Article title should be updated.');
    }

    // Test Delete Article
    public function testDeleteArticle()
    {
        $this->article->save();

        $this->assertTrue($this->article->delete() == 1, 'Article should be deleted successfully.');
    }

    // Test Validation (Required Fields)
    public function testArticleValidation()
    {
        // Missing title
        $article = new Articles([
            'authorid' => 1,
            'topicid' => 1,
            'content' => 'Content without title.',
            'tag' => 'Test',
        ]);
        $this->assertFalse($article->validate(), 'Article should not validate without a title.');
        $this->assertArrayHasKey('title', $article->errors, 'Validation should fail on missing title.');
    }
}

