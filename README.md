# paiza env php

## これはなに？
[paiza](https://paiza.jp/)のスキルチェック用の環境作成ツールです。

- クラス単位でファイルを分割できます。
- ユニットテストを書けます。

雑な実装をしているので、変な書き方をすると上手く変換できない場合があります。

## インストール方法
```bash
$ git clone https://github.com/chiroruxx/paiza-env-php.git
$ cd paiza-env-php
$ composer install
```

## 使い方
ここでは、D01番の問題を解く例で説明します。

### ディレクトリの作成
まず、解く問題用のディレクトリを作成します。

```bash
$ php service/command.php paiza:make D01
```

すると、 `src/D01` というディレクトリが作成されます。  
また、スタブとして `src/D01/main.php` というファイルが作成されます。

### 問題を解く
このディレクトリ内で好きに問題を解きましょう。  
クラスを別のファイルで定義してもかまいません。  
また、 `tests` ディレクトリ内でテストを書いても大丈夫です。

### 変換する
問題が解けたら、書いたコードを変換します。

```bash
$ php service/command.php paiza:compile D01
```

実行すると、すべてのファイルがひとつのファイルにまとめられ、 `compiled/D01.php` というファイルになります。  
このコードをpaizaの回答欄にコピペし、提出や事前チェックを行います。
