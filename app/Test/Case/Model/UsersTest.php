<?php
/* Users Test cases generated on: 2014-05-09 12:40:00 : 1335797201*/
App::uses('Users', 'Model');

/**
 * Users Test Case
 *
 */
class UsersTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.users');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Users = ClassRegistry::init('Users');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Users);

		parent::tearDown();
	}

}