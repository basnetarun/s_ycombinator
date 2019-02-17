<?php

namespace Controllers;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Promise;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Controllers\iClient;
use Repositories\ItemRepository;


class ClientController implements iClient {

    /**
     * @var string
     */
    private $base_url = 'https://hacker-news.firebaseio.com/v0/';

    /**
     * @var HttpClient
     */
    private $http_client;

    /**
     * @var array
     */
    private $endpoints = array(
        'getMaxItem'    => 'maxitem',
        'getItem'       => 'item/{id}',
        'getUser'       => 'user',
        'getNewStories' => 'newstories',
        'getTopStories' => 'topstories',
        'getBestStories'    => 'beststories', 
        'getAskStories' => 'askstories',
        'getShowStories'    => 'showstories',
        'getJobStories'     => 'jobstories',
        'getUpdates'    => 'updates'
    );


    /** 
     * @param string
     * @param int
     * @return string
     */
    private function buildUrl($url_func, $id = null) {

        if(method_exists($this, $url_func)) {
            $url = $this->base_url.$this->endpoints[$url_func].'.json';
            if($id!==null) {
                $url = str_replace('{id}', $id, $url);
            }
            return $url;
        } else {
            throw new MethodNotAllowedHttpException(sprintf('Method %s is not an allowed endpoint', $url_func));
        }

    }

    /**
     * @param HttpClient
     */
    public function __construct(HttpClient $htc) {
        $this->http_client = $htc;
    }

    /**
     * @inheritDoc
     */
    public function getMaxItem(): ?int {
        $call_url = $this->buildUrl('getMaxItem');
        $response = $this->http_client->get($call_url);

        if($response->getStatusCode() !== 200) {
            throw new NotFoundHttpException(
                sprintf('Requested endpoint: %s returned a status code: %u', $call_url, $response->getStatusCode())
            );
        }
        return (int) $response->getBody()->getContents();
        
    }

    /**
     * @inheritDoc
     */
    function getItem(int $id): ?Item {
        return null;
    }

    /**
     * @inheritDoc
     */

    function getUser(string $name): ?User {
        return null;
    } 

    /**
     * @inheritDoc
     */
    function getNewStories($start, $stop): array {
        return array();
    }

    /**
     * @inheritDoc
     */
    function getTopStories($start, $stop): array {
        $call_url = $this->buildUrl('getTopStories');
        $id_topstories = $this->getItems($call_url);
        
        $topstories = array_slice($id_topstories,$start,$stop);

        return $this->getAsync($topstories);
        
    }


    /**
     * @inheritDoc
     */
    function getBestStories($start, $stop): array {
        return array();
    }
    
    /**
     * @inheritDoc
     */
    function getAskStories($start, $stop): array {
        return array();
    }
    
    /**
     * @inheritDoc
     */
    function getShowStories($start, $stop): array {
        return array();
    }
    
    
    /**
     * @inheritDoc
     */
    function getJobStories($start, $stop): array {
        return array();
    }
    
    /**
     * @inheritDoc
     */
    function getUpdates($start, $stop): ?Updates {
        return null;
    }

    /**
     * @param string
     * @return null|array
     */
    private function getItems($call_url) {
        
        $response = $this->http_client->get($call_url);

        if($response->getStatusCode() !== 200) {
            throw new NotFoundHttpException(
                sprintf('Requested endpoint: %s returned a status code: %u', $call_url, $response->getStatusCode())
            );
        }
        return json_decode($response->getBody()->getContents());
    }


    /**
     * Asynchronously get json items
     * @param  $items int[] 
     * @return array[] 
     */
    private function getAsync($items)
    {
        $responses = array();
        $results = array();
        
        $promises = $this->buildPromises($items);

        
        // Wait on all of the requests to complete. Throws a ConnectException
        // if any of the requests fail
        $promised_responses = Promise\unwrap($promises);
        // Wait for the requests to complete, even if some of them fail
        $promised_responses = Promise\settle($promises)->wait();

        $responses = array_merge($responses, $promised_responses);

        
        
        foreach($responses as $single_response)
        {
            if($single_response['value']->getStatusCode() === 200) 
                $possible_item = $single_response['value']->getBody()->getContents();
                $results [] = $this->formatItem($possible_item);
        }
        
        return $results;
    }

    /**
     * function to format story item properly
     * @param $jsonObj json
     * @return array
     */
    private function formatItem($item) {
        //obj = ItemRepository::fromArray($item);
        return json_decode($item, true);
    }


    /**
     * @param $slice array
     * @return null|array
     */

    private function buildPromises($slice) {
        if(!empty($slice)) {
            $promises = [];
            foreach($slice as $item_id) {
                $item_url = $this->buildUrl('getItem', $item_id);
                array_push($promises,$this->http_client->getAsync($item_url));
            }
            return $promises;
        }

        return null;
    }

}