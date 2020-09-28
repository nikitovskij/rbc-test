<?php

namespace App\Http\Controllers;

use DiDom\Document;
use GuzzleHttp\Client;
use App\Models\RbcNews;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Helper\RbcArticleCollector as RbcArticle;
use Carbon\Carbon;

class RbcNewsController extends Controller
{
    private const RBC_URL = 'https://www.rbc.ru/';

    public function index()
    {
        $html = $this->requestor(self::RBC_URL);
        $doc  = $this->documentor($html);

        $feeds = $doc->first('.js-news-feed-list')->find('a[id*=id_newsfeed]');
        $filteredFeeds = collect($feeds)
            ->map(fn ($item) => $item->attributes())
            ->map(fn ($item) => [
                'id'           => Str::of($item['id'])->substr(12),
                'url'          => $item['href'],
                'dateModified' => $item['data-modif']
            ])
            ->filter(fn ($item) => Str::of($item['url'])->contains($item['id']));

        $filteredFeeds->map(fn ($feed) => $this->saveArticle($feed));

        return redirect()->route('news.index');
    }

    private function saveArticle($feed)
    {
        ['id' => $id, 'url' => $url, 'dateModified' => $dateModified] = $feed;
        $articleNode = $this->articleNode($url, $id);

        $article = RbcNews::where('feed_id', $id)->first();
        if (!$article) {
            RbcNews::create([
                'feed_id'         => $id,
                'link'            => $url,
                'date_modified'   => Carbon::createFromTimestamp($dateModified, 'Europe/Moscow'),
                'header'          => RbcArticle::getArticleHeader($articleNode),
                'overview'        => RbcArticle::getArticleOverview($articleNode),
                'image_link'      => RbcArticle::getArticleImgAttr($articleNode)['src'],
                'image_title'     => RbcArticle::getArticleImgAttr($articleNode)['alt'],
                'content_authors' => RbcArticle::getArticleAuthors($articleNode),
                'content'         => RbcArticle::getArticlePostText($articleNode),
            ]);
        } else {
            $params = [
                'overview'        => RbcArticle::getArticleOverview($articleNode),
                'image_link'      => RbcArticle::getArticleImgAttr($articleNode)['src'],
                'image_title'     => RbcArticle::getArticleImgAttr($articleNode)['alt'],
                'content_authors' => RbcArticle::getArticleAuthors($articleNode),
                'content'         => RbcArticle::getArticlePostText($articleNode),
            ];

            $article->fill($params);
            $article->save();
        }
    }

    private function articleNode($url, $id)
    {
        $articleHtml = $this->requestor($url);
        $articleDoc  = $this->documentor($articleHtml);
        
        return $articleDoc->first("div[data-id='{$id}']");
    }

    private function requestor($url)
    {
        $client = new Client();
        $result = $client->request('GET', $url);

        return $result->getBody()->getContents();
    }

    private function documentor($html)
    {
        return new Document($html);
    }
}
