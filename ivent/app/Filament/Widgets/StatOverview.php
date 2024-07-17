<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use App\Models\Participation;
use App\Models\Review;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatOverview extends BaseWidget
{

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Events', Event::count()),
            Stat::make('Number of Participants', Participation::count()),

            Stat::make('Review ', Review::count()),

            Stat::make('Attendance', '53')
                ->description('30 increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')->chart([7, 2, 10, 3, 15, 4, 17])

                ->color('success'),

        ];
    }


    // protected function getWidgets(): array
    // {
    //     return [
    //         EventsOverview::class,
    //         ParticipantsOverview::class,
    //         ReviewsOverview::class,
    //     ];
    // }
}
