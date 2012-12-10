opSkinThemePlugin
======================

## 機能概要
テーマを変更する事によって、スキンを変更することができる機能を追加します。

## スクリーンショット
### 設定フォーム
![SS](https://raw.github.com/suzuki-mar/opSkinThemePlugin/master/doc/img/setting.png)
### サンプルテーマ
![SS](https://raw.github.com/suzuki-mar/opSkinThemePlugin/master/doc/img/united.png) ![SS](https://raw.github.com/suzuki-mar/opSkinThemePlugin/master/doc/img/cerulean.png)

## インストール方法
1. 以下のコマンドを実行して、プラグインをインストールしてください。
 * ./symfony opPlugin:install opSkinThemePlugin -r 1.0.0
2. 以下のコマンドを実行し、opSkinThemePluginのwebディレクトリ以下のファイルを公開ディレクトリにコピーしてください
 * ./symfony plugin:publish-assets

## プラグインの使用方法

### スキンテーマを有効にする
管理画面にログイン後 スキンプラグイン設定画面にアクセスします。(プラグイン設定 -> スキンプラグイン設定)  
  スキンプラグイン設定画面で、opSkinThemePluginを有効にします。

### 使用するテーマを選択する
スキンテーマを有効にした後に、スキンプラグイン設定画面からopSkinThemePluginの設定画面にアクセスします。  
  opSkinThemePluginの設定画面から、使用するテーマを選択してください。       
  テーマの作成方法については次のページを参照ください。[テーマの作成方法について](https://github.com/suzuki-mar/opSkinThemePlugin/blob/master/doc/how_to_make_theme.md)


更新履歴
--------



要望・フィードバック
----------
https://github.com/suzuki-mar/opSkinThemePlugin/issues
