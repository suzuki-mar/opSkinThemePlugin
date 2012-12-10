テーマの作成方法
================

## テーマディレクトリの作成
plugins/opSkinThemePlugin/web 以下のディレクトリにテーマで使用するファイル(CSS,JavaScript,画像ファイル)がある
  ディレクトリを作成してください。
* CSSのファイルはcssディレクトリの中に作成してください
* JavaScriptのファイルはjsディレクトリの中に作成してください

## テーマディレクトリの作成時に注意すること
テーマディレクトリには、必ず cssディレクトリを作成して、そのディレクトリにmain.cssを作成してください。
  main.cssがないとテーマディレクトリとして認識しません。

## テーマディレクトリのサンプルレイアウト構成
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

## テーマの情報を設定する方法
テーマの情報を設定するには、css/main.cssファイルに以下のコメントを追記してください。

```
/*
Theme Name:[テーマの名称]
Theme URI:[テーマのURI]
Description:[テーマの説明]
Author:[テーマの制作者]
Version:[テーマのバージョン]
*/
```
