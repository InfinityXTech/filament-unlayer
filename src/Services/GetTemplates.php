<?php

namespace InfinityXTech\FilamentUnlayer\Services;

use Illuminate\Support\Facades\Http;

class GetTemplates {
    public static function all (string $name = '', bool $isPublished = true, bool $isPremium = false, $limit = 50, $offset = 0) {
        $variables = [
            'offset' => $offset,
            'limit' => $limit,
            'filter' => [
                'isPublished' => $isPublished,
                'premium' => $isPremium
            ],
            'orderBy' => 'CREATED_AT_DESC'
        ];
        
        if (!empty($name)) {
            $variables['filter']['name'] = $name;
        } else {
            unset($variables['filter']['name']); // Remove the 'name' key if $name is empty
        }

        $data = [
            'operationName' => 'AllStockTemplatesQuery',
            'variables' => $variables,
            'query' => "query AllStockTemplatesQuery(\$offset: Int, \$limit: Int, \$filter: StockTemplateFilter, \$orderBy: StockTemplateOrderBy) {
                allStockTemplates(
                offset: \$offset
                limit: \$limit
                filter: \$filter
                orderBy: \$orderBy
                ) {
                id
                name
                slug
                rating
                votes
                position
                premium
                previewUrl
                __typename
                }
            }"
        ];
        
        $response = Http::withHeaders([
            'Accept' => '*/*',
            'Content-Type' => 'application/json',
        ])->post('https://api.graphql.unlayer.com/graphql', $data);
        
        $templates = $response->json()['data']['allStockTemplates'] ?? [];

        return collect($templates)->mapWithKeys(fn (array $template) => [$template['slug'] => view('filament-unlayer::unlayer-template')->with('template', $template)->render()])->toArray();
    }

    public static function find (string $name) {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://api.graphql.unlayer.com/graphql', [
            'query' => "
                query StockTemplateLoad(\$slug: String!) {
                  StockTemplate(slug: \$slug) {
                    StockTemplatePages {
                      design
                    }
                  }
                }
            ",
            'variables' => [
                'slug' => $name,
            ],
        ]);
        
        $result = $response->json();
        return $result['data']['StockTemplate']['StockTemplatePages'][0]['design'] ?? null;
    }
}