<?php

class ApiCest
{
	public function tryHomePage(ApiTester $I)
	{
		
		$I->haveHttpHeader('auth-token', '62078df9c743c2.32162759');
		$I->sendGet('/');
		$I->seeResponseCodeIs(200);
		$I->seeResponseIsJson();
		
		$I->sendPost('/');
		$I->seeResponseCodeIs(200);
		$I->seeResponseIsJson();
	}
	
	public function tryWelcome(ApiTester $I)
	{
		$I->haveHttpHeader('auth-token', '62078df9c743c2.32162759');
		$I->sendPost('/welcome', ['welcome' => 'test']);
		$I->seeResponseCodeIs(200);
		$I->seeResponseIsJson();
		$I->seeResponseContainsJson(['message' => 'received', 'input' => 'test']);
		
		$I->sendPost('/welcome');
		$I->seeResponseCodeIs(200);
		$I->seeResponseIsJson();
		$I->seeResponseContainsJson(['error' => 'Argument not provided']);
	}
	
	public function tryCatch_all(ApiTester $I)
	{
		$I->haveHttpHeader('auth-token', '62078df9c743c2.32162759');
		$I->sendGet('/t');
		$I->seeResponseCodeIs(404);
		$I->seeResponseIsJson();
		$I->seeResponseContainsJson(['Error' => '404 not found']);
	}
	
	public function tryRenew_Token(ApiTester $I)
	{
	
	}
}