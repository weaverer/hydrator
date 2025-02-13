<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Interface;

interface MapFromInterface
{
    /**
     * @return string 返回映射的字段的来源名称
     */
    public function getMapFromName(): string;
}