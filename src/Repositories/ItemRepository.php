<?php 

namespace Repositories;

use Utilities\ItemFromArray as ItemFromArray;

/**
 * Model Class for Item Entity
 */


class ItemRepository {

    use ItemFromArray;
    /**
     * @var int
     */
    private $id;

    /**
     * @var bool
     */
    private $deleted;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $by;

    /**
     * @var int
     */
    private $time;


    /**
     * @var string
     */
    private $text;

    /**
     * @var bool
     */
    private $dead;


    /** 
     * @var int
     */
    private $parent;

    /**
     * @var int
     */
    private $poll;


    /**
     * @var int[]
     */
    private $kids = array();

    /**
     * @var string
     */
    private $url;

    /**
     * @var int
     */
    private $score;

    /**
     * @var string
     */
    private $title;

    /**
     * @var int[]
     */
    private $parts = array();

    /**
     * @var int[]
     */
    private $descendants = array();


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getBy(): string
    {
        return $this->by;
    }

    /**
     * @return int
     */
    public function getTime(): int
    {
        return $this->time;
    }

    /**
     * @return null|string
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @return bool
     */
    public function isDead(): bool
    {
        return $this->dead;
    }

    /**
     * @return int|null
     */
    public function getParent(): ?int
    {
        return $this->parent;
    }

    /**
     * @return int|null
     */
    public function getPoll(): ?int
    {
        return $this->poll;
    }

    /**
     * @return \int[]
     */
    public function getKids(): array
    {
        return $this->kids;
    }

    /**
     * @return null|string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return int|null
     */
    public function getScore(): ?int
    {
        return $this->score;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return int[]
     */
    public function getParts(): array
    {
        return $this->parts;
    }

    /**
     * @return int|null
     */
    public function getDescendants(): ?int
    {
        return $this->descendants;
    }


}