<?php

namespace App\Repositories\Backend\History;

use App\Exceptions\GeneralException;
use App\Models\History\History;
use App\Models\History\HistoryType;

/**
 * Class EloquentHistoryRepository.
 */
class EloquentHistoryRepository implements HistoryContract
{
    public $type;

    public $text;

    /**
     * @var null
     */
    public $entity_id = null;

    /**
     * @var null
     */
    public $icon = null;

    /**
     * @var null
     */
    public $class = null;

    /**
     * @var null
     */
    public $assets = null;

    /**
     * Pagination type
     * paginate: Prev/Next with page numbers
     * simplePaginate: Just Prev/Next arrows.
     *
     * @var string
     */
    private $paginationType = 'simplePaginate';

    /**
     * @throws GeneralException
     */
    public function withType($type): static
    {
        //Type can be id or name
        if (is_numeric($type)) {
            $this->type = HistoryType::findOrFail($type);
        } else {
            $this->type = HistoryType::where('name', $type)->first();
        }

        if ($this->type instanceof HistoryType) {
            return $this;
        }

        throw new GeneralException('An invalid history type was supplied: '.$type.'.');
    }

    /**
     * @throws GeneralException
     */
    public function withText($text): static
    {
        if (strlen($text)) {
            $this->text = $text;
        } else {
            throw new GeneralException('You must supply text for each history item.');
        }

        return $this;
    }

    public function withEntity($entity_id): static
    {
        $this->entity_id = $entity_id;

        return $this;
    }

    public function withIcon($icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function withClass($class): static
    {
        $this->class = $class;

        return $this;
    }

    public function withAssets($assets): static
    {
        $this->assets = is_array($assets) && count($assets) ? json_encode($assets) : null;

        return $this;
    }

    /**
     * @return mixed
     */
    public function log()
    {
        return History::create([
            'type_id' => $this->type->id,
            'user_id' => access()->id(),
            'entity_id' => $this->entity_id,
            'icon' => $this->icon,
            'class' => $this->class,
            'text' => $this->text,
            'assets' => $this->assets,
        ]);
    }

    /**
     * @return mixed
     */
    public function updateUserLinkAssets()
    {
        return History::where('type_id', $this->type->id)
            ->where('user_id', access()->id())
            ->where('entity_id', $this->entity_id)
            ->where('assets', 'LIKE', '%user_link%')
            ->update(['assets' => $this->assets]);
    }

    /**
     * @param  null  $limit
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function render($limit = null, $paginate = true, $pagination = 10)
    {
        $history = History::with('user')->latest();
        $history = $this->buildPagination($history, $limit, $paginate, $pagination);
        if (! $history->count()) {
            return trans('history.backend.none');
        }

        return $this->buildList($history, $paginate);
    }

    /**
     * @param  null  $limit
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function renderType($type, $limit = null, $paginate = true, $pagination = 10)
    {
        $history = History::with('user');
        $history = $this->checkType($history, $type);
        $history = $this->buildPagination($history, $limit, $paginate, $pagination);
        if (! $history->count()) {
            return trans('history.backend.none_for_type');
        }

        return $this->buildList($history, $paginate);
    }

    /**
     * @param  null  $limit
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function renderEntity($type, $entity_id, $limit = null, $paginate = true, $pagination = 10)
    {
        $history = History::with('user', 'type')->where('entity_id', $entity_id);
        $history = $this->checkType($history, $type);
        $history = $this->buildPagination($history, $limit, $paginate, $pagination);
        if (! $history->count()) {
            return trans('history.backend.none_for_entity', ['entity' => $type]);
        }

        return $this->buildList($history, $paginate);
    }

    /**
     * @return mixed|string
     */
    public function renderDescription($text, $assets = false)
    {
        $assets = json_decode($assets, true);
        $count = 1;

        if ($assets != null) {
            $asset_count = count($assets) + 1;
            if (count($assets)) {
                foreach ($assets as $name => $values) {
                    $key = explode('_', $name)[0];
                    $type = explode('_', $name)[1];

                    switch ($type) {
                        case 'link':
                            if (is_array($values)) {
                                switch (count($values)) {
                                    case 1:
                                        $text = str_replace('{'.$key.'}', route($values[0], $values[0]), $text);
                                        break;

                                    case 2:
                                        $text = str_replace('{'.$key.'}', route($values[0], $values[1]), $text);
                                        break;

                                    case 3:
                                        // dd($values[2]);
                                        $text = str_replace('{'.$key.'}', route($values[0], $values[2]), $text);
                                        break;

                                    case 4:
                                        $text = str_replace('{'.$key.'}', route($values[0], $values[2], $values[3]), $text);
                                        break;
                                }
                            } else {
                                //Normal url
                                $text = str_replace('{'.$key.'}', link_to($values, $values), $text);
                            }

                            break;

                        case 'string':
                            $text = str_replace('{'.$key.'}', $values, $text);
                            break;
                    }

                    $count++;
                }
            }

            if ($asset_count == $count) {
                //Evaluate all trans functions as PHP
                //We don't want to use eval() for security reasons so we're explicitly converting trans cases
                return preg_replace_callback('/trans\(\"([^"]+)\"\)/', function ($matches) {
                    return trans($matches[1]);
                }, $text);
            }
        }

        return '';
    }

    public function buildList($history, $paginate = true): string
    {
        return view('backend.history.partials.list', ['history' => $history, 'paginate' => $paginate])
            ->render();
    }

    /**
     * @return mixed
     */
    public function buildPagination($query, $limit, $paginate, $pagination)
    {
        if ($paginate && is_numeric($pagination)) {
            return $query->{$this->paginationType}($pagination);
        } else {
            if ($limit && is_numeric($limit)) {
                $query->take($limit);
            }

            return $query->get();
        }
    }

    /**
     * @return mixed
     */
    private function checkType($query, $type)
    {
        if (is_numeric($type)) {
            return $query->where('type_id', $type)->latest();
        } else {
            $type = strtolower($type);

            return $query->whereHas('type', function ($query) use ($type) {
                $query->where('name', ucfirst($type));
            })->latest();
        }
    }
}
