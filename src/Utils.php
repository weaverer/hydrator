<?php
declare(strict_types=1);

namespace Weaverer\Hydrator;

class Utils
{

    public const string STRING  = 'string';
    public const string INT     = 'int';
    public const string FLOAT   = 'float';
    public const string BOOL    = 'bool';
    public const string ARRAY   = 'array';
    public const string OBJECT  = 'object';
    public const string ENUM    = 'enum';

    public static function isScalar(string $typeName): bool
    {
        return in_array($typeName, [self::INT, self::FLOAT, self::STRING, self::BOOL], true);
    }

    public static function isList(string $typeName): bool
    {
        return $typeName === self::ARRAY;
    }

    public static function isObject(string $typeName): bool
    {
        return $typeName === self::OBJECT;
    }

    /**
     * 驼峰命名转下划线命名
     * 思路:
     * 小写和大写紧挨一起的地方,加上分隔符,然后全部转小写
     *
     * @param string $words
     * @param string $separator
     * @return string
     */
    public static function uncamelize(string $words, string $separator = '_'): string
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1' . $separator . '$2', $words));
    }

    /**
     * 下划线转驼峰
     * 思路:
     * step1.原字符串转小写,原字符串中的分隔符用空格替换,在字符串开头加上分隔符
     * step2.将字符串中每个单词的首字母转换为大写,再去空格,去字符串首部附加的分隔符.
     *
     * @param string $words
     * @param string $separator
     * @return string
     */
    public static function camelize(string $words, string $separator = '_'): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace($separator, ' ', $words))));
    }

}