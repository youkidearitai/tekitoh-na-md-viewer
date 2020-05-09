# dump関数2

[前回](/views/820)では、boolとnullを出力できるようにしたので、今回はintegerとstring、resourceとスカラー型をとりあえず実装してからarrayを実装しよう。

+ [前準備](/views/817)
+ [その1 boolとnull](/views/820)
+ [その2 integerとfloat、string、resource](/views/821) 今ここ

## Integer(LONG)を追加する

今回は、前回の続き。次のswitch文に記述を続けていく。

    switch(Z_TYPE_P(struc))
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
        default:
            php_printf("UNKWOWN\n");
            break;
    }

次はIntegerを追加していこう。次のcaseを追加する。

        case IS_LONG:
            php_printf("LONG: " ZEND_LONG_FMT "\n", Z_LVAL_P(struc));
            break;

php\_printf関数というのは、printf関数とほぼ同じように使えるため、%dとかが使える。第二引数に実際の値を入れていく。printfと同じと思えばそう読めると思う。

しかしながら、なぜこうなっているのかという、疑問点がわいてくるのではないか。

+ php\_printfとは何か
+ ZEND\_LONG\_FMTとは何か
+ Z\_LVAL\_Pとは何か

### php\_printfとは何か

このphp\_printfを追いかけていくと、Zend/zend.cのzend\_vsprintfという関数にたどり着く。この関数はzend\_utility\_functions構造体のprintf\_to\_smart\_string\_functionにたどり着く。これは関数ポインタなので、それを更に追いかけていくとmain/spprintf.cにphp\_printf\_to\_smart\_string関数へとたどり着く。xbuf\_format\_converterという関数が、実際に処理を行っている関数となる。

    TODO: xbuf_format_converterは本当に行き着くかデバッガかける。関数ポインタなので別かも

そして、vspprintf関数の処理が終わったらPHPWRITEマクロで出力される。とりあえずは、ざっくりこのような形で良いでしょう。

### ZEND\_LONG\_FMTとは何か

php\_printfではprintfのように使っても特に問題はないので、次のように書いても問題がないようにみえる。

        case IS_LONG:
            php_printf("LONG: %ld\n", Z_LVAL_P(struc));
            break;

しかし、これをMacでコンパイルするとWarningが出るはずである。これを回避するためにはプラットフォームごとに変換指定子を変える必要があるけど、それはもともとZEND\_LONG\_FMTを使うことで解決できるというわけである。

また、C言語の文字列リテラルを区切り文字を続けると文字列はコンパイル時に連結される。


### Z\_LVAL\_Pとは何か

今までの知識からわかることとして、php\_printf関数の第二引数として見れば、これは実際の値であることがわかる。strucはzval構造体へのポインターであることがわかる。そのzval構造体を読んでみると、実際の値はzend\_value構造体であることがわかる。そこにあるlong型の値はlvalで確保されている。

Z\_LVAL\_Pはマクロなのでそれを参照するとこうなっている。

<https://github.com/php/php-src/blob/php-7.4.4/Zend/zend_types.h#L678>

    #define Z_LVAL(zval)				(zval).value.lval
    #define Z_LVAL_P(zval_p)			Z_LVAL(*(zval_p))

つまり、Z\_LVAL\_P(struc)は展開するとこうなる

    *(struc).value.lval

## Float(double)を追加する

Integerを追加したのだから、Floatを追加するのも想像はつくだろうか。

PHPの浮動小数点は倍精度だけどFloatと名付けられている。Cの倍精度浮動小数点はdoubleである。また、php-src上ではIS\_DOUBLEとなっている。

        case IS_DOUBLE:
            php_printf("DOUBLE: %.*G\n", EG(precision), Z_DVAL_P(struc));
            break;

もちろん、やはり疑問点は出てくる。こんなものだろうか？

+ EG\(precision\)って何？
+ php\_printfの%.\*Gって何？

### EG\(precision\)って何？

まず、EG\(precision\)とはなんなのかというと、zend\_executor\_globalsという構造体のprecisionのことで、main/main.cにはPHP\_INI\_MH\(OnSetPrecision\)という関数がある。

    PHP_INI_MH(OnSetPrecision)

PHP\_INI\_MHはphp.iniの設定をする関数でOnSetPrecisionを検索すると、PHP\_INI\_ENTRYがある。これをもとにphp.iniの設定をする。なければデフォルト値の第二引数を設定する。

    PHP_INI_ENTRY("precision",					"14",		PHP_INI_ALL,		OnSetPrecision)

つまり、php.iniの設定であるprecisionを設定すると写経しているこの関数も、var\_dump関数も変わるということになる。試してみよう


    $ php -r 'var_dump(3.3); ini_set("precision", 17); var_dump(3.3);'
    float(3.3)
    float(3.2999999999999998)

3.3は2進数では表現がしきれないため、14桁のデフォルトでは3.3と表示されるのだが、17桁になると3.2999999999999998となり、18桁では3.29999999999999982となる。つまり18桁目で四捨五入されると3.3では無くなってしまうようだ。（計算すれば良いんだよな）

### php\_printfの%.\*Gって何？

php\_printf関数の%.\*Gは何なのか。xbuf\_format\_converterを見てみる。

+ .はprecision。次の文字が数字ならばその数字がprecisionになる
+ \*はint型の引数を受け取り、precisionとする
+ EG\(precision\)が引数となっているので、php.iniのprecisionが桁数となる
+ Gは指数表示のEを表示させる。gの場合はeを表示させる

そこから、php\_gcvtという関数に渡される。この関数が実際に浮動少数点数を文字列に変える関数に渡す。

<!-- zend\_dtoaという関数である。Zend/zend\_strtod.cにある。"How to Print Floating-Point Numbers Accurately"という論文を参考にしているそうだ。 -->

## Stringを追加する

文字列も出力できるようにしよう。

        case IS_STRING:
            php_printf("STRING: value=\"");
            PHPWRITE(Z_STRVAL_P(struc), Z_STRLEN_P(struc));
            php_printf("\", length=%zd\n", Z_STRLEN_P(struc));
            break;

PHPWRITEというマクロは、文字列を出力するのにかんたんに出力できる関数。php\_printfと比べると処理数が少ない。また、PHPの文字列は、バイナリセーフであるので、C言語で終端文字として使われる\\0\(NUL\)が使われることもある。その関係だと思うけど第二引数には文字の長さを指定する必要がある。

その後のphp\_printfでは、文字列の長さを出力させている。%zdとは、zが引数をsize\_tで受け取ることを要求させる。次のdで数値を要求させる。これによって長さを出力できるわけだ。

### zval構造体の文字列

文字列の扱い方はzval構造体ではどうなっているのだろう？

zval構造体ではzend\_value構造体のzend\_string構造体へアクセスする。

zend\_stringはZend/zend\_types.hで次のようになっていて、今出力させるのに重要なのがlenとvalだ。

    struct _zend_string {
        zend_refcounted_h gc;
        zend_ulong        h;                /* hash value */
        size_t            len;
        char              val[1];
    };

lenが長さである。valがその文字列となる。しかしおかしいことに気がつくだろうか。val\[1\]となっていて明らかに短いのでは？と思うかもしれない。これはC struct hackと呼ばれているテクニックで、サイズが明確に指定されていない配列になる。

このzend\_stringのvalを文字列としてgdbで読もうとするとこうなる。

    TODO: このstringで正しく読む方法を調べる
    >>> print &(*struc.value.val)

#### 参考

+ <https://www.jpcert.or.jp/sc-rules/c-dcl38-c.html>
+ <http://www.phpinternalsbook.com/php7/internal_types/strings/zend_strings.html>
