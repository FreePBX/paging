<?php
namespace FreePBX\modules\Paging;
use FreePBX\modules\Backup as Base;
class Backup Extends Base\BackupBase{
	public function runBackup($id,$transaction){
		$data = [];
		$groups = $this->FreePBX->Paging->listGroups(true);

		foreach ($groups as $group) {
				$group['plist'] = paging_get_devs($group['page_group']);
				$data[] = $group;
		}

		$this->addDependency('core');
		$this->addDependency('conferences');
		$this->addConfigs([
			'data' => $data,
			'kvstore' => $this->dumpKVStore(),
			'features' => $this->dumpFeatureCodes()
		]);
	}

}
