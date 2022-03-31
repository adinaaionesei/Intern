<?php
namespace Intern\Vendor\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;


class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
        $installer = $setup;

        $installer->startSetup();

        if(version_compare($context->getVersion(), '1.1.0', '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable( 'intern_vendor_entity' ),
                'telephone',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' => 'telephone',
                    'after' => 'status'
                ]
            );
        }
        if(version_compare($context->getVersion(), '1.2.0', '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable('intern_vendor_entity'),
                'cc_emails',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' => 'cc_emails',
                    'after' => 'email'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable('intern_vendor_entity'),
                'currency',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' => 'currency',
                    'after' => 'cc_emails'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable('intern_vendor_entity'),
                'notify_orders',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    'nullable' => true,
                    'comment' => 'notify_orders',
                    'after' => 'currency'
                ]
            );
        }

        if(version_compare($context->getVersion(), '1.3.0', '<')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('intern_vendor_address')
            )
                ->addColumn(
                    'address_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'address_id'
                )
                ->addColumn(
                    'vendor_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'nullable' => false,
                        'unsigned' => true
                    ],
                    'vendor_id'
                )
                ->addColumn(
                    'address_type',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'address_type'
                )
                ->addColumn(
                    'contact_name',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable => true'],
                    'contact_name'
                )
                ->addColumn(
                    'street',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'street'
                )
                ->addColumn(
                    'city',
                    Table::TYPE_TEXT,
                    1,
                    [],
                    'city'
                )
                ->addColumn(
                    'postal_code',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'postal_code'
                )
                ->addColumn(
                    'country',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'country'
                )
                ->addColumn(
                    'state_region',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'state_region'
                )
                ->addColumn(
                    'same_as_billing',
                    Table::TYPE_INTEGER,
                    1,
                    [],
                    'same_as_billing'
                )->addIndex(
                    $installer->getConnection()->getIndexName('intern_vendor_address', ['vendor_id']),
                    ['vendor_id']
                )->addForeignKey(
                    $installer->getFkName('intern_vendor_address', 'address_id', 'intern_vendor_entity', 'vendor_id'),
                    'vendor_id',
                    $installer->getTable('intern_vendor_entity'),
                    'vendor_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->setComment('Address Table');
            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('intern_vendor_address'),
                $setup->getIdxName(
                    $installer->getTable('intern_vendor_address'),
                    ['contact_name', 'street', 'city', 'postal_code', 'country', 'state_region', 'address_type'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['contact_name', 'street', 'city', 'postal_code', 'country', 'state_region', 'address_type'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }

        $installer->getConnection()->addIndex(
            $installer->getTable('intern_vendor_address'),
            $setup->getIdxName(
                $installer->getTable('intern_vendor_address'),
                ['address_id', 'vendor_id'],
                AdapterInterface::INDEX_TYPE_UNIQUE
            ),
            ['address_id', 'vendor_id'],
            AdapterInterface::INDEX_TYPE_UNIQUE
        );

        $installer->endSetup();
    }
}
