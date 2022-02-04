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
}