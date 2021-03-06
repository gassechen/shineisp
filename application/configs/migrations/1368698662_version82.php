<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version82 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('isp_urls', array(
             'id' => 
             array(
              'type' => 'integer',
              'fixed' => '0',
              'unsigned' => '1',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             'isp_id' => 
             array(
              'type' => 'integer',
              'fixed' => '0',
              'unsigned' => '',
              'length' => '4',
             ),
             'url' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '200',
             ),
             ), array(
             'primary' => 
             array(
              0 => 'id',
             ),
             'charset' => 'UTF8',
             ));
        $this->addColumn('customers', 'uuid', 'string', '50', array(
             'notnull' => '',
             ));
    }

    public function down()
    {
        $this->dropTable('isp_urls');
        $this->removeColumn('customers', 'uuid');
    }
}