<?php
/* ListaVideo Test cases generated on: 2012-04-30 16:57:44 : 1335797864*/
App::uses('ListaVideo', 'Model');

/**
 * ListaVideo Test Case
 *
 */
class ListaVideoTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.lista_video');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->ListaVideo = ClassRegistry::init('ListaVideo');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ListaVideo);

		parent::tearDown();
	}

}
