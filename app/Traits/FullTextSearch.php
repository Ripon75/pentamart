<?php

namespace App\Traits;

trait FullTextSearch
{
    protected $searchMode      = 'IN NATURAL LANGUAGE MODE WITH QUERY EXPANSION';
    protected $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];

    /* Replaces spaces with full text search wildcards
     *
     * @param string $term
     * @return string
     */
    protected function fullTextWildcards($term)
    {
        // removing symbols used by MySQL
        $term = str_replace($this->reservedSymbols, '', $term);

        $words = explode(' ', $term);

        foreach ($words as $key => $word) {
            /* applying + operator (required word) only big words
             * because smaller ones are not indexed by mysql
             */
            if (strlen($word) >= 3) {
                $words[$key] = '+' . $word . '';
            }
        }

        $searchTerm = implode(' ', $words);

        return $searchTerm;
    }

    /* Scope a query that matches a full text search of term.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $term
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $term)
    {
        $columns = implode(',', $this->searchable);

        $query->whereRaw("MATCH ({$columns}) AGAINST (? {$this->searchMode})", $this->fullTextWildcards($term));
        // $query->whereRaw("MATCH ({$columns}) AGAINST (? {$this->searchMode}) AS score ORDER BY score DESC", $this->fullTextWildcards($term));

        return $query;
    }
}
