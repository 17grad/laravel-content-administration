<?php

namespace FjordTest\Fields;

use Fjord\Crud\BaseField;
use Fjord\Crud\Fields\Input;
use Fjord\Crud\Fields\Traits\FieldHasRules;
use Fjord\Crud\Fields\Traits\TranslatableField;
use FjordTest\Traits\InteractsWithFields;
use FjordTest\Traits\TestHelpers;
use PHPUnit\Framework\TestCase;

class FieldInputTest extends TestCase
{
    use InteractsWithFields, TestHelpers;

    public function setUp(): void
    {
        parent::setUp();

        $this->field = $this->getField(Input::class);
    }

    /** @test */
    public function it_can_have_rules()
    {
        $this->assertHasTrait(FieldHasRules::class, $this->field);
    }

    /** @test */
    public function it_can_be_translatable()
    {
        $this->assertHasTrait(TranslatableField::class, $this->field);
    }

    /** @test */
    public function it_is_base_field()
    {
        $this->assertInstanceOf(BaseField::class, $this->field);
    }
}
