<?php

namespace GSpataro\Library;

final class Research
{
    /**
     * Store items selection
     *
     * @var array
     */

    private array $selection;

    /**
     * Store skip offset
     *
     * @var int
     */

    private int $skip;

    /**
     * Store limit offset
     *
     * @var int
     */

    private int $limit;

    /**
     * Store order by criteria
     *
     * @var string
     */

    private string $orderBy;

    /**
     * Store order criteria
     *
     * @var string
     */

    private string $order;

    /**
     * Store fetched data
     *
     * @var array
     */

    private array $fetched;

    /**
     * Initialize research
     *
     * @param array $content
     */

    public function __construct(
        private readonly array $content
    ) {
    }

    /**
     * Select specific items in the content
     *
     * @param array $items
     * @return static
     */

    public function select(array $items): static
    {
        if (!isset($this->selection)) {
            $this->selection = $items;
        }

        return $this;
    }

    /**
     * Skip items
     *
     * @param int $offset
     * @return static
     */

    public function skip(int $offset): static
    {
        if (!isset($this->skip)) {
            $this->skip = $offset;
        }

        return $this;
    }

    /**
     * Limit the number of items to select
     *
     * @param int $offset
     */

    public function limit(int $offset): static
    {
        if (!isset($this->limit)) {
            $this->limit = $offset;
        }

        return $this;
    }

    /**
     * Set order by criteria
     *
     * @param string $column
     * @return static
     */

    public function orderBy(string $column): static
    {
        if (!isset($this->orderBy)) {
            $this->orderBy = $column;
        }

        return $this;
    }

    /**
     * Set order criteria to ASCENDENT
     *
     * @return static
     */

    public function asc(): static
    {
        if (!isset($this->order)) {
            $this->order = 'asc';
        }

        return $this;
    }

    /**
     * Set order criteria to DESCENDENT
     *
     * @return static
     */

    public function desc(): static
    {
        if (!isset($this->order)) {
            $this->order == 'desc';
        }

        return $this;
    }

    /**
     * Get results
     *
     * @return array
     */

    public function fetch(): array
    {
        if (isset($this->fetched)) {
            return $this->fetched;
        }

        $result = $this->content;

        if (!empty($this->selection)) {
            $result = array_filter($result, function ($item) {
                return in_array($item, $this->selection);
            }, ARRAY_FILTER_USE_KEY);
        }

        if (isset($this->skip) || isset($this->limit)) {
            $result = array_slice(
                $result,
                $this->skip ?? 0,
                $this->limit ?? null,
                true
            );
        }

        $this->fetched = $result;
        return $result;
    }
}
