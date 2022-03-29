<?php
namespace Intern\Vendor\Setup;

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
                $installer->getTable( 'intern_vendor_entity' ),
                'cc_emails',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    'nullable' => true,
                    'comment' => 'cc_emails',
                    'after' => 'email'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable( 'intern_vendor_entity' ),
                'currency',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' => 'currency',
                    'after' => 'cc_emails'
                ]
            );
            $installer->getConnection()->addColumn(
                $installer->getTable( 'intern_vendor_entity' ),
                'notify_orders',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    'nullable' => true,
                    'comment' => 'notify_orders',
                    'after' => 'currency'
                ]
            );
        }

        $installer->endSetup();
    }
}
