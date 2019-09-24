<?php

namespace Lib;

use GuzzleHttp\Psr7\Request;
use SimpleXMLElement as XML;

class Client
{
    protected $curl;
    protected $src;
    protected $feed;

    public function __construct(\Http\Client\Curl\Client $curl, string $src)
    {
        $this->curl = $curl;
        $this->src = $src;
    }

    protected function fetchFeed()
    {
        if($this->feed){
            return $this->feed;
        }

        $request = new Request('GET', $this->src);
        $response = $this->curl->sendRequest($request)->withHeader('Accept', 'application/xml');

        if ($response->getStatusCode() !== 200) {
            return null;
        }

        $this->feed = new XML($response->getBody()->getContents(), LIBXML_NOCDATA+LIBXML_PARSEHUGE+LIBXML_NSCLEAN);
        return $this->feed;
    }

    public function getData()
    {
        $feed = $this->fetchFeed();

        $data = [];
        if ($feed) {
            $data = $feed->channel->children()->item;
        }

        return $data;
    }

    public function getInfos(){
        $feed = $this->fetchFeed();
        $infos = [];

        if($feed){
            $channel = $feed->channel;
            $infos['title'] = $channel->title->__toString();
            $infos['link'] = $channel->link->__toString();
            $infos['description'] = $channel->description->__toString();
            $infos['language'] = $channel->language->__toString();
            $infos['image']['url'] = $channel->image->url->__toString();
            $infos['image']['alt'] = $channel->image->title->__toString();
            $infos['image']['width'] = $channel->image->width->__toString();
            $infos['image']['height'] = $channel->image->height->__toString();
        }

        return $infos;
    }
}