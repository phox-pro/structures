<?php

namespace Phox\Structures\Abstracts;

use LogicException;
use Phox\Structures\Interfaces\IType;

/**
 * @template T of object
 * @implements IType<T>
 */
readonly class ObjectType implements IType
{
    /**
     * @param class-string<T> $class
     */
    protected function __construct(protected string $class)
    {
        //
    }

    /**
     * @param T $object
     * @return static<T>
     */
    public static function fromObject(object $object): self
    {
        return new self($object::class);
    }

    /**
     * @param class-string<T> $class
     * @return static<T>
     */
    public static function fromClass(string $class): self
    {
        if (!class_exists($class) && !interface_exists($class)) {
            throw new LogicException();
        }

        return new self($class);
    }

    public function getType(): string
    {
        return $this->class;
    }

    public function isSame(mixed $value): bool
    {
        if (!is_object($value)) {
            return false;
        }

        return $this->class === $value::class;
    }

    public function isSameType(IType|string $type): bool
    {
        if ($type instanceof IType) {
            $type = $type->getType();
        }

        return $this->class == $type;
    }

    public function allows(mixed $value): bool
    {
        if (!is_object($value)) {
            return false;
        }

        return $value instanceof $this->class;
    }

    public function allowsType(IType|string $type): bool
    {
        if ($type instanceof IType) {
            $type = $type->getType();
        }

        return is_subclass_of($type, $this->class);
    }
}