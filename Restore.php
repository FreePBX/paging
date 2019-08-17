<?php
namespace FreePBX\modules\Paging;
use FreePBX\modules\Backup as Base;
class Restore Extends Base\RestoreBase{
	public function runRestore(){
		$configs = $this->getConfigs();
		foreach ($configs['data'] as $group) {
			$this->FreePBX->Paging->addGroup($group['page_group'], reset($group['plist']), $group['force_page'], $group['duplex'], $group['description'], $group['is_default'], $group['announcement'], $group['volume']);
		}
		$this->importKVStore($configs['kvstore']);
		$this->importFeatureCodes($configs['features']);
	}
	public function processLegacy($pdo, $data, $tables, $unknownTables){
		$this->restoreLegacyAll($pdo);
	}
}
