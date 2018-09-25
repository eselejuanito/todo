<?php
 namespace App\Traits;

 use Illuminate\Pagination\LengthAwarePaginator;
 use Illuminate\Support\Collection;
 use Illuminate\Database\Eloquent\Model;
 use Illuminate\Support\Facades\Validator;

 /**
  * Trait ApiResponser
  * @package App\Traits
  */
trait ApiResponser
{
     /**
      * Succes Response Json
      * @param $data
      * @param $code
      * @return \Illuminate\Http\JsonResponse
      */
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

     /**
      * Error Response Json
      * @param $message
      * @param $code
      * @return \Illuminate\Http\JsonResponse
      */
    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code'=> $code], $code);
    }

     /**
      * Get all elements collection
      * @param Collection $collection
      * @param int $code
      * @return \Illuminate\Http\JsonResponse
      */
    protected function getAll(Collection $collection, $code = 200)
    {
        if ($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }

        $transformer = $collection->first()->transformer;

        $collection = $this->sortData($collection, $transformer);

        $collection = $this->filterData($collection, $transformer);

        $collection = $this->paginate($collection);

        $collection = $this->transformData($collection, $transformer);

        return $this->successResponse($collection, $code);
    }

     /**
      * Get specified data model
      * @param \Illuminate\Database\Eloquent\Model
      * @param int $code
      * @return \Illuminate\Http\JsonResponse
      */
    protected function getOne(Model $instance, $code = 200)
    {
        $transformer = $instance->transformer;

        $instance = $this->transformData($instance, $transformer);

        return $this->successResponse($instance, $code);
    }

    /**
     * Show Success message
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function showMessage($message, $code = 200)
    {
        return $this->successResponse(['data' =>$message], $code);
    }

    /**
     * Sort Collection Data
     * @param Collection $collection
     * @param $transformer
     * @return Collection
     */
    protected function sortData(Collection $collection, $transformer)
    {
        // TODO: Sort by more than one parameter
        if (request()->has('sort')) {
            $descending = false;
            $descending_attribute = explode("-", request()->sort);

            // For descending sort
            if (is_array($descending_attribute) && array_key_exists(1, $descending_attribute)) {
                $attr = $descending_attribute[1];
                $descending = true;
            } else {
                $attr = $descending_attribute[0];
            }

            if ($attribute = $transformer::originalAttribute($attr)) {
                $collection = $collection->sortBy($attribute, $options = SORT_REGULAR, $descending);
            }
        }

        return $collection;
    }

    /**
     * Filter Collection Data
     * @param Collection $collection
     * @param $transformer
     * @return Collection
     */
    protected function filterData(Collection $collection, $transformer)
    {
        // You could use more than one filter, but works like OR, not works like AND
        foreach (request()->query() as $query => $value) {
            // Try to find the pattern 'filter[attribute]=1,2,3'
            if ($query === 'filter') {
                foreach ($value as $attr => $val) {
                    $attribute = $transformer::originalAttribute($attr);
                    if (isset($attribute, $val)) {
                        // To filter a search by more than one parameter separated by comma.
                        if (strpos($val, ',') !== false) {
                            $values = array_map('trim', explode(',', $val));
                            $collection = $collection->whereIn($attribute, $values);
                        } else {
                            $collection = $collection->where($attribute, $val);
                        }
                    }

                }
            }
        }

        return $collection;
    }

    /**
     * Paginate Collection Data
     * @param Collection $collection
     * @return Collection
     */
    protected function paginate(Collection $collection)
    {
        $rules = [
            'per_page' => 'integer|min:2|max:50',
        ];

        Validator::validate(request()->all(), $rules);

        $page = LengthAwarePaginator::resolveCurrentPage();

        $perPage = 15;

        if (request()->has('per_page')) {
            $perPage = (int) request()->per_page;
        }

        $results = $collection->slice(($page - 1 ) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
           'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        $paginated->appends(request()->all());

        return $paginated;
    }

    /**
     * Transform the  data
     * @param $data
     * @param $transformer
     * @return array
     */
    protected function transformData($data, $transformer)
    {
        $transformation = fractal($data, new $transformer);

        if (request()->has('include')) {
            $transformation->parseIncludes(request()->include);
        }

        return $transformation->toArray();
    }
}