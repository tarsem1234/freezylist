<?php

namespace App\Repositories\Backend\History;

/**
 * Interface HistoryContract.
 */
interface HistoryContract
{
    /**
     * @return mixed
     */
    public function withType($type);

    /**
     * @return mixed
     */
    public function withText($text);

    /**
     * @return mixed
     */
    public function withEntity($entity_id);

    /**
     * @return mixed
     */
    public function withIcon($icon);

    /**
     * @return mixed
     */
    public function withClass($class);

    /**
     * @return mixed
     */
    public function withAssets($assets);

    /**
     * @return mixed
     */
    public function log();

    /**
     * @param  null  $limit
     * @param  bool  $paginate
     * @param  int  $pagination
     * @return mixed
     */
    public function render($limit = null, $paginate = true, $pagination = 10);

    /**
     * @param  null  $limit
     * @param  bool  $paginate
     * @param  int  $pagination
     * @return mixed
     */
    public function renderType($type, $limit = null, $paginate = true, $pagination = 10);

    /**
     * @param  null  $limit
     * @param  bool  $paginate
     * @param  int  $pagination
     * @return mixed
     */
    public function renderEntity($type, $entity_id, $limit = null, $paginate = true, $pagination = 10);

    /**
     * @param  bool  $assets
     * @return mixed
     */
    public function renderDescription($text, $assets = false);

    /**
     * @param  bool  $paginate
     * @return mixed
     */
    public function buildList($history, $paginate = true);

    /**
     * @return mixed
     */
    public function buildPagination($query, $limit, $paginate, $pagination);
}
