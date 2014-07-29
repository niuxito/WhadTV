<?php
/* Dispositivo Test cases generated on: 2012-04-30 16:49:42 : 1335797382*/
App::uses('Dispositivo', 'Model');

/**
 * Dispositivo Test Case
 *
 */
class DispositivoTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.dispositivo');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Dispositivo = ClassRegistry::init('Dispositivo');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Dispositivo);

		parent::tearDown();
	}

}
