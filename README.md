PHP BACKUP
---------------

用來備份 MySQL 資料的程式

##初使化

  - 複製 config.php.dist 為 config.php
  - 依設定檔方式依序填入 MySQL 的帳密資訊
  - 需要建立 RSA key 與主從端相互認證

```bash

$i++;

$cfg['Site'][$i]['SiteName'] = 'SiteName';

$cfg['Site'][$i]['Host'] = 'localhost';

$cfg['Site'][$i]['User'] = 'root';

$cfg['Site'][$i]['PassWord'] = 'password';

$cfg['Site'][$i]['DataBase'] = 'database name';

$cfg['Site'][$i]['SitePath'] = '/var/www/site/path';

$cfg['Site'][$i]['MediaDirs'] = 'media,images';

```

如果有第二個網站也要備份，則請設定成

```bash

$i++;

$cfg['Site'][$i]['SiteName'] = 'SiteName2';

$cfg['Site'][$i]['Host'] = 'localhost';

$cfg['Site'][$i]['User'] = 'root2';

$cfg['Site'][$i]['PassWord'] = 'password2';

$cfg['Site'][$i]['DataBase'] = 'database name 2';

$cfg['Site'][$i]['SitePath'] = '/var/www/site2/path';

$cfg['Site'][$i]['MediaDirs'] = 'media,images';

```

設定遠端備份目地

```bash

$i++;

$cfg['Storage'][$i]['HostAdd'] = '192.168.1.122';

$cfg['Storage'][$i]['User'] = 'rsync';

$cfg['Storage'][$i]['DestPath'] = '/path/to/backups';

```

  - 開關測試模式

```bash

$cfg['TestMode'] = 1;

```

  - 指定 mysqldump 指令

```bash

$cfg['MysqlDump_locate'] = '/locat/to/path/mysqldump or mysqldump';

```

## 使用方式

```bash
$php console.php command
```

## 使用於自動排程中

   - 啟用 crontab 編輯器

```bash
$ crontab -e
```

  - 加入指令，如每天半夜3點30分執行備份

```bash
30  3  *  *  *  php /path/to/console.php doall
```

## 備份路徑

於本程式下的 backups 目錄中
