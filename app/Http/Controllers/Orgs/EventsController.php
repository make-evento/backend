<?php

namespace App\Http\Controllers\Orgs;

use App\Http\Controllers\Controller;
use App\Http\Resources\Orgs\EventsResource;
use App\Models\Organization;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index(Organization $org, Request $request)
    {
        // Converte o mês textual para o formato numérico e verifica se existe o valor correspondente
        $month = $this->months($request->month);
        $year = $request->year;

        if (!$month || !$year) {
            return response()->json(['error' => 'Mês ou ano inválido.'], 400);
        }

        // Filtra os contratos pelo ano e mês usando whereYear e whereMonth
        $events = $org->contracts()
                      ->whereYear('event_date', $year)
                      ->whereMonth('event_date', $month)
                      ->get();

        return EventsResource::collection($events);
    }

    private function months($month)
    {
        $months = [
            'jan' => '01',
            'feb' => '02',
            'mar' => '03',
            'apr' => '04',
            'may' => '05',
            'jun' => '06',
            'jul' => '07',
            'aug' => '08',
            'sep' => '09',
            'oct' => '10',
            'nov' => '11',
            'dec' => '12',
        ];

        return $months[$month] ?? null;
    }
}
