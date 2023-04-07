<?php

namespace App\Listeners;

use App\Events\ProductSearch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\SearchLog;

class StoreSearchLog
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ProductSearch  $event
     * @return void
     */
    public function handle(ProductSearch $event)
    {
        $searchKey   = $event->searchKey;
        $resultCount = $event->resultCount;

        $searchLogObj = new SearchLog();
        $searchLogObj->_store($searchKey, $resultCount);
    }
}
