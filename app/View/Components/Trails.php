<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Str;

class Trails extends Component
{
    public $trails = [];
    /**
     * Create a new component instance.
     */
    public function __construct(public $title = '')
    {
        if(request()->is('/'))
        {
            return $this->trails = [['link' => "/", 'name' => __('locale.Home')]];
        }
        $path_arr = explode('/',request()->path());
        $name = Str::ucfirst(Str::plural($path_arr[0]));
        $link = $path_arr[0];
        $this->trails = [
            ['link' => "/", 'name' => 'Home'],
            ['link' => $link, 'name' => $name],
        ];
        $this->$title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.trails');
    }
}
