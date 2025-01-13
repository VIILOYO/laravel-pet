<?php

namespace App\Queue\Interfaces;

/**
 * @property-read int $uniqueFor время которое джоба считается уникальной до её выполнения
 * @method int|string uniqueId метод получения уникального id
 */
interface ShouldBeUnique {}
