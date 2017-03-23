<?php
$I = new ApiTester($scenario);
$I->wantTo('create a product via API');
$I->haveHttpHeader('Content-Type', 'application/json');
$I->sendPOST('/product', ['name' => 'traktor', 'price' => 9.99]);
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
$I->seeResponseIsJson();
$I->seeResponseContainsJson([
                                'data' => [
                                    'name' => 'traktor',
                                    'price' => 9.99
                                ]
                            ]);
//@todo podpiać pod to json matcher
