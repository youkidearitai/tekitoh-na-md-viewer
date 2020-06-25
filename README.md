# Tekitoh na Markdown Viewer

Markdown Viewerがほしかったので簡単に作る。動かすには[自作extension](https://github.com/youkidearitai/study_extension)が必要

## INSTALL

    $ composer install
    $ composer dump-autoload

ローカルで動かすことしか想定してない。PHP 7.4にstudy\_extensionを加えてコンパイル

## markdownを閲覧する

1. `/view/templates/` ディレクトリに Markdownファイル をおく
2. /text/(1のファイル名)を閲覧する
    + 例として `shakyou_dump_3.md` を `/view/templates/` に設置すると `/text/shakyou_dump_3.md` で読める

## うごかす

    $ php -S localhost:8080 -t public/ public/index.php

ローカルで動かすことしか想定してない

