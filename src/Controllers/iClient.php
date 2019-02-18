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
     * @return array|null
     */
    function getItem(int $id): ?array;

    /**
     * @param string $name
     * @return User|null
     */
    function getUser(string $name): ?User;

    /**
     * @param int $start
     * @param int $stop
     * @return array
     */
    function getNewStories($start, $stop): array;

    /**
     * @param int $start
     * @param int $stop
     * @return array
     */
    function getTopStories($start, $stop): array;


    /**
     * @param int $start
     * @param int $stop
     * @return array
     */
    function getBestStories($start, $stop): array;
    
    /**
     * @param int $start
     * @param int $stop
     * @return array
     */
    function getAskStories($start, $stop): array;
    
    /**
     * @param int $start
     * @param int $stop
     * @return array
     */
    function getShowStories($start, $stop): array;
    
    
    /**
     * @param int $start
     * @param int $stop
     * @return array
     */
    function getJobStories($start, $stop): array;
    
    /**
     * @param int $start
     * @param int $stop
     * @return Updates|null
     */
    function getUpdates($start, $stop): ?Updates;
}