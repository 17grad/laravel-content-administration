<?php

namespace Fjord\Crud\Repositories\Relations;

use Fjord\Crud\Fields\Relations\BelongsTo;
use Fjord\Crud\Repositories\BaseFieldRepository;
use Fjord\Crud\Requests\CrudUpdateRequest;

class BelongsToRepository extends BaseFieldRepository
{
    use Concerns\ManagesRelated;

    /**
     * BelongsTo field instance.
     *
     * @var BelongsTo
     */
    protected $field;

    /**
     * Create new BelongsToRepository instance.
     */
    public function __construct($config, $controller, $form, BelongsTo $field)
    {
        parent::__construct($config, $controller, $form, $field);
    }

    /**
     * Create new belongsTo relation.
     *
     * @param CrudUpdateRequest $request
     * @param mixed             $model
     *
     * @return void
     */
    public function create(CrudUpdateRequest $request, $model)
    {
        $related = $this->getRelated($request, $model);

        $belongsTo = $this->field->getRelationQuery($model);

        $model->{$belongsTo->getForeignKeyName()} = $related->{$belongsTo->getOwnerKeyName()};
        $model->save();
    }

    /**
     * Destroy belongsTo relation.
     *
     * @param CrudUpdateRequest $request
     * @param mixed             $model
     *
     * @return void
     */
    public function destroy(CrudUpdateRequest $request, $model)
    {
        $belongsTo = $this->field->getRelationQuery($model);

        $model->update([
            $belongsTo->getForeignKeyName() => null,
        ]);
    }
}
