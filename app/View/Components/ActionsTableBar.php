<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ActionsTableBar extends Component
{
    public $primaryAction;
    public $clearAction;
    public $searchModel;
    public $searchPlaceholder;
    public $statusFilter;
    public $registerPeriod;
    /**
     * Create a new component instance.
     */
    public function __construct($primaryAction = null, $clearAction = null, $searchModel = null, $searchPlaceholder = null, $statusFilter = null, $registerPeriod = null)
    {
        $this->primaryAction = $primaryAction;
        $this->clearAction = $clearAction;
        $this->searchModel = $searchModel;
        $this->searchPlaceholder = $searchPlaceholder;
        $this->statusFilter = $statusFilter;
        $this->registerPeriod = $registerPeriod;
    }

    // Função para concatenar o metodo e o parâmetro
    public function getPrimaryActionClick()
    {
        if (!isset($this->primaryAction['method']))
        {
            return '';
        }

        if (isset($this->primaryAction['param']))
        {
            // Escapa as aspas para evitar quebra
            $param = addslashes($this->primaryAction['param']);
            return "{$this->primaryAction['method']}('{$param}')";
        }

        return $this->primaryAction['method'];
    }
    // Função para concatenar o metodo e o parâmetro
    public function getClearActionClick()
    {
        if (!isset($this->clearAction['method']))
        {
            return '';
        }

        if (isset($this->clearAction['param']))
        {
            $param =addslashes($this->clearAction['param']);
            return "{$this->clearAction['method']}('{$param}')";
        }

        return $this->clearAction['method'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.actions-table-bar');
    }
}
