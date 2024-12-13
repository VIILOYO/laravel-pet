<?php

namespace App\Queue\Interfaces;

use UnderflowException;

interface StackInterface
{
    /**
     * Добавляет элемент на вершину стека.
     *
     * @param  mixed  $item  Элемент, который нужно добавить.
     */
    public function push($item): void;

    /**
     * Удаляет элемент с вершины стека и возвращает его.
     *
     * @return mixed Элемент, который был удален.
     *
     * @throws UnderflowException Если стек пуст.
     */
    public function pop();

    /**
     * Возвращает элемент с вершины стека без его удаления.
     *
     * @return mixed Элемент на вершине стека.
     *
     * @throws UnderflowException Если стек пуст.
     */
    public function top();

    /**
     * Проверяет, пуст ли стек.
     *
     * @return bool Возвращает true, если стек пуст, иначе false.
     */
    public function isEmpty(): bool;

    /**
     * Возвращает количество элементов в стеке.
     *
     * @return int Число элементов в стеке.
     */
    public function size(): int;
}
