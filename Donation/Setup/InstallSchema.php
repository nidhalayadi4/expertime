<?php

namespace Expertime\Donation\Setup;

use \Magento\Framework\DB\Ddl\Table;
use \Magento\Framework\Setup\InstallSchemaInterface;
use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Framework\Setup\SchemaSetupInterface;
use \Magento\Framework\DB\Adapter\AdapterInterface;

/**
 * Donation Database Setup
 * Class InstallSchema
 * @package Expertime\Donation\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * Database structure initialization
     *
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) {
        $installer = $setup;
        $installer->startSetup();

        $tableName = 'donation_product';

        $tableDonationProduct = $setup->getConnection()->newTable(
            $setup->getTable($tableName)
        );

        $tableDonationProduct->addColumn(
            'entity_id',
            Table::TYPE_INTEGER,
            null,
            [
                'identity' => true,
                'nullable' => false,
                'primary' => true,
                'unsigned' => true,
            ],
            'Entity ID'
        );

        $tableDonationProduct->addColumn(
            'title',
            Table::TYPE_TEXT,
            255,
            [],
            'Title'
        );

        $tableDonationProduct->addColumn(
            'description',
            Table::TYPE_TEXT,
            '64k',
            [],
            'Description'
        );

        $tableDonationProduct->addColumn(
            'sku',
            Table::TYPE_TEXT,
            255,
            [],
            'sku'
        );

        $tableDonationProduct->addColumn(
            'product_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'unsigned' => true],
            'Product Id'
        );

        $tableDonationProduct->addColumn(
            'order_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'unsigned' => true],
            'order_id'
        );

        $tableDonationProduct->addColumn(
            'amount',
            Table::TYPE_DECIMAL,
            '12,4',
            [],
            'amount'
        );

        $tableDonationProduct->addColumn(
            'store_ids',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'default' => "0"],
            'Store Ids'
        );

        $tableDonationProduct->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Creation date'
        );

        $tableDonationProduct->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            'Updated At'
        );

        $indexFields = ['sku', 'title', 'amount', 'product_id'];

        $tableDonationProduct->addIndex(
            $installer->getIdxName($tableName,  $indexFields, AdapterInterface::INDEX_TYPE_FULLTEXT),
            $indexFields,
            AdapterInterface::INDEX_TYPE_FULLTEXT
        );

//        $tableDonationProduct->addForeignKey(
//            $setup->getFkName(
//                'catalog_product_entity', 'entity_id', $tableName,
//                'product_id'
//            ),
//            'product_id',
//            $setup->getTable('catalog_product_entity'),
//            'entity_id',
//            Table::ACTION_CASCADE
//        );

        $tableDonationProduct->setComment('Donation Product Table');

        $setup->getConnection()->createTable($tableDonationProduct);

        $setup->endSetup();
    }
}
