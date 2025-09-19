<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Get list of all tables
            $tables = DB::select('SHOW TABLES');
            $tableNames = array_map('current', $tables);

            return view('dashboards.fetchTable', compact('tableNames'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function searchTable(Request $request)
    {
        $tableName = $request->select_table;

        // Get all table names
        $tables = DB::select('SHOW TABLES');
        $tableNames = array_map('current', $tables);

        // Only allow whitelisted tables
        $allowedTables = ['tbl_attraction'];
        if (!in_array($tableName, $allowedTables)) {
            abort(403, 'Unauthorized table access.');
        }

        $countRow = 0;
        $countColumn = [];
        $label = [];
        $dataViewCounter = [];

        if ($tableName === "tbl_attraction") {
            $countRow = DB::table($tableName)->count();
            $countColumn = Schema::getColumnListing($tableName);

            // Filter unwanted columns
            $filteredColumns = array_filter($countColumn, function ($col) {
                return !in_array($col, ['attr_id', 'attr_name', 'attr_thumbnail', 'attr_desc']);
            });

            // Chart data (like count & visits)
            $AttractionVisits = DB::table('tbl_attraction as a')
                ->select(
                    'a.attr_name as attraction',
                    DB::raw('COUNT(*) as total'),
                    'a.like_count as like_count_sum'
                )
                ->groupBy('a.attr_name', 'a.like_count')
                ->orderByDesc('total')
                ->get();

            $CounterVisits = DB::table($tableName)
                ->join('tbl_counter', 'tbl_attraction.attr_id', '=', 'tbl_counter.attr_id')
                ->selectRaw('attr_name as attraction, COUNT(*) as total')
                ->groupBy('attr_name')
                ->orderByDesc('total')
                ->get();

            $label = $AttractionVisits->pluck('attraction');
            $dataViewCounter = $CounterVisits->pluck('total');
        } else {
            $filteredColumns = [];
        }

        // Count users and views
        $countUser = DB::table('tbl_user')->count();
        $countView = DB::table('tbl_counter')->count();

        return view('dashboards.index', compact(
            'countView',
            'countUser',
            'countRow',
            'countColumn',
            'tableNames',
            'label',
            'dataViewCounter',
            'filteredColumns'
        ));
    }

    public function chartData(Request $request)
    {
        $column = $request->get('column');

        $results = DB::table('tbl_attraction')
            ->select('attr_name as attraction', $column)
            ->orderByDesc($column)
            ->get();

        return response()->json([
            'labels' => $results->pluck('attraction')->toArray(),
            'data' => $results->pluck($column)->toArray(),
        ]);
    }
}