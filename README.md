PHP BACKUP
---------------

用來備份 MySQL 資料的程式

##初使化

  - 複製 config.php.dist 為 config.php
  - 依設定檔方式依序填入 MySQL 的帳密資訊

```bash
$cfg['Site'][1]['host'] = 'localhost';

$cfg['Site'][1]['user'] = 'root';

$cfg['Site'][1]['password'] = '0000';

$cfg['Site'][1]['database'] = 'Site1data';
```

如果有第二個網站也要備份，則請設定成

```bash
$cfg['Site'][2]['host'] = 'localhost';

$cfg['Site'][2]['user'] = 'root';

$cfg['Site'][2]['password'] = '0000';

$cfg['Site'][2]['database'] = 'Site2data';
```

  - 開關測試模式

```bash

$cfg['TestMode'] = 1;

```

  - 指定 mysqldump 指令

```bash

$cfg['MysqlDump_locate'] = '/Applications/AMPPS/mysql/bin/mysqldump';

```

## 使用方式

```bash
$php phpmysqlbackup.php
```

## 使用於自動排程中

   - 啟用 crontab 編輯器

```bash
$ crontab -e
```

  - 加入指令，如每天半夜3點30分執行備份

```bash
30  3  *  *  *  php /path/to/phpmysqlbackup.php
```

## 備份路徑

於本程式下的 backups 目錄中
