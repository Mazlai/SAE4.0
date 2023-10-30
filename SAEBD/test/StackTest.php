<?php

use PHPUnit\Framework\TestCase;
use \Phpunit\AjouterMatch;
use \Phpunit\AjoutVoirComposer;
use \Phpunit\VoirCartonsParArbitre;
use \Phpunit\connect;
use \Phpunit\index;

//require_once __DIR__ . '/vendor/phpunit/phpunit/src/Framework/TestCase.php';
//require_once 'AjouterMatch.php';
//require_once 'AjoutVoirComposer.php';
//require_once 'VoirCartonsParArbitre.php';

class StackTest extends TestCase {

    /** @test */
    public function testPushAndPop() {
		$amatch = new AjouterMatch();
		$res = $amatch->AjouterMatch();
		
		//$res = AjouterMatch();
		$this->assertSame('Match ajouté', $res);
   
	}
}