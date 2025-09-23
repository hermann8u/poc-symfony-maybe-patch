<?php

declare(strict_types=1);

namespace Application;

use Maybe\Maybe;
use Symfony\Component\HttpFoundation\InputBag;
use function Symfony\Component\String\s;

/**
 * This class simplify the initialization of input classes based on maybe properties.
 */
final readonly class Initializer
{
    /**
     * @template T of object
     *
     * @param class-string<T> $inputClass
     * @param array<string, mixed> $initialData
     *
     * @return T
     */
    public function initialize(string $inputClass, InputBag $data, ...$initialData): object
    {
        $vars = array_keys(get_class_vars($inputClass));

        $finalData = $initialData;

        foreach ($vars as $var) {
            $key = s($var)->snake()->toString();

            if (isset($finalData[$key])) {
                continue;
            }

            $finalData[$var] = $data->has($key) ? Maybe::just($data->get($key)) : Maybe::nothing();
        }

        try {
            return new $inputClass(...$finalData);
        } catch (\ArgumentCountError) {
            throw new \LogicException(\sprintf(
                'The constructor of class "%s" seems to have arguments not defined as class properties.',
                $inputClass,
            ));
        }
    }
}
