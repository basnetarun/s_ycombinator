<?php

namespace Controllers;

use GuzzleHttp\Client as HttpClient;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

use Controllers\iClient;


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
    function getNewStories(): array {
        return array();
    }

    /**
     * @inheritDoc
     */
    function getTopStories(): array {
        $call_url = $this->buildUrl('getTopStories');
        $response = $this->http_client->get($call_url);

        if($response->getStatusCode() !== 200) {
            throw new NotFoundHttpException(
                sprintf('Requested endpoint: %s returned a status code: %u', $call_url, $response->getStatusCode())
            );
        }
        return json_decode($response->getBody()->getContents());
    }


    /**
     * @inheritDoc
     */
    function getBestStories(): array {
        return array();
    }
    
    /**
     * @inheritDoc
     */
    function getAskStories(): array {
        return array();
    }
    
    /**
     * @inheritDoc
     */
    function getShowStories(): array {
        return array();
    }
    
    
    /**
     * @inheritDoc
     */
    function getJobStories(): array {
        return array();
    }
    
    /**
     * @inheritDoc
     */
    function getUpdates(): ?Updates {
        return null;
    }

}