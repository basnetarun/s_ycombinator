<?php

namespace SilexHackerNews\Controllers;



/**
 * Interface defining the client class
 */
interface iClient {


    /**
     * @return int
     */
    public function getMaxItem(): int;

    /**
     * @param int $id
     * @return Item|null
     */
    public function getItem(int $id): ?Item;

    /**
     * @param string $name
     * @return User|null
     */
    public function getUser(string $name): ?User;

    /**
     * @return array
     */
    public function getNewStories(): array;

    /**
     * @return array
     */
    public function getTopStories(): array;


    /**
     * @return array
     */
    public function getBestStories(): array;
    
    /**
     * @return array
     */
    public function getAskStories(): array;
    
    /**
     * @return array
     */
    public function getShowStories(): array;
    
    
    
    
    /**
     * @return array
     */
    public function getJobStories(): array;
    
    /**
     * @return Updates|null
     */
    public function getUpdates(): ?Updates;
}