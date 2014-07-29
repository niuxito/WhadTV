<?php
/* Viviendas Test cases generated on: 2011-12-13 10:55:04 : 1323770104*/
App::uses('ViviendasController', 'Controller');

/**
 * TestViviendasController *
 */
class TestViviendasController extends ViviendasController {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * ViviendasController Test Case
 *
 */
class ViviendasControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.vivienda');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Viviendas = new TestViviendasController();
		$this->Viviendas->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Viviendas);

		parent::tearDown();
	}

}
