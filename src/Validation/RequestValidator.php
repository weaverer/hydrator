<?php

namespace Weaverer\Hydrator\Validation;


use DI\Attribute\Inject;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;

class RequestValidator
{
    private Factory $factory;

    public function __construct(string $path, string $locale = 'en')
    {
        $file = new Filesystem();
        $fileLoader = new FileLoader($file, $path);
        $translator = new Translator($fileLoader, $locale);
        $this->factory = new Factory($translator);
    }


    public function setLocale(string $locale): self
    {
        $this->factory->getTranslator()->setLocale($locale);
        return $this;
    }

    /**
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @param array $attributes
     * @return \Illuminate\Validation\Validator
     */
    public function make(array $data, array $rules, array $messages = [], array $attributes = []): Validator
    {
        return $this->factory->make($data, $rules, $messages, $attributes);
    }



}
