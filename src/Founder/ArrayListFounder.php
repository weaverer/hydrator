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


    public function found($value, ?string $mapWayName = null): ?array
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
        return $this->formatValue($value, $this->listType->depth, $this->listType->type, $this->listType->isScalar,$mapWayName);
    }


    private function formatValue(array $data, int $depth, string $itemType, bool $itemIsScalar,?string $mapWayName): array
    {
        $depth--;
        if ($depth > 0) {
            $newList = [];
            foreach ($data as $value) {
                if(!is_array($value)){
                    $this->throwTypeError(Utils::ARRAY, $value);
                }
                $newList[] = $this->formatValue($value, $depth, $itemType, $itemIsScalar,$mapWayName);
            }
        } else {
            if (empty($data)) {
                return [];
            }
            if(!array_is_list($data)){
                $this->throwTypeError(Utils::ARRAY, $data);
            }
            $newList = [];
            if ($itemIsScalar) {
                foreach ($data as $value) {
                    $value = FounderFactory::getScalarFounder($itemType, [])->found($value,$mapWayName);
                    $newList[] = $value;
                }
            } else {
                foreach ($data as $value) {
                    if (is_array($value) && !empty($value) && array_is_list($value)) { //需要是对象
                        $this->throwTypeError(Utils::ARRAY, $value);
                    }
                    $value = FounderFactory::getClassFounder($itemType, [])->found($value,$mapWayName);
                    $newList[] = $value;
                }
            }
        }
        return $newList;
    }
}