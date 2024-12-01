<?php

namespace tests\unit\models;

use app\models\Users;
use Yii;

class RegisterFormTest extends \Codeception\Test\Unit
{
    private $model;

    protected function _after()
    {
        Yii::$app->user->logout();
    }

    public function testRegisterFormValidationSuccess()
    {
        // Підготовка тестових даних
        $formData = [
            'fullname' => 'John Doe',
            'name' => 'john_doe',
            'password' => 'password123',
            'authKey' => 'test'
        ];

        // Створення об'єкта моделі
        $this->model = new Users($formData);

        // Перевіряємо, що форма успішно проходить валідацію
        verify($this->model->validate())->true();

        // Перевірка, що не було помилок
        verify($this->model->errors)->arrayHasNotKey('fullname');
        verify($this->model->errors)->arrayHasNotKey('name');
        verify($this->model->errors)->arrayHasNotKey('password');
    }

    public function testRegisterFormValidationFail()
    {
        // Підготовка даних з помилками (наприклад, відсутній пароль)
        $formData = [
            'fullname' => 'John Doe',
            'name' => 'john_doe',
            // Відсутній пароль
        ];

        // Створення об'єкта моделі
        $this->model = new Users($formData);

        // Перевіряємо, що форма не проходить валідацію
        verify($this->model->validate())->false();

        // Перевірка наявності помилки на поле "password"
        verify($this->model->errors)->arrayHasKey('password');
    }

    public function testRegisterFormSuccess()
    {
        // Підготовка тестових даних
        $formData = [
            'fullname' => 'John Doe',
            'name' => 'john_doe',
            'password' => 'password123',
            'authKey' => 'test'
        ];

        // Створення об'єкта моделі
        $this->model = new Users($formData);

        // Перевірка успішної реєстрації
        verify($this->model->register())->true();
    }

    public function testFormDisplaysErrors()
    {
        // Підготовка даних з помилками
        $formData = [
            'fullname' => '',  // Порожнє поле
            'name' => 'john_doe',
            'password' => 'password123',
        ];

        // Створення об'єкта моделі
        $this->model = new Users($formData);

        // Перевіряємо, що форма не проходить валідацію
        $this->model->validate();
        
        // Перевірка, що помилка з'явилась для поля "fullname"
        verify($this->model->errors)->arrayHasKey('fullname');
    }
}
