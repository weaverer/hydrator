<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Parser;


class NamespaceParser
{
    protected string|object $class;
    protected string $classNamespace;
    protected string $useLines;

    public function __construct(string|object $class)
    {
        $this->class = $class;
        $reflection = new \ReflectionClass($this->class);
        $this->classNamespace = $reflection->getNamespaceName();
        $file = $reflection->getFileName();
        $content = file_get_contents($file);
        //将use的文案提取出来给useLines
        $pattern = '/use\s+(((\w|\\\)+));/';
        preg_match_all($pattern, $content, $matches);
        $this->useLines = implode("\n", $matches[0]);
    }

    /**
     * @param string $shortClassName
     * @return string|null
     */
    public function getUsedClassName(string $shortClassName): ?string
    {

        $aliasPattern = '/use\s+((\w|\\\)+) as\s+' . $shortClassName . ';/'; //别名匹配
        $pattern = '/use\s+(((\w|\\\)+)' . $shortClassName . ');/';
        if (!preg_match($aliasPattern,  $this->useLines, $matches)) {
            preg_match($pattern,  $this->useLines, $matches);
        }
        $className = $matches[1]??'';
        if(!$className){ //不是通过use引入的类,则直接拼接命名空间
            $className = $this->classNamespace . '\\' . $shortClassName;
        }
        if (!class_exists($className)) {
           return null;
        }
        return '\\'.ltrim($className, '\\');
    }


}