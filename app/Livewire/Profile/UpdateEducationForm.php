<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Carbon\Carbon;

class UpdateEducationForm extends Component
{
    public $user;
    public $professor;
    public $coordinator;
    public $education = [];

    public function mount()
    {
        $this->user = auth()->user();
        $this->professor = $this->user->professor;
        $this->coordinator = $this->user->coordinator;

        $this->education = $this->user
            ->education
            ->keyBy('level')
            ->map(fn ($item) => [
                'course' => $item->course,
            ])
            ->toArray();
    }

    public function updateEducation()
    {
        $currentEducation = $this->user->education
            ->map(fn ($item) => [
                'level' => $item->level,
                'course' => $item->course,
                'institution' => $item->institution,
            ])
            ->sortBy('level')
            ->values()
            ->toArray();

        $newEducation = collect($this->education)
            ->map(fn ($item, $level) => [
                'level' => $level,
                'course' => $item['course'] ?? null,
                'institution' => $item['institution'] ?? null,
            ])
            ->filter(fn ($item) => !empty($item['course']))
            ->sortBy('level')
            ->values()
            ->toArray();

        $lastUpdate = $this->user->education()->max('updated_at');
        $lastUpdate = $lastUpdate ? Carbon::parse($lastUpdate) : null;

        if (json_encode($currentEducation) != json_encode($newEducation)) {
            if ($lastUpdate && $lastUpdate->gt(now()->subHours(2))) {
                $this->dispatch('error');
                return;
            }
            $this->user->education()->delete();
            $this->user->education()->createMany($newEducation);

            $this->user->touch();
        }

        $this->dispatch('saved');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('profile.update-education-form');
    }
}
