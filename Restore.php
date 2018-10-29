<?php
namespace FreePBX\modules\Paging;
use FreePBX\modules\Backup as Base;
class Restore Extends Base\RestoreBase{
  public function runRestore($jobid){
    $configs = reset($this->getConfigs());
    foreach ($configs as $group) {
        $this->FreePBX->Paging->addGroup($group['page_group'], reset($group['plist']), $group['force_page'], $group['duplex'], $group['description'], $group['is_default'], $group['announcement'], $group['volume']);
    }
  }
  public function processLegacy($pdo, $data, $tables, $unknownTables, $tmpfiledir){
    $tables = array_flip($tables + $unknownTables);
    if (!isset($tables['paging_config'])) {
      return $this;
    }
    $cb = $this->FreePBX->Paging;
    $cb->setDatabase($pdo);
    $groups = $cb->listGroups(true);

    $configs = array();
    foreach ($groups as $group) {
      $group['plist'] = $cb->getPageGroupById($group['page_group']);
      $configs[] = $group;
    }
    $cb->resetDatabase();
    foreach ($configs as $group) {
      $cb->addGroup($group['page_group'], $group['plist'], $group['force_page'], $group['duplex'], $group['description'], $group['is_default'], $group['announcement'], $group['volume']);
    }
    return $this;
  }
}
