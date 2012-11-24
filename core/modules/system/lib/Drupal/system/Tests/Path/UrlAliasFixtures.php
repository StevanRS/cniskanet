<?php

namespace Drupal\system\Tests\Path;

use Drupal\Core\Database\Connection;

/**
 * Utility methods to generate sample data, database configuration, etc.
 */
class UrlAliasFixtures {

  /**
   * Create the tables required for the sample data.
   *
   * @param Drupal\Core\Database\Connection $connection
   *   The connection to use to create the tables.
   */
  public function createTables(Connection $connection) {
    $tables = $this->urlAliasTableDefinition();
    $schema = $connection->schema();

    foreach ($tables as $name => $table) {
      $schema->dropTable($name);
      $schema->createTable($name, $table);
    }
  }

  /**
   * Drop the tables used for the sample data.
   *
   * @param Drupal\Core\Database\Connection $connection
   *   The connection to use to drop the tables.
   */
  public function dropTables(Connection $connection) {
    $tables = $this->urlAliasTableDefinition();
    $schema = $connection->schema();

    foreach ($tables as $name => $table) {
      $schema->dropTable($name);
    }
  }

  /**
   * Returns an array of URL aliases for testing.
   *
   * @return array of URL alias definitions.
   */
  public function sampleUrlAliases() {
    return array(
      array(
        'source' => 'node/1',
        'alias' => 'alias_for_node_1_en',
        'langcode' => 'en'
      ),
      array(
        'source' => 'node/2',
        'alias' => 'alias_for_node_2_en',
        'langcode' => 'en'
      ),
      array(
        'source' => 'node/1',
        'alias' => 'alias_for_node_1_fr',
        'langcode' => 'fr'
      ),
      array(
        'source' => 'node/1',
        'alias' => 'alias_for_node_1_und',
        'langcode' => 'und'
      )
    );
  }


  /**
   * Returns the table definition for the URL alias fixtures.
   *
   * @return array
   *   Table definitions.
   */
  public function urlAliasTableDefinition() {
    $tables = array();

    module_load_install('system');
    $schema = system_schema();

    $tables['url_alias'] = $schema['url_alias'];
    $tables['key_value'] = $schema['key_value'];

    return $tables;
  }
}
