<?php

/**
 * @file
 * Definition of Drupal\system\Tests\System\PasswordHashingTest.
 */

namespace Drupal\system\Tests\System;

use Drupal\simpletest\WebTestBase;

/**
 * Unit tests for password hashing API.
 */
class PasswordHashingTest extends WebTestBase {
  public static function getInfo() {
    return array(
      'name' => 'Password hashing',
      'description' => 'Password hashing unit tests.',
      'group' => 'System',
    );
  }

  function setUp() {
    require_once DRUPAL_ROOT . '/' . variable_get('password_inc', 'core/includes/password.inc');
    parent::setUp();
  }

  /**
   * Test password hashing.
   */
  function testPasswordHashing() {
    // Set a log2 iteration count that is deliberately out of bounds to test
    // that it is corrected to be within bounds.
    variable_set('password_count_log2', 1);
    // Set up a fake $account with a password 'baz', hashed with md5.
    $password = 'baz';
    $account = (object) array('name' => 'foo', 'pass' => md5($password));
    // The md5 password should be flagged as needing an update.
    $this->assertTrue(user_needs_new_hash($account), 'User with md5 password needs a new hash.');
    // Re-hash the password.
    $old_hash = $account->pass;
    $account->pass = user_hash_password($password);
    $this->assertIdentical(_password_get_count_log2($account->pass), DRUPAL_MIN_HASH_COUNT, 'Re-hashed password has the minimum number of log2 iterations.');
    $this->assertTrue($account->pass != $old_hash, 'Password hash changed.');
    $this->assertTrue(user_check_password($password, $account), 'Password check succeeds.');
    // Since the log2 setting hasn't changed and the user has a valid password,
    // user_needs_new_hash() should return FALSE.
    $this->assertFalse(user_needs_new_hash($account), 'User does not need a new hash.');
    // Increment the log2 iteration to MIN + 1.
    variable_set('password_count_log2', DRUPAL_MIN_HASH_COUNT + 1);
    $this->assertTrue(user_needs_new_hash($account), 'User needs a new hash after incrementing the log2 count.');
    // Re-hash the password.
    $old_hash = $account->pass;
    $account->pass = user_hash_password($password);
    $this->assertIdentical(_password_get_count_log2($account->pass), DRUPAL_MIN_HASH_COUNT + 1, 'Re-hashed password has the correct number of log2 iterations.');
    $this->assertTrue($account->pass != $old_hash, 'Password hash changed again.');
    // Now the hash should be OK.
    $this->assertFalse(user_needs_new_hash($account), 'Re-hashed password does not need a new hash.');
    $this->assertTrue(user_check_password($password, $account), 'Password check succeeds with re-hashed password.');
  }
}
