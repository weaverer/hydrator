<?php

namespace Weaverer\Hydrator\Interface;

interface LocaleInterface
{
    public function setLocale(string $locale);

    public function getLocale(): string;
}
