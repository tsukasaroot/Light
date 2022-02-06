<?php
class ApiCest
{
    public function tryHomePage(ApiTester $I)
    {
        $I->sendGet('/');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
	
		$I->sendPost('/');
		$I->seeResponseCodeIs(200);
		$I->seeResponseIsJson();
    }
	
	public function tryWelcome(ApiTester $I)
	{
		$I->sendPost('/welcome', [ 'welcome' => 'test' ]);
		$I->seeResponseCodeIs(200);
		$I->seeResponseIsJson();
		$I->seeResponseContainsJson([ 'message' => 'received', 'input' => 'test' ]);
		
		$I->sendPost('/welcome');
		$I->seeResponseCodeIs(200);
		$I->seeResponseIsJson();
		$I->seeResponseContainsJson([ 'error' => 'Argument not provided' ]);
	}
	
	public function tryCatch_all(ApiTester $I)
	{
		$I->sendGet('/t');
		$I->seeResponseCodeIs(404);
		$I->seeResponseIsJson();
		$I->seeResponseContainsJson([ 'Error' => '404 not found' ]);
	}
}