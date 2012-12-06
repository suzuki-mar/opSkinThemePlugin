opSkinThemePlugin
======================

## 機能概要
テーマ(アセット)を変更する事によって、スキンの変更をすることができる機能を追加します。

## スクリーンショット
![SS](https://raw.github.com/suzuki-mar/opSkinThemePlugin/master/doc/img/theme_setting.png)![SS](https://raw.github.com/suzuki-mar/opSkinThemePlugin/master/doc/img/theme.png)


## 使用方法

### スキンテーマを有効にする
管理画面にログイン後 スキンプラグイン設定画面にアクセスします。(プラグイン設定 -> スキンプラグイン設定)  
  スキンプラグイン設定画面で、opSkinThemePluginを有効にします。

### 使用するテーマを選択する
スキンテーマを有効にした後に、スキンプラグイン設定画面からopSkinThemePluginの設定画面にアクセスします。  
  opSkinThemePluginの設定画面から、使用するテーマを選択してください。

### テーマの設置方法
#### テーマディレクトリの作成
plugins/opSkinThemePlugin/web 以下のディレクトリにテーマで使用するアセット(CSS,JavaScript,画像ファイル)がある  
  ディレクトリを作成してください。
* CSSのファイルはcssディレクトリの中に作成してください
* JavaScriptのファイルはjsディレクトリの中に作成してください

#### テーマディレクトリの作成時に注意すること
テーマディレクトリには、必ず cssディレクトリを作成して、そのディレクトリにmain.cssを作成してください。  
  main.cssがないとテーマディレクトリとして認識しません。

#### テーマディレクトリのサンプルレイアウト構成
```
plugins/opSkinManager/web
└── sample
    ├── css
    │   ├── bootstrap.css
    │   └── main.css ← このファイルは必ず作成してください。また、テーマの情報はこのファイルに記述してください。
    ├── img
    │   ├── top.png
    └── js
        └── sample.js
```

### テーマの情報を設定する方法
css/main.cssファイルに以下のコメントを追記してください。

```
/*
Theme Name:[テーマの名称]
Theme URI:[テーマのURI]
Description:[テーマの説明]
Author:[テーマの制作者]
Version:[テーマのバージョン]
*/
```


インストール方法
----------------
1. プラグインのソースコードを以下のサイトからダウンロードして、pluginsディレクトリに設置してください
 * https://github.com/suzuki-mar/opSkinThemePlugin
2. OpenPNEのトップディレクトリに移動してください 
3. 以下のコマンドを実行し、opSkinThemePluginのwebディレクトリ以下のファイルを公開ディレクトリにコピーしてください
 * ./symfony plugin:publish-assets

更新履歴
--------



要望・フィードバック
----------
https://github.com/suzuki-mar/opSkinThemePlugin/issues
