<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Customers', 'doctrine');

/**
 * BaseCustomers
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $customer_id
 * @property string $uuid
 * @property string $company
 * @property string $firstname
 * @property string $lastname
 * @property string $gender
 * @property string $email
 * @property string $password
 * @property string $resetpwd_key
 * @property timestamp $resetpwd_expire
 * @property timestamp $last_password_change
 * @property tinyint $force_password_change
 * @property date $birthdate
 * @property string $birthplace
 * @property string $birthdistrict
 * @property string $birthcountry
 * @property string $birthnationality
 * @property string $taxpayernumber
 * @property string $vat
 * @property integer $type_id
 * @property integer $parent_id
 * @property integer $legalform_id
 * @property string $note
 * @property integer $status_id
 * @property integer $isp_id
 * @property integer $group_id
 * @property integer $language_id
 * @property boolean $issubscriber
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property boolean $taxfree
 * @property boolean $isreseller
 * @property boolean $ignore_latefee
 * @property string $customer_number
 * @property Isp $Isp
 * @property CustomersGroups $CustomersGroups
 * @property CompanyTypes $CompanyTypes
 * @property Legalforms $Legalforms
 * @property Statuses $Statuses
 * @property Customers $Customers
 * @property Languages $Languages
 * @property CustomAttributesValues $CustomAttributesValues
 * @property Doctrine_Collection $Addresses
 * @property Doctrine_Collection $Contacts
 * @property Doctrine_Collection $DomainsProfiles
 * @property Doctrine_Collection $CustomersDomainsRegistrars
 * @property Doctrine_Collection $Domains
 * @property Doctrine_Collection $DomainsBulk
 * @property Doctrine_Collection $EmailsTemplatesSends
 * @property Doctrine_Collection $Fastlinks
 * @property Doctrine_Collection $Invoices
 * @property Doctrine_Collection $Messages
 * @property Doctrine_Collection $NewslettersSubscribers
 * @property Doctrine_Collection $Orders
 * @property Doctrine_Collection $PanelsActions
 * @property Doctrine_Collection $Payments
 * @property Doctrine_Collection $TagsConnections
 * @property Doctrine_Collection $Tickets
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCustomers extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('customers');
        $this->hasColumn('customer_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('uuid', 'string', 50, array(
             'type' => 'string',
             'notnull' => false,
             'length' => '50',
             ));
        $this->hasColumn('company', 'string', 50, array(
             'type' => 'string',
             'notnull' => false,
             'length' => '50',
             ));
        $this->hasColumn('firstname', 'string', 100, array(
             'type' => 'string',
             'notnull' => false,
             'length' => '100',
             ));
        $this->hasColumn('lastname', 'string', 100, array(
             'type' => 'string',
             'notnull' => false,
             'length' => '100',
             ));
        $this->hasColumn('gender', 'string', 1, array(
             'type' => 'string',
             'notnull' => false,
             'length' => '1',
             ));
        $this->hasColumn('email', 'string', 100, array(
             'type' => 'string',
             'notnull' => false,
             'length' => '100',
             ));
        $this->hasColumn('password', 'string', 300, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '300',
             ));
        $this->hasColumn('resetpwd_key', 'string', 50, array(
             'type' => 'string',
             'length' => '50',
             ));
        $this->hasColumn('resetpwd_expire', 'timestamp', 25, array(
             'type' => 'timestamp',
             'length' => '25',
             ));
        $this->hasColumn('last_password_change', 'timestamp', 25, array(
             'type' => 'timestamp',
             'notnull' => false,
             'length' => '25',
             ));
        $this->hasColumn('force_password_change', 'tinyint', 1, array(
             'type' => 'tinyint',
             'notnull' => true,
             'fixed' => 0,
             'length' => '1',
             ));
        $this->hasColumn('birthdate', 'date', 25, array(
             'type' => 'date',
             'notnull' => false,
             'length' => '25',
             ));
        $this->hasColumn('birthplace', 'string', 200, array(
             'type' => 'string',
             'notnull' => false,
             'length' => '200',
             ));
        $this->hasColumn('birthdistrict', 'string', 50, array(
             'type' => 'string',
             'notnull' => false,
             'length' => '50',
             ));
        $this->hasColumn('birthcountry', 'string', 50, array(
             'type' => 'string',
             'notnull' => false,
             'length' => '50',
             ));
        $this->hasColumn('birthnationality', 'string', 50, array(
             'type' => 'string',
             'notnull' => false,
             'length' => '50',
             ));
        $this->hasColumn('taxpayernumber', 'string', 20, array(
             'type' => 'string',
             'notnull' => false,
             'length' => '20',
             ));
        $this->hasColumn('vat', 'string', 20, array(
             'type' => 'string',
             'notnull' => false,
             'length' => '20',
             ));
        $this->hasColumn('type_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => false,
             'length' => '4',
             ));
        $this->hasColumn('parent_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => false,
             'length' => '4',
             ));
        $this->hasColumn('legalform_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => false,
             'length' => '4',
             ));
        $this->hasColumn('note', 'string', null, array(
             'type' => 'string',
             'notnull' => false,
             'length' => '',
             ));
        $this->hasColumn('status_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('isp_id', 'integer', 4, array(
             'type' => 'integer',
             'default' => 1,
             'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('group_id', 'integer', 4, array(
             'type' => 'integer',
             'default' => '1',
             'length' => '4',
             ));
        $this->hasColumn('language_id', 'integer', 4, array(
             'type' => 'integer',
             'default' => '1',
             'notnull' => false,
             'length' => '4',
             ));
        $this->hasColumn('issubscriber', 'boolean', 25, array(
             'type' => 'boolean',
             'default' => 1,
             'length' => '25',
             ));
        $this->hasColumn('created_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'notnull' => false,
             'length' => '25',
             ));
        $this->hasColumn('updated_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'notnull' => false,
             'length' => '25',
             ));
        $this->hasColumn('taxfree', 'boolean', 25, array(
             'type' => 'boolean',
             'length' => '25',
             ));
        $this->hasColumn('isreseller', 'boolean', 25, array(
             'type' => 'boolean',
             'length' => '25',
             ));
        $this->hasColumn('ignore_latefee', 'boolean', 25, array(
             'type' => 'boolean',
             'default' => 0,
             'length' => '25',
             ));
        $this->hasColumn('customer_number', 'string', 50, array(
             'type' => 'string',
             'length' => '50',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Isp', array(
             'local' => 'isp_id',
             'foreign' => 'isp_id'));

        $this->hasOne('CustomersGroups', array(
             'local' => 'group_id',
             'foreign' => 'group_id'));

        $this->hasOne('CompanyTypes', array(
             'local' => 'type_id',
             'foreign' => 'type_id',
             'onDelete' => 'Set Null'));

        $this->hasOne('Legalforms', array(
             'local' => 'legalform_id',
             'foreign' => 'legalform_id',
             'onDelete' => 'Set Null'));

        $this->hasOne('Statuses', array(
             'local' => 'status_id',
             'foreign' => 'status_id'));

        $this->hasOne('Customers', array(
             'local' => 'parent_id',
             'foreign' => 'customer_id'));

        $this->hasOne('Languages', array(
             'local' => 'language_id',
             'foreign' => 'language_id'));

        $this->hasOne('CustomAttributesValues', array(
             'local' => 'customer_id',
             'foreign' => 'external_id'));

        $this->hasMany('Addresses', array(
             'local' => 'customer_id',
             'foreign' => 'customer_id'));

        $this->hasMany('Contacts', array(
             'local' => 'customer_id',
             'foreign' => 'customer_id'));

        $this->hasMany('DomainsProfiles', array(
             'local' => 'customer_id',
             'foreign' => 'customer_id'));

        $this->hasMany('CustomersDomainsRegistrars', array(
             'local' => 'customer_id',
             'foreign' => 'customer_id'));

        $this->hasMany('Domains', array(
             'local' => 'customer_id',
             'foreign' => 'customer_id'));

        $this->hasMany('DomainsBulk', array(
             'local' => 'customer_id',
             'foreign' => 'customer_id'));

        $this->hasMany('EmailsTemplatesSends', array(
             'local' => 'customer_id',
             'foreign' => 'customer_id'));

        $this->hasMany('Fastlinks', array(
             'local' => 'customer_id',
             'foreign' => 'customer_id'));

        $this->hasMany('Invoices', array(
             'local' => 'customer_id',
             'foreign' => 'customer_id'));

        $this->hasMany('Messages', array(
             'local' => 'customer_id',
             'foreign' => 'customer_id'));

        $this->hasMany('NewslettersSubscribers', array(
             'local' => 'customer_id',
             'foreign' => 'customer_id'));

        $this->hasMany('Orders', array(
             'local' => 'customer_id',
             'foreign' => 'customer_id'));

        $this->hasMany('PanelsActions', array(
             'local' => 'customer_id',
             'foreign' => 'customer_id'));

        $this->hasMany('Payments', array(
             'local' => 'customer_id',
             'foreign' => 'customer_id'));

        $this->hasMany('TagsConnections', array(
             'local' => 'customer_id',
             'foreign' => 'customer_id'));

        $this->hasMany('Tickets', array(
             'local' => 'customer_id',
             'foreign' => 'customer_id'));
    }
}