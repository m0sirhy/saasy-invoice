<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DashboardRepository;
use Auth;

class DashboardController extends Controller
{

    public function __construct(DashboardRepository $dashboardRepo)
    {
        $this->dashboardRepo = $dashboardRepo;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dashboardRepo = $this->dashboardRepo;
        $revenue = $dashboardRepo->getRevenue();
        $paymentsByMonth = $dashboardRepo->getMonthlyPayments();
        $clientData = $dashboardRepo->getClientData();
        $recents = $dashboardRepo->getRecentPayments();
        $overdueData = $dashboardRepo->getOverDueInvoices();
        $userActivities = $dashboardRepo->getUserActivity();
        return view('dashboard')
            ->with('revenue', $revenue)
            ->with('clients', $clientData->clients)
            ->with('newClients', $clientData->newClients)
            ->with('paymentMonths', $paymentsByMonth->months)
            ->with('paymentByMonth', $paymentsByMonth->payments)
            ->with('recents', $recents)
            ->with('overdues', $overdueData->overdues)
            ->with('overdueTotal', $overdueData->overdueTotal)
            ->with('userActivities', $userActivities);
    }
}
