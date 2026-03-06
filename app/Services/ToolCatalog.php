<?php

namespace App\Services;

class ToolCatalog
{
    /**
     * @return array<string, array{name:string,icon:string,color:string,bg:string}>
     */
    public function categories(): array
    {
        /** @var array<string, array{name:string,icon:string,color:string,bg:string}> $cats */
        $cats = config('nexora.categories', []);

        return $cats;
    }

    /**
     * @return array<int, array{slug:string,name:string,desc:string,cat:string,icon:string,popular?:bool,new?:bool}>
     */
    public function tools(): array
    {
        /** @var array<int, array{slug:string,name:string,desc:string,cat:string,icon:string,popular?:bool,new?:bool}> $tools */
        $tools = config('nexora.tools', []);

        return $tools;
    }

    public function toolsByCategory(string $categorySlug): array
    {
        return array_values(array_filter($this->tools(), fn ($t) => ($t['cat'] ?? null) === $categorySlug));
    }

    public function popularTools(int $limit = 9): array
    {
        $popular = array_values(array_filter($this->tools(), fn ($t) => !empty($t['popular'])));
        return array_slice($popular, 0, $limit);
    }

    public function findTool(string $slug): ?array
    {
        foreach ($this->tools() as $t) {
            if (($t['slug'] ?? null) === $slug) {
                return $t;
            }
        }
        return null;
    }
}

