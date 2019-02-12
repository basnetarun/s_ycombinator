<?php

namespace Controllers;



/**
 * Interface defining the client class
 * methods and properties fully defined in class implementation
 */
interface iClient {


    /**
     * @return int
     */
    function getMaxItem(): ?int;

    /**
     * @param int $id
     * @return Item|null
     */
    function getItem(int $id): ?Item;

    /**
     * @param string $name
     * @return User|null
     */
    function getUser(string $name): ?User;

    /**
     * @return array
     */
    function getNewStories(): array;

    /**
     * @return array
     */
    function getTopStories(): array;


    /**
     * @return array
     */
    function getBestStories(): array;
    
    /**
     * @return array
     */
    function getAskStories(): array;
    
    /**
     * @return array
     */
    function getShowStories(): array;
    
    
    /**
     * @return array
     */
    function getJobStories(): array;
    
    /**
     * @return Updates|null
     */
    function getUpdates(): ?Updates;
}