# pabtest

1. `composer require errogaht/pabtest:dev-master`

2. copy files from vendor/errogaht/pabtest/example/* to project root

3. open in browser index.php, all needed code in this file

4. to view tests list run `php vendor\errogaht\pabtest\bin\pabtest list`

5. to view results  run `php vendor\errogaht\pabtest\bin\pabtest result buttonTest`

# Как работает

Пишет в сессию, после показа результата пользователю показывается всегда этот результат, до сброса сессии.

`PABTest::init();` запускаем если в приложении не запускается сессия, соответственно только до того как заголовки оправлены

в index.php определяем параметры теста с помощью `$buttonTest = new PABTest('buttonTest', ['small' => 50, 'big' => 50]);`

Когда нужно показать тот или иной вариант - вызываем код `$buttonTest->getVariant()` и он выдаст нам или `small` или `big` примерно с одинаковой вероятностью в 50%

Когда пользователь выполнил целевое действие регистрируем конверсию `PABTest::reachGoal('buttonTest');`

в конце смотрим список всех тестов в консоли `php vendor\errogaht\pabtest\bin\pabtest list`

и результаты для конкретного теста `php vendor\errogaht\pabtest\bin\pabtest result buttonTest`
