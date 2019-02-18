<?php
/**
 * Created by PhpStorm.
 * User: MD0155-DHARMVIJAY
 * Date: 7/17/2018
 * Time: 3:18 PM
 */

namespace App\Helpers;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;

class LimitOffsetCriteria implements CriteriaInterface
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply criteria in query repository.
     *
     * @param $model
     * @param \Prettus\Repository\Contracts\RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, \Prettus\Repository\Contracts\RepositoryInterface $repository)
    {
        $limit = $this->request->get('limit', null);
        $offset = $this->request->get('offset', null);

        if ($limit) {
            $model = $model->limit($limit);
        }

        if ($offset && $limit) {
            $model = $model->skip($offset);
        }

        return $model;
    }
}
