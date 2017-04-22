<?php
$I = new ApiTester($scenario);
$I->wantTo('update a product via API');

$I->haveHttpHeader('Content-Type', 'application/json');
$I->sendGET('/product');
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
$I->seeResponseIsJson();

