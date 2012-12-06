opSkinThemePlugin概要
======================
スキンテーマ管理機能を追加します

スクリーンショット
------

![SS](http://p.pne.jp/it/?w=200&h=150)![SS](http://p.pne.jp/it/?w=200&h=150)![SS](http://p.pne.jp/it/?w=200&h=150)![SS](http://p.pne.jp/it/?w=200&h=150)


使用方法
------
* スキンテーマを有効にする
  管理画面にログイン後 スキンプラグイン設定画面にアクセスします。(プラグイン設定 -> スキンプラグイン設定)
  スキンプラグイン設定画面で、opSkinThemePluginを有効にします。

* 使用するテーマを選択する
  スキンテーマを有効にした後に、スキンプラグイン設定画面からopSkinThemePluginの設定画面にアクセスします。
  opSkinThemePluginの設定画面から、使用する

* テーマの設置方法
  plugins/opSkinThemePlugin/web 以下のディレクトリにテーマで使用する,CSS,JavaScript,画像ファイルがあるディレクトリを作成してください。
　CSSのファイルはcssディレクトリの中に作成してください
  JavaScriptのファイルはjsディレクトリの中に作成してください

  テーマディレクトリには、必ず cssディレクトリを作成して、そのディレクトリにmain.cssを作成してください。
  main.cssがないとテーマディレクトリとして認識しません。

  テーマディレクトリのサンプルレイアウト構成
  css/
   main.css
   top.css
  js/
   theme.js
  image/
   top.gif


・テーマの情報を設定する方法
css/main.cssファイルに以下のコメントを追記してください。

/*
Theme Name:[テーマの名称]
Theme URI:[テーマのURI]
Description:[テーマの説明]
Author:[テーマの制作者]
Version:[テーマのバージョン]
*/

 
インストール方法
----------------

pluginsディレクトリに設置してください。

プラグインをインストールしたら、OpenPNEのトップディレクトリに移動して、
以下のコマンドを実行し、opSkinThemePluginのwebディレクトリ以下のファイルを公開ディレクトリにコピーしてください。
./symfony plugin:publish-assets


更新履歴
--------


  
要望・フィードバック
----------
https://github.com/tejima/ProjectTemplate/issues
