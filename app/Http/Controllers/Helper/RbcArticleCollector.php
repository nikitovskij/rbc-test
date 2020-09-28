<?php

namespace App\Http\Controllers\Helper;

use Illuminate\Support\Str;

class RbcArticleCollector
{
    public static function getArticleHeader($articleNode)
    {
        $header = $articleNode->first("[itemprop='headline']")->text();
        return Str::of($header)->trim();
    }

    public static function getArticleOverview($articleNode)
    {
        $selectors = [
            "@class='article__header__anons'",
            "@class='article__text__overview'",
            "@class='article__subtitle'",
        ];
        $expression = implode(' or ', $selectors);
        $overview = $articleNode->xpath("//*[{$expression}]");
        $overview = !empty($overview) ? $overview[0]->text() : '';

        return Str::of($overview)->trim();
    }

    public static function getArticleImgAttr($articleNode)
    {
        $imgNode = $articleNode->first("div[class*=article__main-image] > img");
        $imgUrl  = !is_null($imgNode) ? $imgNode->attributes(['src', 'alt']) : ['src' => '', 'alt' => ''];
    
        return $imgUrl;
    }

    public static function getArticlePostText($articleNode)
    {
        $selectors = [
            "//p",
            "//ul[not(@*)]",
            "//h2[not(@*)]",
            "//h3[not(@*)]"
        ];
        $expression = implode('|', $selectors);
        
        $article  = $articleNode->find(".article");
        $content  = collect($article)->map(function ($post) use ($expression) {
            return $post->xpath("{$expression}");
        })->flatten();
        $fullText = $content->map(fn($item) => Str::of($item->html())->trim())->implode("\n");

        return Str::of($fullText)->trim();
    }

    public static function getArticleAuthors($articleNode)
    {
        $authors = $articleNode->first("[class*=article__authors]");
        $authors  = !is_null($authors) ? $authors->text() : '';

        return Str::of($authors)->trim();
    }
}
