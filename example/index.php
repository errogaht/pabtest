<?php
/**
 * Created by PhpStorm.
 * User: Alexey Teterin
 * Email: 7018407@gmail.com
 * Date: 22.12.2015
 * Time: 20:07
 */

use errogaht\PABTest\PABTest;

require 'vendor/autoload.php';

PABTest::init();

$t1 = microtime(true);
$buttonTest = new PABTest('buttonTest', ['small' => 50, 'big' => 50]);

echo $buttonTest->getVariant() . '<br>';

PABTest::reachGoal('buttonTest');

echo microtime(true) - $t1;

