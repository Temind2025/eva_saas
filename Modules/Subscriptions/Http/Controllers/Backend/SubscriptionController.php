<?php

namespace Modules\Subscriptions\Http\Controllers\Backend;

use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Subscriptions\Models\Plan;
use Modules\Subscriptions\Models\Subscription;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public $module_title;
    public $module_name;
    public $module_icon;

    public function __construct()
    {
        // Page Title
        $this->module_title = __('messages.subscriptions');

        // module name
        $this->module_name = 'subscriptions';

        // module icon
        $this->module_icon = 'fa-solid fa-clipboard-list';

        view()->share([
            'module_title' => $this->module_title,
            'module_icon' => $this->module_icon,
            'module_name' => $this->module_name,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {   $module_title = __('messages.subscriptions');
        $module_action = __('messages.active') . ' ' . __('messages.subscriptions');
        $plans = Plan::all();
        return view('subscriptions::backend.subscriptions.index', compact('module_action','plans','module_title'));
    }

    public function expired()
    {
        $module_title = __('messages.subscriptions');

        $module_action = __('promotion.lbl_expired') . ' ' . __('messages.subscriptions');
        $plans = Plan::all();
        $subscription_type = 'expired';
        return view('subscriptions::backend.subscriptions.index', compact('module_action','plans','subscription_type','module_title'));
    }

    public function pending()
    {
        $module_title = __('messages.subscriptions');
        $module_action = __('order_report.pending') . ' ' . __('messages.subscriptions');
        $plans = Plan::all();
        $approve_payment_count = Payment::where('status','Approved')->count();

        return view('payments.index', compact('module_action','plans','approve_payment_count','module_title'));
    }
    public function index_data(Datatables $datatable, Request $request)
    {
        $subscriptionType = $request->input('subscription_type');
        $query = auth()->user()->hasRole('super admin')
            ? Subscription::with(['user' => function ($q) {
                $q->withTrashed();
            }, 'subscription_transaction'])
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(plan_details, '$.name')) != 'Free'") // Exclude Free plans
            : Subscription::with(['user' => function ($q) {
                $q->withTrashed();
            }, 'subscription_transaction'])
            ->where('subscriptions.user_id', auth()->id())
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(plan_details, '$.name')) != 'Free'");

        if ($subscriptionType === 'expired') {
            $query->whereIn('subscriptions.status', ['Inactive', 'cancel']);
        } elseif ($subscriptionType == 'expired') {
            $query->whereDate('subscriptions.end_date', '<', Carbon::today())->where('status', 'inactive');
        } elseif ($subscriptionType == 'active') {
            $query->whereDate('subscriptions.end_date', '>=', Carbon::today())->where('status', 'active');
        } else {
            $query->whereDate('subscriptions.end_date', '>=', Carbon::today())->where('status', 'active');
        }


        if ($request->filled('search')) {
            $search = $request->input('search');

            // Ensure $search is a string
            if (is_array($search)) {
                $search = implode(' ', $search);
            }

            $query->where(function ($q) use ($search) {
                $q->where('subscriptions.id', 'LIKE', "%{$search}%")
                    ->orWhere('subscriptions.transaction_id', 'LIKE', "%{$search}%")
                    ->orWhere('subscriptions.currency', 'LIKE', "%{$search}%")
                    ->orWhere('subscriptions.status', 'LIKE', "%{$search}%")
                    ->orWhere('subscriptions.gateway_type', 'LIKE', "%{$search}%")
                    ->orWhere('subscriptions.payment_method', 'LIKE', "%{$search}%")
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(plan_details, '$.name')) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(plan_details, '$.type')) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(plan_details, '$.identifier')) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(plan_details, '$.price')) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(plan_details, '$.description')) LIKE ?", ["%{$search}%"])
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('first_name', 'LIKE', "%{$search}%")
                                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                                  ->orWhere('email', 'LIKE', "%{$search}%");
                    });
            });
        }


        if ($request->filled('plan_id')) {
            $query->where('plan_id', $request->plan_id);
        }

        if ($request->filled('date_range')) {
            $dates = explode(' to ', $request->date_range); // Ensure correct delimiter
            $startDate = Carbon::createFromFormat('Y-m-d', trim($dates[0]))->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', trim($dates[1]))->endOfDay();

            $query->whereBetween('start_date', [$startDate, $endDate]);
        }

        $query->orderBy('subscriptions.updated_at', 'desc');

        return $datatable->eloquent($query)
            ->editColumn('payment_method', function ($data) {
                return $data->payment_method == 1 ? 'Offline' : 'Online';
            })
            ->editColumn('plan_name', function ($data) {
                return json_decode($data->plan_details, true)['name'] ?? '-';
            })
            ->editColumn('plan_type', function ($data) {
                return json_decode($data->plan_details, true)['type'] ?? '-';
            })
            ->editColumn('amount', function ($data) {
                try {
                    return \Currency::format($data->total_amount ?? 0);
                } catch (\Exception $e) {
                    \Log::error('Error getting transaction amount: ' . $e->getMessage());
                    return \Currency::format(0);
                }
            })
            ->editColumn('created_at', function ($data) {
                return formatDateOrTime($data->created_at,'date');
            })
            ->editColumn('start_date', function ($data) {
                return formatDateOrTime($data->start_date,'date');
            })
            ->editColumn('end_date', function ($data) {
                return formatDateOrTime($data->end_date,'date');
            })
            ->editColumn('status', function ($data) {
                return $data->getStatusLabelAttribute();
            })
            ->editColumn('user.first_name', function ($data) {
                if ($data->user) {
                    return $data->user->deleted_at ? '<span>' .__('messages.deleted_user').'</span>' : $data->user->first_name;
                }
                return '<span class="text-danger">'.__('messages.deleted_user').'</span>';
            })
            ->editColumn('user.last_name', function ($data) {
                if ($data->user) {
                    return $data->user->deleted_at ? '<span>' .__('messages.deleted_user').'</span>' : $data->user->last_name;
                }
                return '<span class="text-danger">'.__('messages.deleted_user').'</span>';
            })
            ->editColumn('updated_at', function ($data) {

                return $data->updated_at;

            })
            ->editColumn('duration', function ($data) {
                $planDetails = json_decode($data->plan_details, true);
                
                $durationSuffix = match($planDetails['type'] ?? '') {
                    'Monthly' => 'Month',
                    'Yearly' => 'Year',
                    'Weekly' => 'Week',
                    default => 'Day'
                };
            
                return ($planDetails['duration'] ?? 0) . ' ' . $durationSuffix;
            })
            ->rawColumns(['action', 'status', 'user.first_name', 'user.last_name'])
            ->orderColumns(['id'], '-:column $1')
            ->toJson();
    }


    public function pending_subscription(Datatables $datatable, Request $request)
    {
        $query = Payment::query()->with(['user', 'plan', 'subscription'])->where('payments.status',0);


        if ($request->filled('search') && $request->filled('search.value') ) {
            $search = $request->input('search');

            // Ensure $search is a string
            if (is_array($search)) {
                $search = implode(' ', $search);
            }

            $query->where(function ($q) use ($search) {
                $q
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(plan_details, '$.name')) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(plan_details, '$.type')) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(plan_details, '$.identifier')) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(plan_details, '$.price')) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(plan_details, '$.description')) LIKE ?", ["%{$search}%"])
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('first_name', 'LIKE', "%{$search}%")
                                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                                  ->orWhere('email', 'LIKE', "%{$search}%");
                    });
            });
        }
    // Apply filters
    if ($request->filled('plan_id') && $request->plan_id !=null ) {
        $query->where('plan_id', $request->plan_id);
    }

    if ($request->filled('date_range') && $request->date_range !=null ) {
        $dates = explode(' to ', $request->date_range); // Ensure correct delimiter
        $startDate = Carbon::createFromFormat('Y-m-d', trim($dates[0]))->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', trim($dates[1]))->endOfDay();

        $query->whereBetween('payment_date', [$startDate, $endDate]);
    }

        return $datatable->eloquent($query)
            ->editColumn('amount', function ($data) {
                return \Currency::format($data->amount);
            })
            ->addColumn('check', function ($data) {
                return '<input type="checkbox" class="form-check-input select-table-row " name="select_payment" value="'.$data->id.'" data-id="'.$data->id.'">';
            })
            ->addColumn('image', function ($data) {
                // Check if the image exists and return an img tag or a placeholder
                return $data->image ? asset($data->image) :  default_feature_image();
            })
            ->editColumn('payment_date', function ($data) {
                return formatDateOrTime($data->payment_date,'date');
            })
            ->editColumn('payment_method', function ($data) {
                return $data->payment_method == 1 ? 'Online' : 'Offline';
            })
            ->editColumn('plan_name', function ($data) {
                return json_decode($data->plan_details, true)['name'] ?? '-';
            })
            ->orderColumn('plan_name', function ($query, $order) {
                $query->join('plan', 'plan.id', '=', 'payments.plan_id')
                      ->orderBy('plan.name', $order);
            })
            ->editColumn('status', function ($data) {
                return $data->status == 0 ? 'Pending' : ($data->status == 1 ? 'Approved' : 'Rejected');
            })
            ->editColumn('duration', function ($data) {
                $planDetails = json_decode($data->plan_details, true);
                
                $durationSuffix = match($planDetails['type'] ?? '') {
                    'Monthly' => 'Month',
                    'Yearly' => 'Year',
                    'Weekly' => 'Week',
                    default => 'Day'
                };
            
                return ($planDetails['duration'] ?? 0) . ' ' . $durationSuffix;
            })
            ->orderColumn('duration', function ($query, $order) {
                $query->orderByRaw("CAST(JSON_UNQUOTE(JSON_EXTRACT(plan_details, '$.duration')) AS UNSIGNED) {$order}");
            })
            ->rawColumns(['action', 'status','check'])
            ->orderColumns(['id'], '-:column $1')
            ->toJson();
    }


}
