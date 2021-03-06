<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('CreditNotesItems', 'doctrine');

/**
 * BaseCreditNotesItems
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $creditnoteitem_id
 * @property integer $creditnote_id
 * @property float $vat
 * @property float $price
 * @property float $total
 * @property string $description
 * @property integer $quantity
 * @property CreditNotes $CreditNotes
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCreditNotesItems extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('credit_notes_items');
        $this->hasColumn('creditnoteitem_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('creditnote_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('vat', 'float', 10, array(
             'type' => 'float',
             'notnull' => true,
             'default' => '0.00',
             'length' => '10',
             ));
        $this->hasColumn('price', 'float', 10, array(
             'type' => 'float',
             'notnull' => true,
             'default' => '0.00',
             'length' => '10',
             ));
        $this->hasColumn('total', 'float', 10, array(
             'type' => 'float',
             'notnull' => true,
             'default' => '0.00',
             'length' => '10',
             ));
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
        $this->hasColumn('quantity', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('CreditNotes', array(
             'local' => 'creditnote_id',
             'foreign' => 'creditnote_id'));
    }
}