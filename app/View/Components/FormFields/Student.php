<?php

namespace App\View\Components\FormFields;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Student extends Component
{
    public $typeModal;

    /**
     * Create a new component instance.
     */
    public function __construct($typeModal = null)
    {
        $this->typeModal = $typeModal;
    }

    public function getInputRaAttributesProperty (): array
    {
        if ($this->typeModal === 'create'){
            return [
                'wire:keydown' => "resetError('ra')",
                'onkeydown' => "return ['e','E','+','-'].indexOf(event.key) === -1",
            ];
        }
        if($this->typeModal === 'update'){
            return [
                'disabled' => true,
                'readonly' => true,
            ];
        }

        return [];
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-fields.student', [
            'inputRaAttributes' => $this->getInputRaAttributesProperty(),
        ]);
    }
}
