<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function __construct()
    {
        // Require authentication as admin
        $this->middleware('auth:web');


        $this->middleware(function ($request, $next) {
            if (auth()->check() && auth()->user()->user_role === 'admin') {
                return $next($request);
            }
            // Redirect non-admin users to home page
            return redirect('/');
        });
    }

    public function index()
    {
        try {
            // Get list of all tables
            $tables = DB::select('SHOW TABLES');
            $tableNames = array_map('current', $tables);

            return view('dashboards.dashboardAttraction', compact('tableNames'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function searchTable(Request $request)
    {
        $tableName = $request->query('table_name');
        ;

        // Get all table names
        $tables = DB::select('SHOW TABLES');
        $tableNames = array_map('current', $tables);

        // Only allow whitelisted tables
        $allowedTables = ['tbl_attraction', 'tbl_user', 'tbl_region', 'tbl_comment', 'tbl_city', 'tbl_category', 'tbl_counter'];
        if (!in_array($tableName, $allowedTables)) {
            abort(403, 'Unauthorized table access.');
        }

        // Initialize variables
        $countRow = 0;
        $label = [];
        $dataViewCounter = [];

        /* Attraction + city + region + category + counter */
        if ($tableName === "tbl_attraction") {
            // Count rows
            $countRow = DB::table($tableName)->count();

            //Filtered Table & Columns
            $joinTables = ['tbl_attraction', 'tbl_city', 'tbl_region', 'tbl_category'];
            $joinColoumns = ['count by visit','like_count'];

            //Get All columns
            foreach ($joinTables as $joinCol) {
                //Filtered Columns
                $countColumn = Schema::getColumnListing($joinCol);
                $joinColoumns = array_merge($joinColoumns, $countColumn);
            }



            // Further filter out foreign key and date columns and information columns
            foreach ($joinColoumns as $col) {
                if (str_ends_with($col, '_id') || str_ends_with($col, '_desc') || str_ends_with($col, '_thumbnail') || $col === 'date_created' || $col === 'attr_name') {
                    continue; // Skip foreign key and date columns
                }
                $filteredColumns[] = $col;
            }

            //Initialize Data for chart
            $CounterVisits = DB::table($tableName)
                ->join('tbl_counter', 'tbl_attraction.attr_id', '=', 'tbl_counter.attr_id')
                ->selectRaw('attr_name as attraction, COUNT(*) as total')
                ->groupBy('attr_name')
                ->orderByDesc('total')
                ->get();

            $label = $CounterVisits->pluck('attraction');
            $dataViewCounter = $CounterVisits->pluck('total');

            // Overview Data
            // Get the first and last day of LAST month
            $lastMonthStart = Carbon::now()->subMonthNoOverflow()->startOfMonth();
            $lastMonthEnd = Carbon::now()->subMonthNoOverflow()->endOfMonth();

            // Get the first day of THIS month to today
            $thisMonthStart = Carbon::now()->startOfMonth();
            $today = Carbon::now();

            // Query counts
            $lastMonthRow = DB::table($tableName)
                ->whereBetween('date_created', [$lastMonthStart, $lastMonthEnd])
                ->count();

            $thisMonthRow = DB::table($tableName)
                ->whereBetween('date_created', [$thisMonthStart, $today])
                ->count();

            // Prevent division by zero
            $total = $thisMonthRow + $lastMonthRow;
            $percentRowDiff = $total > 0
                ? (($thisMonthRow - $lastMonthRow) / $total) * 100.0
                : 0;

            $countCity = DB::table('tbl_city')->count();
            $countRegion = DB::table('tbl_region')->count();
            $countCategory = DB::table('tbl_category')->count();


            return view('dashboards.dashboardAttraction', compact(
                'countRow',
                'countCity',
                'countRegion',
                'countCategory',
                'filteredColumns',
                'label',
                'dataViewCounter',
                'percentRowDiff'
            ));
        }
        /* User */ 
        elseif ($tableName === "tbl_user") {
            // Count rows
            $countRow = DB::table($tableName)->count();

            //Filtered Table & Columns
            $joinTables = ['tbl_comment', 'tbl_attraction', 'tbl_user'];
            $joinColoumns = [];

            //Get All columns
            foreach ($joinTables as $joinCol) {
                //Filtered Columns
                $countColumn = Schema::getColumnListing($joinCol);
                $joinColoumns = array_merge($joinColoumns, $countColumn);
                
            }


            // Further filter out foreign key and date columns and information columns
            foreach ($joinColoumns as $col) {
                if (str_ends_with($col, '_id') || str_ends_with($col, '_desc') || str_ends_with($col, '_thumbnail') || $col === 'date_created' || $col === 'user_name' || $col === 'user_phone' || $col === 'user_password' || $col === 'user_email' || $col === 'like_count') {
                    continue; // Skip foreign key and date columns
                }
                $filteredColumns[] = $col;
            }


            //Initialize Data for chart
            $CounterVisits = DB::table($tableName)
                ->join('tbl_comment', 'tbl_user.user_id', '=', 'tbl_comment.user_id')
                ->join('tbl_attraction', 'tbl_comment.attr_id', '=', 'tbl_attraction.attr_id')
                ->selectRaw('user_name as user, COUNT(*) as total')
                ->groupBy('user_name')
                ->orderByDesc('total')
                ->get();

            $label = $CounterVisits->pluck('user');
            $dataViewCounter = $CounterVisits->pluck('total');

            // Overview Data
            // Get the first and last day of LAST month
            $lastMonthStart = Carbon::now()->subMonthNoOverflow()->startOfMonth();
            $lastMonthEnd = Carbon::now()->subMonthNoOverflow()->endOfMonth();

            // Get the first day of THIS month to today
            $thisMonthStart = Carbon::now()->startOfMonth();
            $today = Carbon::now();

            // Query counts
            $lastMonthRow = DB::table($tableName)
                ->whereBetween('date_created', [$lastMonthStart, $lastMonthEnd])
                ->count();

            $thisMonthRow = DB::table($tableName)
                ->whereBetween('date_created', [$thisMonthStart, $today])
                ->count();

            // Prevent division by zero
            $total = $thisMonthRow + $lastMonthRow;
            $percentRowDiff = $total > 0
                ? (($thisMonthRow - $lastMonthRow) / $total) * 100.0
                : 0;

            //Count Comments
            $countComment = DB::table('tbl_comment')->count();

                        // Query counts
            $lastMonthRowComment = DB::table('tbl_comment')
                ->whereBetween('date_created', [$lastMonthStart, $lastMonthEnd])
                ->count();

            $thisMonthRowComment = DB::table('tbl_comment')
                ->whereBetween('date_created', [$thisMonthStart, $today])
                ->count();

            // Prevent division by zero
            $total = $thisMonthRowComment + $lastMonthRowComment;
            $percentRowCommentDiff = $total > 0
                ? (($thisMonthRowComment - $lastMonthRowComment) / $total) * 100.0
                : 0;


            return view('dashboards.dashboardUser', compact(
                'countRow',
                'filteredColumns',
                'label',
                'dataViewCounter',
                'percentRowDiff',
                'countComment',
                'percentRowCommentDiff'
            ));
        }
    }

    public function chartData(Request $request)
    {
        // Get the selected column from the request
        $column = $request->get('column');

        // Handle "Count By Visit" separately
        if (strcasecmp($column, 'Count By Visit') === 0) {
            $column = 'c_date';
            $results = DB::table('tbl_attraction')
                ->join('tbl_counter', 'tbl_attraction.attr_id', '=', 'tbl_counter.attr_id')
                ->select('attr_name as attraction', DB::raw('count(*) as CountAttr'))
                ->groupBy('attr_name')
                ->orderByDesc('CountAttr')
                ->get();

            return response()->json([
                'labels' => $results->pluck('attraction')->toArray(),
                'data' => $results->pluck('CountAttr')->toArray(),
            ]);
            // Handle "like_count" separately
        } elseif (strcasecmp($column, 'like_count') === 0) {
$results = DB::table('attraction_user_likes')
    ->join('tbl_attraction', 'attraction_user_likes.attraction_id', '=', 'tbl_attraction.attr_id')
    ->select('tbl_attraction.attr_name as attraction', DB::raw('COUNT(*) as SumAttr'))
    ->groupBy('tbl_attraction.attr_name')  // ✅ Only group by the real column
    ->orderByDesc('SumAttr')
    ->get();






            return response()->json([
                'labels' => $results->pluck('attraction')->toArray(),
                'data' => $results->pluck('SumAttr')->toArray(),
            ]);
        }
        // Handle "attraction_name" separately
        elseif (strcasecmp($column, 'attr_name') === 0) {
            $results = DB::table('tbl_user')
                ->join('tbl_comment', 'tbl_user.user_id', '=', 'tbl_comment.user_id')
                ->join('tbl_attraction', 'tbl_comment.attr_id', '=', 'tbl_attraction.attr_id')
                ->select(
                    'tbl_attraction.attr_name as attraction_name',
                    DB::raw("COUNT(*) as Attraction")
                )
                ->groupBy('tbl_attraction.attr_name')
                ->orderByDesc('Attraction')
                ->get();

            return response()->json([
                'labels' => $results->pluck('attraction_name')->toArray(),
                'data' => $results->pluck('Attraction')->toArray(),
            ]);
        }
        // Handle "comment_like" separately
        elseif (strcasecmp($column, 'comment_like') === 0) {
            $results = DB::table('tbl_user')
                ->join('tbl_comment', 'tbl_user.user_id', '=', 'tbl_comment.user_id')
                ->select(
                    'tbl_user.user_name as user_name',
                    DB::raw('MAX(tbl_comment.like_count) as max_likes')
                )
                ->groupBy('tbl_user.user_name')
                ->orderByDesc('max_likes')
                ->get();

            return response()->json([
                'labels' => $results->pluck('user_name')->toArray(),
                'data' => $results->pluck('max_likes')->toArray(),
            ]);
        }
        // Handle "user_role" separately
        elseif (strcasecmp($column, 'user_role') === 0) {
            $results = DB::table('tbl_user')
                ->select(
                    'user_role',
                    DB::raw('COUNT(*) as total')
                )
                ->groupBy('user_role')
                ->get();

            return response()->json([
                'labels' => $results->pluck('user_role')->toArray(),
                'data' => $results->pluck('total')->toArray(),
            ]);
        } else {
            /* Attraction + city + region + category + counter */
            $results = DB::table('tbl_attraction')
                ->join('tbl_city', 'tbl_attraction.city_id', '=', 'tbl_city.city_id')
                ->join('tbl_region', 'tbl_city.region_id', '=', 'tbl_region.region_id')
                ->join('tbl_category', 'tbl_attraction.category_id', '=', 'tbl_category.category_id')
                ->select(DB::raw('count(attr_name) as attraction'), DB::raw("$column as CountAttr"))
                ->groupBy($column)
                ->orderByDesc('CountAttr')
                ->get();

            return response()->json([
                'labels' => $results->pluck('CountAttr')->toArray(),
                'data' => $results->pluck('attraction')->toArray(),
            ]);
        }
    }
}//class