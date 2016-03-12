<?php

class m160312_144707_init extends CDbMigration
{
	public function up()
	{
		$sql = "CREATE TABLE `urls` (
  `id_urls` int(11) unsigned NOT NULL,
  `url` varchar(2000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `shorten` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `used` int(11) unsigned NOT NULL DEFAULT '0',
  `created_at` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		$this->getDbConnection()->createCommand($sql)->execute();

		$sql = "ALTER TABLE `urls`
  ADD PRIMARY KEY (`id_urls`),
  ADD UNIQUE KEY `short` (`shorten`);";
		$this->getDbConnection()->createCommand($sql)->execute();

		$sql = "ALTER TABLE `urls`
  MODIFY `id_urls` int(11) unsigned NOT NULL AUTO_INCREMENT;";
		$this->getDbConnection()->createCommand($sql)->execute();
	}

	public function down()
	{
		$sql = "DROP TABLE `urls`";
		$this->getDbConnection()->createCommand($sql)->execute();
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}