# dump関数3

今回はPHPのarrayを実装していくぞ。

+ [前準備](/views/817)
+ [その1 boolとnull](/views/820)
+ [その2 integerとfloat、string、resource](/views/821)
+ [その3 array](/view/822) 今ここ

## Arrayを実装する

Arrayは様々な変数を一つにまとめられるデータ型なので、今まで一つの関数でやっていたことを他の関数にまとめるように作り変えとこう。

今までのコードを書いてると、こんな事になっているはず

    PHP_FUNCTION(study_extension_dump)
    {
        zval *zv_ptr;
        int argc, i;

        ZEND_PARSE_PARAMETERS_START(1, -1)
            Z_PARAM_VARIADIC('+', zv_ptr, argc)
        ZEND_PARSE_PARAMETERS_END();

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
            case IS_LONG:
                php_printf("LONG: " ZEND_LONG_FMT "\n", Z_LVAL_P(zv_ptr));
                break;
            case IS_DOUBLE:
                php_printf("DOUBLE: %.*G\n", EG(precision), Z_DVAL_P(zv_ptr));
                break;
            case IS_STRING:
                php_printf("STRING: value=\"");
                PHPWRITE(Z_STRVAL_P(struc), Z_STRLEN_P(zv_ptr));
                php_printf("\", length=%zd\n", Z_STRLEN_P(zv_ptr));
                break;
            case IS_RESOURCE: {
                const char *type_name = zend_rsrc_list_get_rsrc_type(Z_RES_P(zv_ptr));
                php_printf("RESOURCE: id=%d type=%s\n", Z_RES_P(struc)->handle, type_name ? type_name : "Unknown");
                break;
            }
            case default:
                php_printf("UNKNOWN\n");
                break;
        }
    }

ここからarrayを追加したいのだけど、arrayは更にarrayを重ねられる

    $values = array(
        array(
            array(
                "value",
            ),
        ),
    );

arrayの値は任意の型にできるので、arrayとわかったらまた次の値を調べてなんかのスカラー型だったら該当するデータ型を今まで実装したとおりにprintするし、arrayだったらまた繰り返す。繰り返すということは、何らかの方法でループしたい。では何が考えられるのだろうと思ったときにext/standard/var.cを見てみるとそもそも関数に分けて再帰をしていることがわかる。

写経なのだから同じように書けばいいじゃないか、というのもわかるけど、ソースの内容を理解するためにわかりやすくしたので書き直す方法をとった。今更すまないとおもう。

というわけで、関数を分けていこう。実際に出力する関数はstudy\_extension\_var\_dump関数としよう。

    PHPAPI void study_extension_var_dump(zval *struc, int level)
    {
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
            case IS_LONG:
                php_printf("LONG: " ZEND_LONG_FMT "\n", Z_LVAL_P(struc));
                break;
            case IS_DOUBLE:
                php_printf("DOUBLE: %.*G\n", EG(precision), Z_DVAL_P(struc));
                break;
            case IS_STRING:
                php_printf("STRING: value=\"");
                PHPWRITE(Z_STRVAL_P(struc), Z_STRLEN_P(struc));
                php_printf("\", length=%zd\n", Z_STRLEN_P(struc));
                break;
            case IS_RESOURCE: {
                const char *type_name = zend_rsrc_list_get_rsrc_type(Z_RES_P(struc));
                php_printf("RESOURCE: id=%d type=%s\n", Z_RES_P(struc)->handle, type_name ? type_name : "Unknown");
                break;
            }
            case default:
                php_printf("UNKNOWN\n");
                break;
        }
    }

今までのstudy\_extension\_dump関数はこうなる

    PHP_FUNCTION(study_extension_dump)
    {
        zval *zv_ptr;
        int argc, i;

        ZEND_PARSE_PARAMETERS_START(1, -1)
            Z_PARAM_VARIADIC('+', zv_ptr, argc)
        ZEND_PARSE_PARAMETERS_END();

        for (i = 0; i < argc; i++) {
            study_extension_var_dump(&zv_ptr[i], 1);
        }
    }

実は、ZEND\_PARSE\_PARAMETERS\_STARTの引数それぞれ1と-1で、これは「1つ以上、上限なし」を意味している。今までのやり方では引数は一つしか受け入れていないことになっていて、それをfor文で回して一つ一つ引数を出力していく方法に変更している。今まで黙ってて本当に申し訳ない。

したがって、for文のところは、PHPのユーザーランドでいえば次のような文でいうところの、引数を処理していることになる。

    <?php
    study_extension_dump("abc", "def");
    ?>


