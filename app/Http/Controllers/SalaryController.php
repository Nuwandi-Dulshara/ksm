<?php

namespace App\Http\Controllers;

use App\Models\ApprovedSalarySheet;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalaryController extends Controller
{
    public function monthlyList(Request $request)
    {
        $salaryMonth = $this->resolveSalaryMonth($request->query('month'));
        $sheetData = $this->buildSalarySheet($salaryMonth);
        $approvedSheet = ApprovedSalarySheet::query()
            ->whereDate('salary_month', $salaryMonth->toDateString())
            ->first();

        return view('salary.monthly_salary_list', [
            'salaryMonth' => $salaryMonth,
            'salaryMonthValue' => $salaryMonth->format('Y-m'),
            'salaryMonthLabel' => $salaryMonth->format('F Y'),
            'salaryRows' => $sheetData['salaryRows'],
            'totals' => $sheetData['totals'],
            'approvedSheet' => $approvedSheet,
        ]);
    }

    public function approveMonthly(Request $request)
    {
        $request->validate([
            'month' => ['required', 'date_format:Y-m'],
        ]);

        $salaryMonth = $this->resolveSalaryMonth($request->input('month'));
        $sheetData = $this->buildSalarySheet($salaryMonth);

        ApprovedSalarySheet::updateOrCreate(
            ['salary_month' => $salaryMonth->toDateString()],
            [
                'salary_rows' => $sheetData['salaryRows']->values()->all(),
                'basic_salary_total' => $sheetData['totals']['basic_salary'],
                'bonus_total' => $sheetData['totals']['bonus'],
                'deduction_total' => $sheetData['totals']['deduction'],
                'net_payable_total' => $sheetData['totals']['net_payable'],
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]
        );

        return redirect()
            ->route('approve.salary', ['month' => $salaryMonth->format('Y-m')])
            ->with('success', 'Salary sheet approved successfully.');
    }

    public function approvedList(Request $request)
    {
        $selectedMonth = trim((string) $request->query('month', ''));
        $latestApprovedSheet = ApprovedSalarySheet::query()->latest('salary_month')->first();

        $salaryMonth = $selectedMonth !== ''
            ? $this->resolveSalaryMonth($selectedMonth)
            : ($latestApprovedSheet?->salary_month?->copy()->startOfMonth() ?? now()->startOfMonth());

        $approvedSheet = ApprovedSalarySheet::query()
            ->with('approver')
            ->whereDate('salary_month', $salaryMonth->toDateString())
            ->first();

        $salaryRows = collect($approvedSheet?->salary_rows ?? []);
        $totals = [
            'basic_salary' => (float) ($approvedSheet?->basic_salary_total ?? 0),
            'bonus' => (float) ($approvedSheet?->bonus_total ?? 0),
            'deduction' => (float) ($approvedSheet?->deduction_total ?? 0),
            'net_payable' => (float) ($approvedSheet?->net_payable_total ?? 0),
        ];

        return view('salary.approved_salary_list', [
            'salaryMonth' => $salaryMonth,
            'salaryMonthValue' => $salaryMonth->format('Y-m'),
            'salaryMonthLabel' => $salaryMonth->format('F Y'),
            'salaryRows' => $salaryRows,
            'totals' => $totals,
            'approvedSheet' => $approvedSheet,
        ]);
    }

    private function resolveSalaryMonth(?string $selectedMonth): Carbon
    {
        $selectedMonth = trim((string) $selectedMonth);

        try {
            return $selectedMonth !== ''
                ? Carbon::createFromFormat('Y-m', $selectedMonth)->startOfMonth()
                : now()->startOfMonth();
        } catch (\Throwable $exception) {
            return now()->startOfMonth();
        }
    }

    private function buildSalarySheet(Carbon $salaryMonth): array
    {
        $employees = Employee::query()
            ->whereYear('join_date', '<=', $salaryMonth->year)
            ->where(function ($query) use ($salaryMonth) {
                $query->whereYear('join_date', '<', $salaryMonth->year)
                    ->orWhere(function ($monthQuery) use ($salaryMonth) {
                        $monthQuery->whereYear('join_date', $salaryMonth->year)
                            ->whereMonth('join_date', '<=', $salaryMonth->month);
                    });
            })
            ->orderBy('full_name')
            ->get();

        $salaryRows = $employees->map(function (Employee $employee) {
            $basicSalary = (float) $employee->base_monthly_salary;
            $bonus = 0.0;
            $deduction = 0.0;

            return [
                'employee_id' => $employee->id,
                'employee_name' => $employee->full_name,
                'position' => $employee->job_title ?: 'Staff',
                'basic_salary' => $basicSalary,
                'bonus' => $bonus,
                'deduction' => $deduction,
                'net_payable' => $basicSalary + $bonus - $deduction,
            ];
        });

        return [
            'salaryMonthValue' => $salaryMonth->format('Y-m'),
            'salaryRows' => $salaryRows,
            'totals' => [
                'basic_salary' => $salaryRows->sum('basic_salary'),
                'bonus' => $salaryRows->sum('bonus'),
                'deduction' => $salaryRows->sum('deduction'),
                'net_payable' => $salaryRows->sum('net_payable'),
            ],
        ];
    }
}
