<?php

$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('genmato_core/logging'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
            'auto_increment' => true,
        ),
        'Entity Id'
    )
    ->addColumn('createdate', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Create date')
    ->addColumn('source', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(), 'Source')
    ->addColumn('level', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(), 'Level')
    ->addColumn('message', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(), 'Message')
    ->addColumn('extra', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(), 'Extra details')
    ->addColumn('reference', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(), 'Reference');

$installer->getConnection()->createTable($table);

$installer->endSetup();