<?php
/* Calendario Test cases generated on: 2012-04-30 16:46:41 : 1335797201*/
App::uses('Calendario', 'Model');

/**
 * Calendario Test Case
 *
 */
class CalendarioTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.calendario');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Calendario = ClassRegistry::init('Calendario');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Calendario);

		parent::tearDown();
	}

}
