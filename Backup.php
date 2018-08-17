<?php
namespace FreePBX\modules\Paging;
use FreePBX\modules\Backup as Base;
class Backup Extends Base\BackupBase{
  public function runBackup($id,$transaction){
    $configs = [];
    $groups = $this->FreePBX->Paging->listGroups(true);

    foreach ($groups as $group) {
        $group['plist'] = $this->FreePBX->Paging->getPageGroupsById($group['page_group']);
        $configs[] = $group;
    }

    $this->addDependency('core');
    $this->addDependency('conferences');
    $this->addConfigs($configs);
  }

}