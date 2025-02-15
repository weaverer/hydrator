<?php
declare(strict_types=1);

namespace Weaverer\Hydrator\Founder;


use Weaverer\Hydrator\Types\ListType;
use Weaverer\Hydrator\Utils;

class ArrayListFounder extends Founder
{

    public ListType $listType;

    public function setListType(ListType $listType): self
    {
        $this->listType = $listType;
        return $this;
    }

    public function found($value)
    {
        $value = $this->toConvertValue($value);
        if (null === $value) {
            return null;
        }
        if (!is_array($value) && !array_is_list($value)) {
            $this->throwTypeError(Utils::ARRAY, $value);
        }
        if (empty($value)) {
            return [];
        }
        $this->formatValue($value, $this->listType->depth, $this->listType->type, $this->listType->isScalar);
        return $value;
    }


    private function formatValue(array $data, int $depth, string $itemType, bool $itemIsScalar): array
    {
        $depth--;
        if ($depth > 0) {
            $newList = [];
            foreach ($data as $value) {
                $newList[] = $this->formatValue($value, $depth, $itemType, $itemIsScalar);
            }
        } else {
            if (empty($data)) {
                return [];
            }
            $newList = [];
            if ($itemIsScalar) {
                foreach ($data as $value) {
                    $value = FounderFactory::getScalarFounder($itemType, [])->found($value);
                    $newList[] = $value;
                }
            } else {
                $founder = FounderFactory::getClassFounder($itemType, []);
                foreach ($data as $value) {
                    $value = $founder->found($value);
                    $newList[] = $value;
                }
            }
        }
        return $newList;
    }
}