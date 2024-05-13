<?php

namespace App\Admin\Repositories;

use App\Models\Contract\ContractRebate as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class ContractRebate extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
