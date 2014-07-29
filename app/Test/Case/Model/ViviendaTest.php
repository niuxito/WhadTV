<?php
/* Vivienda Test cases generated on: 2011-12-03 21:54:52 : 1322945692*/
App::uses('Vivienda', 'Model');

/**
 * Vivienda Test Case
 *
 */
class ViviendaTestCase extends CakeTestCase {
/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Vivienda = ClassRegistry::init('Vivienda');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Vivienda);

		parent::tearDown();
	}

}
