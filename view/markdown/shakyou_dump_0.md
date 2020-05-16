 	

もくじ
===

- [前準備](/views/817) 今ここ
- [その1 boolとnull](/views/820)
- [その2 integerとfloat、string、resource](/views/821)
 
このstudy\_extensionはGitHubにおいてます: [https://github.com/youkidearitai/study\_extension](https://github.com/youkidearitai/study_extension)

PHPを理解したい
=========

php-srcの一部でも理解したいと思ったとき、さらなる深堀りをするにはどうしたらよいか。

プログラミングを理解するとき、人は写経を行う。php-srcもプログラムである。php-srcを理解するには写経がよいのではないか。

この関数ならばzval構造体の使い方がわかるのではないか、ということで写経をしてみようと思い立った。

下準備
---

php-srcのソースは、GitHubからgit cloneで取得するのが良い。php-srcは毎日と言っていいほど何らかの変更が加えられているので、その差分だけを取得すると、ソースの動向を追いやすい。

すべてをgit cloneで取得するのは大変だ、ということであれば、何らかの方法使って取得を限定するとよいと思うけど、例えばこのブロックの挙動がわからないときにgit blameやgit logで参照できると良いので、すべて取得している。

php-srcのコードを写経するとしたら何が良いだろうと思ったけれども、php-srcを直接手を入れたくないので、extensionを作るのが良いだろう。写経をするのだから、ハマったときに写経の元のソースがそのまま閲覧できるのでよいと思う。

### 作成する環境について

手元の環境は次のようにする。

- extensionの名前はstudy\_extensionとする
- WSL上のUbuntuにコンパイルに必要なものをapt installする
- PHP-7.4ブランチ
- コンパイルしたPHPは$HOME/php74に格納する
 
その結果、コンパイルオプションは次のようになるはず。

 ```
$ cat config.nice
#! /bin/sh
#
# Created by configure

'./configure' \
'--enable-debug' \
'--with-pear' \
'--enable-mbstring' \
'--enable-intl' \
'--prefix=/home/tekimen/php74' \
'--with-openssl' \
'--with-zlib' \
"$@"

```

デバッグがしたいので--enable-debugオプションを追加する。

また、make installした先を、$HOME/php74 とするので--prefix=$HOME/php74、展開されて私の環境では--prefix=/home/tekimen/php74となっている。

これは最終的には--enable-study\_extensionが入るけど、まだ次の工程でPHPが必要なので、ひとまずはなしで。

これをconfigure、make、make installすれば、/home/tekimen/php74にphpのコマンド群が入る。

では、それをどのようにして使うのかというと、direnvを使った。 php-srcのあるディレクトリに.envrcを入れておけば、カレントディレクトリがphp-srcのあるディレクトリ以下になったときに自動的にPATHを入れてくれる。

 ```
$ cat .envrc
PATH=$HOME"/php74/bin":$PATH

```

これでmake installしたphpコマンドを扱えるはず。

 ```
$ php -v
PHP 7.4.6-dev (cli) (built: Apr 25 2020 17:04:51) ( NTS DEBUG )
Copyright (c) The PHP Group
Zend Engine v3.4.0, Copyright (c) Zend Technologies

```

### extensionをext\_skel.phpで作成

php-srcを何らかの方法で取得し、コンパイルしてインストールできたら、次からはextensionを作る。extディレクトリに移動して、ext\_skel.phpをphpコマンドで実行する。

 ```
$ cd ext/
$ php ext_skel.php --ext study_extension

```

すると、study\_extensionディレクトリができているので、ビルドすることができるようになっている。

これでphp-srcのディレクトリに戻ってきて、--enable-study\_extensionを加えればビルドができる。なので、ビルドをし直す。

 ```
$ cat config.nice
#! /bin/sh
#
# Created by configure

'./configure' \
'--enable-debug' \
'--enable-study_extension' \
'--with-pear' \
'--enable-mbstring' \
'--enable-intl' \
'--prefix=/home/tekimen/php74' \
'--with-openssl' \
'--with-zlib' \
"$@"

```

このオプションでconfigure、make、make installとして正常にコンパイルできればOK。

### テストケース

makeを行った後、make testコマンドでphp-srcのテストを行うことができる。extensionに限定してビルドすることもできる。

 ```
$ make test TESTS=ext/study_extension

```

こうすると、study\_extensionのtestsディレクトリにあるテストが実行される。

成功するとよいが、失敗する場合には、4種類のファイルが生成される。

- .diff expとoutとの違い
- .exp expected
- .log これらをあわせて見やすくしたもの
- .out actual、出力した結果
 
テストに失敗したときには、これらを照らし合わせて修正していくということになる。

編集するファイルは
---------

編集するファイルは、{extension\_name}.{c,h}となる。つまり、今回の場合はstudy\_extension.cとstudy\_extension.hである。これらを編集していくことになる。

今回はこれで終了、次からはvar\_dumpを実装していけたらいいなと思う。
