# もくじ

+ [前準備](/views/817)
+ [その1 boolとnull](/views/820) 今ここ
+ [その2 integerとfloat、string、resource](/views/821)
 
このstudy\_extensionはGitHubにおいてます: [https://github.com/youkidearitai/study\_extension](https://github.com/youkidearitai/study_extension)

# 関数の写経

[前回](/views/817)では、下準備としてextensionを作った。このextensionにPHPの関数を写経していき、動作を確認していこう。

## var\_dump関数

var\_dump関数は、引数にとった値を出力する関数で、デバッグ目的で使われる関数である。どんな値も引数にできて出力できるということは、様々な型をどう扱えば良いのかわかるということになるはず。

### var\_dump関数の場所

var\_dump関数はどこにあるのか、というとext/standard/var.cにある。grepしてみるとわかる(ヘッダファイルはext/standard/php\_var.h)

 ```
$ grep -r 'PHP_FUNCTION(var_dump' ext
ext/standard/php_var.h:PHP_FUNCTION(var_dump);
ext/standard/var.c:PHP_FUNCTION(var_dump)

```

var\_dump関数は、引数の個数が1以上で、実際に処理している関数はphp\_var\_dumpという関数である。

### 作成する関数のルール

それでは、関数のルールをここで定義しておこう

+ 名前はstudy\_extension\_dumpとする
+ 引数を一つ以上受け取り、dumpする
 
あとはちょくちょく写経していこう。

### 写経のはじめ 何もしない関数

まず、関数を定義する。

 ```
PHP_FUNCTION(study_extension_dump)
{
}

```

その次にzend\_function\_entry構造体にstudy\_extension\_dump関数を登録する。

 ```
static const zend_function_entry study_php_extension_functions[] = {
    PHP_FE(study_php_extension_dump,        NULL)
    PHP_FE_END
};

```

これで関数を定義することができたので、コンパイルすることができる。php-srcのディレクトリに戻ってmakeしてみる。もちろん何もしない。

 ```
$ pwd # カレントディレクトリはここですというのを確認のため表してるだけなので、わかってれば、なくてよい
/home/tekimen/src/php-src
$ make
$ sapi/cli/php -r 'study_extension_dump();'
$

```

これで、関数を作る方法がわかった。

### 引数をとり、boolを出力する

次のステップとして、引数がboolのとき、boolであることとboolの中身(true もしくは false)を表示させるようにする。

(引数を取るだけでもいいのだけど、それだと画面に出ないのでそこまでやってしまおうか)

まずは、変数宣言。

 ```
PHP_FUNCTION(study_extension_dump)
{
    zval *zv_ptr;
    int argc, i;

```

次に引数を受け取る。方法は、ZEND\_PARSE\_PARAMETERS\_STARTから始まるマクロを使用し、ZEND\_PARSE\_PARAMETERS\_ENDで終わるマクロを使用する。その間にZ\_PARAM\_VARIADICをはさみ、引数の値を取得する。

 ```
    ZEND_PARSE_PARAMETERS_START(1, -1)
        Z_PARAM_VARIADIC('+', zv_ptr, argc)
    ZEND_PARSE_PARAMETERS_END();

```

PHP 5.xでは、zend\_parse\_parametersという関数を使っていたのだけど、これよりも速いということでPHP 7.xではこの方法が取られている。詳しく知りたい場合は[PHP: rfc:fast\_zpp](https://wiki.php.net/rfc/fast_zpp)を参照するとよい。個人的には引数のとり方がわかってやりやすい気がする。

zv\_ptrに引数が格納されて、argcに引数の数が格納され。ここに、boolの時の出力を書いていこう。

 ```
    switch(Z_TYPE_P(zv_ptr))
    {
        case IS_TRUE:
            php_printf("BOOL: true\n");
            break;
        case IS_FALSE:
            php_printf("BOOL: false\n");
            break;
        case default:
            php_printf("UNKNOWN\n");
            break;
    }
}

```

この状態でコンパイルして動作を確認すると、boolのdumpができるようになっているはず。

 ```
$ make
$ sapi/cli/php -r 'study_extension_dump(true);'
BOOL: true
$ sapi/cli/php -r 'study_extension_dump(false);'
BOOL: false
$

```

### NULLを出力する

boolを出力したので、同じ要領でNULLを出力しよう。

 ```
    switch(Z_TYPE_P(zv_ptr))
    {
        case IS_NULL:
            php_printf("NULL: null\n");
            break;
        case IS_TRUE:
            php_printf("BOOL: true\n");
            break;
        case IS_FALSE:
            php_printf("BOOL: false\n");
            break;
        case default:
            php_printf("UNKNOWN\n");
            break;
    }

```

NULLが動作しているか、確認してみよう。

 ```
$ make
$ sapi/cli/php -r 'study_extension_dump(null);'
NULL: null
$

```

### テストコードの記述

php-srcでテストを記述したい、と思ったらどうすればいいのだろう。実はテストを記述するための方法が用意されている。

makeをしたあと、「Don't forget to run 'make test'.」というのが流れると思うけれども、この通りにmake testを行うと、php-srcはテストを行う。

ここだけテストがしたい、という場合には次のようにする。

 ```
$ make test TESTS=ext/study_extension/tests

```

テストに関しては、[QAページ](https://qa.php.net/running-tests.php)が詳しい。

実は、エクステンションをext\_skel.phpで作成すると、testsディレクトリが出来上がっていて、その下に001.phptというファイルが出来上がっているはず。これを見てみると、extensionが読み込まれているかというテストになっている。

これを元に、002.phptを作ってみようか。002.phptにももともとなにかあるけど、消してから作り直そう。

 ```
--TEST--
Check study_php_extension_dump function print value
--SKIPIF--
<?php
if (!extension_loaded('study_php_extension')) {
	echo 'skip';
}
?>
--FILE--
<?php
study_php_extension_dump(null);
study_php_extension_dump(true);
study_php_extension_dump(false);
?>
--EXPECT--
NULL: null
BOOL: true
BOOL: false

```

作ったやつのファイルは[ここに追いておく](https://github.com/youkidearitai/study_extension/blob/2896025222dc5c3846b3e25eb3c1bf2f8022de45/tests/002.phpt)

`---TEST---`セクションにテスト項目を記述して、`--FILE--`セクションにコードを書き、`--EXPECT--`に想定する出力を記述していく。

これでmake testをやると、成功するはずである。しなかったら見直してみよう

 ```
$ make test TESTS=ext/study_extension/tests

Build complete.
Don't forget to run 'make test'.


=====================================================================
PHP         : /home/tekimen/src/php-src/sapi/cli/php
PHP_SAPI    : cli
PHP_VERSION : 7.4.6-dev
ZEND_VERSION: 3.4.0
PHP_OS      : Linux - Linux DESKTOP-I76FQM3 4.4.0-18362-Microsoft #476-Microsoft Fri Nov 01 16:53:00 PST 2019 x86_64
INI actual  : /home/tekimen/src/php-src/tmp-php.ini
More .INIs  :
---------------------------------------------------------------------
PHP         : /home/tekimen/src/php-src/sapi/phpdbg/phpdbg
PHP_SAPI    : phpdbg
PHP_VERSION : 7.4.6-dev
ZEND_VERSION: 3.4.0
PHP_OS      : Linux - Linux DESKTOP-I76FQM3 4.4.0-18362-Microsoft #476-Microsoft Fri Nov 01 16:53:00 PST 2019 x86_64
INI actual  : /home/tekimen/src/php-src/tmp-php.ini
More .INIs  :
---------------------------------------------------------------------
CWD         : /home/tekimen/src/php-src
Extra dirs  :
VALGRIND    : Not used
=====================================================================
Running selected tests.
PASS Check if study_extension is loaded [ext/study_extension/tests/001.phpt]
PASS Check study_extension_dump function print value [ext/study_extension/tests/002.phpt]

```

このような感じになっているだろうか。

## 今回はここまで

次は他のデータ型を実装していこうか。
