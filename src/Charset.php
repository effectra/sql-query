<?php

declare(strict_types=1);

namespace Effectra\SqlQuery;

class Charset
{
    // MySQL character set constants
    const MySQL_armscii8 = 'armscii8_general_ci';
    const MySQL_ascii = 'ascii_general_ci';
    const MySQL_big5 = 'big5_chinese_ci';
    const MySQL_binary = 'binary';
    const MySQL_cp1250 = 'cp1250_general_ci';
    const MySQL_cp1251 = 'cp1251_general_ci';
    const MySQL_cp1256 = 'cp1256_general_ci';
    const MySQL_cp1257 = 'cp1257_general_ci';
    const MySQL_cp850 = 'cp850_general_ci';
    const MySQL_cp852 = 'cp852_general_ci';
    const MySQL_cp866 = 'cp866_general_ci';
    const MySQL_cp932 = 'cp932_japanese_ci';
    const MySQL_dec8 = 'dec8_swedish_ci';
    const MySQL_eucjpms = 'eucjpms_japanese_ci';
    const MySQL_euckr = 'euckr_korean_ci';
    const MySQL_gb18030 = 'gb18030_chinese_ci';
    const MySQL_gb2312 = 'gb2312_chinese_ci';
    const MySQL_gbk = 'gbk_chinese_ci';
    const MySQL_geostd8 = 'geostd8_general_ci';
    const MySQL_greek = 'greek_general_ci';
    const MySQL_hebrew = 'hebrew_general_ci';
    const MySQL_hp8 = 'hp8_english_ci';
    const MySQL_keybcs2 = 'keybcs2_general_ci';
    const MySQL_koi8r = 'koi8r_general_ci';
    const MySQL_koi8u = 'koi8u_general_ci';
    const MySQL_latin1 = 'latin1_swedish_ci';
    const MySQL_latin2 = 'latin2_general_ci';
    const MySQL_latin5 = 'latin5_turkish_ci';
    const MySQL_latin7 = 'latin7_general_ci';
    const MySQL_macce = 'macce_general_ci';
    const MySQL_macroman = 'macroman_general_ci';
    const MySQL_sjis = 'sjis_japanese_ci';
    const MySQL_swe7 = 'swe7_swedish_ci';
    const MySQL_tis620 = 'tis620_thai_ci';
    const MySQL_ucs2 = 'ucs2_general_ci';
    const MySQL_ujis = 'ujis_japanese_ci';
    const MySQL_utf16 = 'utf16_general_ci';
    const MySQL_utf16le = 'utf16le_general_ci';
    const MySQL_utf32 = 'utf32_general_ci';
    const MySQL_utf8 = 'utf8';
    const MySQL_utf8mb3 = 'utf8mb3_general_ci';
    const MySQL_utf8mb4 = 'utf8mb4_0900_ai_ci';

    // PostgreSQL character set constants
    const PostgreSQL_utf8 = 'UTF8';
    const PostgreSQL_utf8mb4 = 'UTF8MB4';
    const PostgreSQL_utf16 = 'UTF16';
    const PostgreSQL_utf16le = 'UTF16LE';
    const PostgreSQL_utf32 = 'UTF32';
    const PostgreSQL_latin1 = 'LATIN1';
    const PostgreSQL_latin2 = 'LATIN2';
    const PostgreSQL_latin3 = 'LATIN3';
    const PostgreSQL_latin4 = 'LATIN4';
    const PostgreSQL_latin5 = 'LATIN5';
    const PostgreSQL_latin6 = 'LATIN6';
    const PostgreSQL_latin7 = 'LATIN7';
    const PostgreSQL_latin8 = 'LATIN8';
    const PostgreSQL_latin9 = 'LATIN9';
    const PostgreSQL_latin10 = 'LATIN10';
    const PostgreSQL_win1250 = 'WIN1250';
    const PostgreSQL_win1251 = 'WIN1251';
    const PostgreSQL_win1252 = 'WIN1252';
    const PostgreSQL_win1253 = 'WIN1253';
    const PostgreSQL_win1254 = 'WIN1254';
    const PostgreSQL_win1255 = 'WIN1255';
    const PostgreSQL_win1256 = 'WIN1256';
    const PostgreSQL_win1257 = 'WIN1257';
    const PostgreSQL_win1258 = 'WIN1258';
    const PostgreSQL_iso_8859_1 = 'ISO_8859_1';
    const PostgreSQL_iso_8859_2 = 'ISO_8859_2';
    const PostgreSQL_iso_8859_3 = 'ISO_8859_3';
    const PostgreSQL_iso_8859_4 = 'ISO_8859_4';
    const PostgreSQL_iso_8859_5 = 'ISO_8859_5';
    const PostgreSQL_iso_8859_6 = 'ISO_8859_6';
    const PostgreSQL_iso_8859_7 = 'ISO_8859_7';
    const PostgreSQL_iso_8859_8 = 'ISO_8859_8';
    const PostgreSQL_iso_8859_9 = 'ISO_8859_9';
    const PostgreSQL_iso_8859_10 = 'ISO_8859_10';

    /**
     * Get the constant name for a given value.
     *
     * @param mixed $value The character set value.
     * @return string|null The constant name corresponding to the value, or null if not found.
     */
    public static function getConstantName($value)
    {
        $reflection = new \ReflectionClass(__CLASS__);
        $constants = $reflection->getConstants();
        $constantName = array_search($value, $constants);
        return $constantName !== false ? $constantName : null;
    }

    /**
     * Clear the driver prefix from a character set value.
     *
     * @param string $string The character set value.
     * @return string The character set without the driver prefix.
     */
    public static function clearDriver($string)
    {
        $parts = explode('_', $string);
        return $parts[1];
    }

    /**
     * Get the driver from a character set value.
     *
     * @param mixed $value The character set value.
     * @return string The driver name.
     */
    public static function getDriver($value)
    {
        $string = static::getConstantName($value);
        $parts = explode('_', $string);
        return $parts[0];
    }

    /**
     * Get the character set name from a character set value.
     *
     * @param mixed $value The character set value.
     * @return string The character set name.
     */
    public static function getCharacter($value)
    {
        $string = static::getConstantName($value);
        return static::clearDriver($string);
    }
}
