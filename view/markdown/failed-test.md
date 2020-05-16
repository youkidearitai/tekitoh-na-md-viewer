    =====================================================================
    EXPECTED FAILED TEST SUMMARY
    ---------------------------------------------------------------------
    Test open_basedir configuration [tests/security/open_basedir_linkinfo.phpt]  XFAIL REASON: BUG: open_basedir cannot delete symlink to prohibited file. See also
    bugs 48111 and 52176.
    Inconsistencies when accessing protected members [Zend/tests/access_modifiers_008.phpt]  XFAIL REASON: Discussion: http://marc.info/?l=php-internals&m=120221184420957&w=2
    Inconsistencies when accessing protected members - 2 [Zend/tests/access_modifiers_009.phpt]  XFAIL REASON: Discussion: http://marc.info/?l=php-internals&m=120221184420957&w=2
    Bug #48770 (call_user_func_array() fails to call parent from inheriting class) [Zend/tests/bug48770.phpt]  XFAIL REASON: See Bug #48770
    Bug #48770 (call_user_func_array() fails to call parent from inheriting class) [Zend/tests/bug48770_2.phpt]  XFAIL REASON: See Bug #48770
    Bug #48770 (call_user_func_array() fails to call parent from inheriting class) [Zend/tests/bug48770_3.phpt]  XFAIL REASON: See Bug #48770
    Initial value of static var in method depends on the include time of the class definition [Zend/tests/method_static_var.phpt]  XFAIL REASON: Maybe not a bug
    DateTime::add() -- fall type2 type3 [ext/date/tests/DateTime_add-fall-type2-type3.phpt]  XFAIL REASON: Various bugs exist
    DateTime::add() -- fall type3 type2 [ext/date/tests/DateTime_add-fall-type3-type2.phpt]  XFAIL REASON: Various bugs exist
    DateTime::add() -- fall type3 type3 [ext/date/tests/DateTime_add-fall-type3-type3.phpt]  XFAIL REASON: Various bugs exist
    DateTime::add() -- spring type2 type3 [ext/date/tests/DateTime_add-spring-type2-type3.phpt]  XFAIL REASON: Various bugs exist
    DateTime::add() -- spring type3 type2 [ext/date/tests/DateTime_add-spring-type3-type2.phpt]  XFAIL REASON: Various bugs exist
    DateTime::add() -- spring type3 type3 [ext/date/tests/DateTime_add-spring-type3-type3.phpt]  XFAIL REASON: Various bugs exist
    DateTime::diff() -- fall type2 type3 [ext/date/tests/DateTime_diff-fall-type2-type3.phpt]  XFAIL REASON: Various bugs exist
    DateTime::diff() -- fall type3 type2 [ext/date/tests/DateTime_diff-fall-type3-type2.phpt]  XFAIL REASON: Various bugs exist
    DateTime::diff() -- fall type3 type3 [ext/date/tests/DateTime_diff-fall-type3-type3.phpt]  XFAIL REASON: Various bugs exist
    DateTime::diff() -- spring type2 type3 [ext/date/tests/DateTime_diff-spring-type2-type3.phpt]  XFAIL REASON: Various bugs exist
    DateTime::diff() -- spring type3 type2 [ext/date/tests/DateTime_diff-spring-type3-type2.phpt]  XFAIL REASON: Various bugs exist
    DateTime::diff() -- spring type3 type3 [ext/date/tests/DateTime_diff-spring-type3-type3.phpt]  XFAIL REASON: Various bugs exist
    DateTime::sub() -- fall type2 type3 [ext/date/tests/DateTime_sub-fall-type2-type3.phpt]  XFAIL REASON: Various bugs exist
    DateTime::sub() -- fall type3 type2 [ext/date/tests/DateTime_sub-fall-type3-type2.phpt]  XFAIL REASON: Various bugs exist
    DateTime::sub() -- fall type3 type3 [ext/date/tests/DateTime_sub-fall-type3-type3.phpt]  XFAIL REASON: Various bugs exist
    DateTime::sub() -- spring type2 type3 [ext/date/tests/DateTime_sub-spring-type2-type3.phpt]  XFAIL REASON: Various bugs exist
    DateTime::sub() -- spring type3 type2 [ext/date/tests/DateTime_sub-spring-type3-type2.phpt]  XFAIL REASON: Various bugs exist
    DateTime::sub() -- spring type3 type3 [ext/date/tests/DateTime_sub-spring-type3-type3.phpt]  XFAIL REASON: Various bugs exist
    Bug #52480 (Incorrect difference using DateInterval) [ext/date/tests/bug52480.phpt]  XFAIL REASON: See https://bugs.php.net/bug.php?id=52480
    RFC: DateTime and Daylight Saving Time Transitions (zone type 3, bd2) [ext/date/tests/rfc-datetime_and_daylight_saving_time-type3-bd2.phpt]  XFAIL REASON: Still not quite right
    RFC: DateTime and Daylight Saving Time Transitions (zone type 3, fs) [ext/date/tests/rfc-datetime_and_daylight_saving_time-type3-fs.phpt]  XFAIL REASON: Still not quite right
    Bug #42718 (unsafe_raw filter not applied when configured as default filter) [ext/filter/tests/bug42718.phpt]  XFAIL REASON: FILTER_UNSAFE_RAW not applied when configured as default filter, even with flags
    Bug #67296 (filter_input doesn't validate variables) [ext/filter/tests/bug49184.phpt]  XFAIL REASON: See Bug #49184
    Bug #67167: filter_var(null,FILTER_VALIDATE_BOOLEAN,FILTER_NULL_ON_FAILURE) returns null [ext/filter/tests/bug67167.02.phpt]  XFAIL REASON: Requires php_zval_filter to not use convert_to_string for all filters.
    via [ext/pdo_sqlite/tests/common.phpt]
            SQLite PDO Common: PDOStatement::getColumnMeta [ext/pdo_sqlite/tests/pdo_022.phpt]  XFAIL REASON: This feature is not yet finalized, no test makes sense
    Phar: bug #69958: Segfault in Phar::convertToData on invalid file [ext/phar/tests/bug69958.phpt]  XFAIL REASON: Still has memory leaks, see https://bugs.php.net/bug.php?id=70005
    updateTimestamp never called when session data is empty [ext/session/tests/bug71162.phpt]  XFAIL REASON: Current session module is designed to write empty session always. In addition, current session module only supports SessionHandlerInterface only from PHP 7.0.
    Bug #73529 session_decode() silently fails on wrong input [ext/session/tests/bug73529.phpt]  XFAIL REASON: session_decode() does not return proper status.
    =====================================================================

    =====================================================================
    FAILED TEST SUMMARY
    ---------------------------------------------------------------------
    Timeout within while loop [tests/basic/timeout_variation_0.phpt]
    Timeout within for loop [tests/basic/timeout_variation_7.phpt]
    Timeout within foreach loop [tests/basic/timeout_variation_8.phpt]
    Testing register_shutdown_function() with timeout. (Bug: #21513) [tests/func/005a.phpt]
    Timeout again inside register_shutdown_function [tests/lang/045.phpt]
    Bug #74093 (Maximum execution time of n+2 seconds exceed not written in error_log) [Zend/tests/bug74093.phpt]
    Tests for DateTimeImmutable. [ext/date/tests/date_time_immutable.phpt]
    Bug #34276 (setAttributeNS and default namespace) [ext/dom/tests/bug34276.phpt]
    Test 2: getElementsByTagName() / getElementsByTagNameNS() [ext/dom/tests/dom002.phpt]
    locale_get_keywords() bug #12887 [ext/intl/tests/bug12887.phpt]
    Bug #14562 NumberFormatter breaks when locale changes [ext/intl/tests/bug14562.phpt]
    Bug #67397 (Buffer overflow in locale_get_display_name->uloc_getDisplayName (libicu 4.8.1)) [ext/intl/tests/bug67397.phpt]
    Bug #72533 (locale_accept_from_http out-of-bounds access) [ext/intl/tests/bug72533.phpt]
    Collation customization [ext/intl/tests/collation_customization.phpt]
    asort() [ext/intl/tests/collator_asort_variant2.phpt]
    compare() [ext/intl/tests/collator_compare_variant2.phpt]
    create() icu >= 53.1 [ext/intl/tests/collator_create4.phpt]
    get_error_code() [ext/intl/tests/collator_get_error_code.phpt]
    get_error_message() [ext/intl/tests/collator_get_error_message.phpt]
    get_locale() icu >= 4.8 [ext/intl/tests/collator_get_locale2.phpt]
    get/set_attribute() [ext/intl/tests/collator_get_set_attribute.phpt]
    get/set_strength() [ext/intl/tests/collator_get_set_strength.phpt]
    collator_get_sort_key() icu >= 62.1 [ext/intl/tests/collator_get_sort_key_variant7.phpt]
    sort() [ext/intl/tests/collator_sort_variant2.phpt]
    sort_with_sort_keys() [ext/intl/tests/collator_sort_with_sort_keys_variant2.phpt]
    Cloning datefmt icu >= 4.8 [ext/intl/tests/dateformat_clone2.phpt]
    datefmt_format_code() and datefmt_parse_code() [ext/intl/tests/dateformat_format_parse_version2.phpt]
    datefmt_format_code() [ext/intl/tests/dateformat_format_variant3.phpt]
    datefmt_get_datetype_code() [ext/intl/tests/dateformat_get_datetype.phpt]
    datefmt_get_locale_code() [ext/intl/tests/dateformat_get_locale.phpt]
    datefmt_get_pattern_code and datefmt_set_pattern_code() icu >= 4.8 [ext/intl/tests/dateformat_get_set_pattern2.phpt]
    datefmt_get_timetype_code() [ext/intl/tests/dateformat_get_timetype.phpt]
    datefmt_get_timezone_id_code() [ext/intl/tests/dateformat_get_timezone_id.phpt]
    datefmt_set_lenient and datefmt_set_lenient() [ext/intl/tests/dateformat_is_set_lenient.phpt]
    datefmt_set_timezone_id_code() icu >= 4.8 [ext/intl/tests/dateformat_set_timezone_id3.phpt]
    Cloning numfmt [ext/intl/tests/formatter_clone.phpt]
    numfmt_format() icu >= 62.1 [ext/intl/tests/formatter_format8.phpt]
    numfmt_format() with type conversion [ext/intl/tests/formatter_format_conv.phpt]
    numfmt_format_currency() icu >= 4.8 [ext/intl/tests/formatter_format_currency2.phpt]
    numfmt_get_error_message/code() [ext/intl/tests/formatter_get_error.phpt]
    numfmt_get_locale() [ext/intl/tests/formatter_get_locale_variant4.phpt]
    numfmt_get/set_pattern() [ext/intl/tests/formatter_get_set_pattern2.phpt]
    numfmt_get/set_symbol() icu >= 4.8 [ext/intl/tests/formatter_get_set_symbol2.phpt]
    numfmt_get/set_text_attribute() ICU >= 56.1 [ext/intl/tests/formatter_get_set_text_attribute_var2.phpt]
    numfmt_parse() [ext/intl/tests/formatter_parse.phpt]
    numfmt_parse_currency() [ext/intl/tests/formatter_parse_currency.phpt]
    locale_accept_from_http [ext/intl/tests/locale_accept.phpt]
    locale_compose_locale() [ext/intl/tests/locale_compose_locale.phpt]
    locale_filter_matches.phpt() ICU >= 51.2 [ext/intl/tests/locale_filter_matches3.phpt]
    locale_get_all_variants.phpt() [ext/intl/tests/locale_get_all_variants.phpt]
    locale_get_default() [ext/intl/tests/locale_get_default.phpt]
    locale_get_display_language() [ext/intl/tests/locale_get_display_language.phpt]
    locale_get_display_name() icu >= 64.0 [ext/intl/tests/locale_get_display_name7.phpt]
    locale_get_display_region() icu >= 51.2 [ext/intl/tests/locale_get_display_region3.phpt]
    locale_get_display_script()  icu >= 52.1 [ext/intl/tests/locale_get_display_script4.phpt]
    locale_get_display_variant() icu >= 4.8 [ext/intl/tests/locale_get_display_variant2.phpt]
    locale_get_keywords() icu >= 4.8 [ext/intl/tests/locale_get_keywords2.phpt]
    locale_get_primary_language() [ext/intl/tests/locale_get_primary_language.phpt]
    locale_get_region() [ext/intl/tests/locale_get_region.phpt]
    locale_get_script() [ext/intl/tests/locale_get_script.phpt]
    locale_lookup.phpt() [ext/intl/tests/locale_lookup_variant2.phpt]
    locale_parse_locale() icu >= 4.8 [ext/intl/tests/locale_parse_locale2.phpt]
    locale_set_default($locale) [ext/intl/tests/locale_set_default.phpt]
    Cloning msgfmt [ext/intl/tests/msgfmt_clone.phpt]
    msgfmt_format() [ext/intl/tests/msgfmt_format.phpt]
    msgfmt_format() with subpatterns [ext/intl/tests/msgfmt_format_subpatterns.phpt]
    msgfmt_format() with named subpatterns [ext/intl/tests/msgfmt_format_subpatterns_named.phpt]
    msgfmt_get_locale() [ext/intl/tests/msgfmt_get_locale.phpt]
    msgfmt_get/set_pattern() [ext/intl/tests/msgfmt_get_set_pattern.phpt]
    msgfmt_parse() tests [ext/intl/tests/msgfmt_parse.phpt]
    normalizer_get_raw_decomposition() [ext/intl/tests/normalizer_get_raw_decomposition.phpt]
    normalize() [ext/intl/tests/normalizer_normalize.phpt]
    normalize() NFKC_Casefold [ext/intl/tests/normalizer_normalize_kc_cf.phpt]
    Regression: sort() and copy-on-write. [ext/intl/tests/regression_sort_and_cow.phpt]
    Regression: sort() eq but different len. [ext/intl/tests/regression_sort_eq.phpt]
    Regression: sort_wsk() and copy-on-write. [ext/intl/tests/regression_sortwsk_and_cow.phpt]
    Regression: sort_wsk() eq but different len. [ext/intl/tests/regression_sortwsk_eq.phpt]
    Test ResourceBundle::__construct() - existing/missing bundles/locales [ext/intl/tests/resourcebundle_create.phpt]
    Test ResourceBundle::get() and length() - existing/missing keys [ext/intl/tests/resourcebundle_individual.phpt]
    Test ResourceBundle::getLocales [ext/intl/tests/resourcebundle_locales.phpt]
    Bug #77691: Opcache passes wrong value for inline array push assignments [ext/opcache/tests/bug77691.phpt]
    Phar: opendir test, recurse into [ext/phar/tests/019b.phpt]
    Phar: opendir test, recurse into [ext/phar/tests/019c.phpt]
    Phar: phar:// opendir [ext/phar/tests/027.phpt]
    Test array_filter() function : usage variations - using the array keys inside 'callback' [ext/standard/tests/array/array_filter_variation10.phpt]
    Test lstat() and stat() functions: usage variations - effects changing permissions of dir [ext/standard/tests/file/lstat_stat_variation17.phpt]
    proc_nice() basic behaviour [ext/standard/tests/general_functions/proc_nice_basic.phpt]
    Bug #20134 (UDP reads from invalid ports) [ext/standard/tests/network/bug20134.phpt]
    Bug #68291 (404 on urls with '+') [sapi/cli/tests/bug68291.phpt]
    file upload greater than 2G [sapi/cli/tests/upload_2G.phpt]
    =====================================================================


