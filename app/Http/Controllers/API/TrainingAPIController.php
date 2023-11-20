<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TrainingAPICollection;
use App\Http\Resources\TrainingAPIResource;
use App\Models\Training;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;

class TrainingAPIController extends Controller
{
    public function getTrainingList(Request $request)
    {
        $status = $request->get('status', '');
        $search_input = $request->get('search_input', '');

        $trainingQuery = Training::query();

        if (!empty($request->get('user_id'))) {
            $vendor_info = DB::table('vendor_details')->find($request->get('user_id'));
            $current_state          = !empty($vendor_info->current_state) ? explode(',', $vendor_info->current_state) : [];
            $current_district       = !empty($vendor_info->current_district) ? explode(',', $vendor_info->current_district) : [];
            $municipality_panchayat_current   = !empty($vendor_info->municipality_panchayat_current) ? explode(',', $vendor_info->municipality_panchayat_current) : [];

            if (!empty($current_state)) {
                $trainingQuery->where(function ($query) use ($current_state) {
                    $query->where(function ($query) use ($current_state) {
                        foreach ($current_state as $state) {
                            $query->orWhereRaw("FIND_IN_SET(?, state_id)", [$state]);
                        }
                    })->orWhereNull('state_id');
                });
            }
            if (!empty($current_district)) {
                $trainingQuery->where(function ($query) use ($current_district) {
                    $query->where(function ($query) use ($current_district) {
                        foreach ($current_district as $district) {
                            $query->orWhereRaw("FIND_IN_SET(?, district_id)", [$district]);
                        }
                    })->orWhereNull('district_id');
                });
            }
            if (!empty($municipality_panchayat_current)) {
                $trainingQuery->where(function ($query) use ($municipality_panchayat_current) {
                    $query->where(function ($query) use ($municipality_panchayat_current) {
                        foreach ($municipality_panchayat_current as $municipality) {
                            $query->orWhereRaw("FIND_IN_SET(?, municipality_id)", [$municipality]);
                        }
                    })->orWhereNull('municipality_id');
                });
            }
        }
        if (!empty($status)) {
            $status = explode(',', $request->get('status'));
            $trainingQuery->whereIn('status', $status);
        }

        if (!empty($search_input)) {
            $trainingQuery->where(function ($query) use ($search_input) {
                $query->where('name', 'LIKE', '%' . $search_input . '%');
            });
        }

        $trainingQuery->whereNotNull('training_end_at');

        $trainingQuery->orderByDesc('id');

        $training = $trainingQuery->paginate();

        $meta = [
            'first_page' => $training->url(1),
            'last_page' => $training->url($training->lastPage()),
            'prev_page_url' => $training->previousPageUrl(),
            'per_page' => $training->perPage(),
            'total_items' => $training->total(),
            'total_pages' => $training->lastPage()
        ];
        return response()->json(['status_code' => 200, 'success' => true, "message" => "Training history List Loaded successfully", 'meta' => $meta, 'data' => new TrainingAPICollection($training)]);
    }
    public function getGlobalTrainingList(Request $request)
    {
        $status = $request->get('status', '');
        $search_input = $request->get('search_input', '');

        $trainingQuery = Training::query();

        if (!empty($request->get('user_id'))) {
            $vendor_info = Admin::find($request->get('user_id'));
            $role = $vendor_info->roles->first();
            $roleName = $role->name ?? '';
            if ($roleName != 'Admin') {
                $current_state          = !empty($vendor_info->current_state) ? explode(',', $vendor_info->current_state) : [];
                $current_district       = !empty($vendor_info->current_district) ? explode(',', $vendor_info->current_district) : [];
                $municipality_panchayat_current   = !empty($vendor_info->municipality_panchayat_current) ? explode(',', $vendor_info->municipality_panchayat_current) : [];

                if (!empty($current_state)) {
                    $trainingQuery->where(function ($query) use ($current_state) {
                        $query->where(function ($query) use ($current_state) {
                            foreach ($current_state as $state) {
                                $query->orWhereRaw("FIND_IN_SET(?, state_id)", [$state]);
                            }
                        })->orWhereNull('state_id');
                    });
                }
                if (!empty($current_district)) {
                    $trainingQuery->where(function ($query) use ($current_district) {
                        $query->where(function ($query) use ($current_district) {
                            foreach ($current_district as $district) {
                                $query->orWhereRaw("FIND_IN_SET(?, district_id)", [$district]);
                            }
                        })->orWhereNull('district_id');
                    });
                }
                if (!empty($municipality_panchayat_current)) {
                    $trainingQuery->where(function ($query) use ($municipality_panchayat_current) {
                        $query->where(function ($query) use ($municipality_panchayat_current) {
                            foreach ($municipality_panchayat_current as $municipality) {
                                $query->orWhereRaw("FIND_IN_SET(?, municipality_id)", [$municipality]);
                            }
                        })->orWhereNull('municipality_id');
                    });
                }
            }
        }

        if (!empty($status)) {
            $status = explode(',', $request->get('status'));
            $trainingQuery->whereIn('status', $status);
        }

        if (!empty($search_input)) {
            $trainingQuery->where(function ($query) use ($search_input) {
                $query->where('name', 'LIKE', '%' . $search_input . '%');
            });
        }

        $trainingQuery->whereNotNull('training_end_at');

        $trainingQuery->orderByDesc('id');

        $training = $trainingQuery->paginate();

        $meta = [
            'first_page' => $training->url(1),
            'last_page' => $training->url($training->lastPage()),
            'prev_page_url' => $training->previousPageUrl(),
            'per_page' => $training->perPage(),
            'total_items' => $training->total(),
            'total_pages' => $training->lastPage()
        ];
        return response()->json(['status_code' => 200, 'success' => true, "message" => "Training history List Loaded successfully", 'meta' => $meta, 'data' => new TrainingAPICollection($training)]);
    }

    public function getTrainingDetail(Training $training)
    {
        return response()->json(['status_code' => 200, 'success' => true, "message" => "Training Detail Loaded successfully", 'data' => new TrainingAPIResource($training)]);
    }

    public function liveTrainingList(Request $request)
    {
        Training::whereDate('training_end_at', '<', date('Y-m-d'))->update(['status' => 'In Active']);
        $status = $request->get('status', '');
        $search_input = $request->get('search_input', '');

        $trainingQuery = Training::query();

        $today = date('Y-m-d');

        $trainingQuery->where(function ($query) use ($today) {
            $query->whereDate('training_start_at', '<=', $today)
                ->orWhereNull('training_start_at');
        });

        $trainingQuery->whereDate('training_end_at', '>=', $today);

        if (!empty($request->get('user_id'))) {
            $vendor_info = DB::table('vendor_details')->find($request->get('user_id'));
            $current_state          = !empty($vendor_info->current_state) ? explode(',', $vendor_info->current_state) : [];
            $current_district       = !empty($vendor_info->current_district) ? explode(',', $vendor_info->current_district) : [];
            $municipality_panchayat_current   = !empty($vendor_info->municipality_panchayat_current) ? explode(',', $vendor_info->municipality_panchayat_current) : [];
            if (!empty($current_state)) {
                $trainingQuery->where(function ($query) use ($current_state) {
                    $query->where(function ($query) use ($current_state) {
                        foreach ($current_state as $state) {
                            $query->orWhereRaw("FIND_IN_SET(?, state_id)", [$state]);
                        }
                    })->orWhereNull('state_id');
                });
            }
            if (!empty($current_district)) {
                $trainingQuery->where(function ($query) use ($current_district) {
                    $query->where(function ($query) use ($current_district) {
                        foreach ($current_district as $district) {
                            $query->orWhereRaw("FIND_IN_SET(?, district_id)", [$district]);
                        }
                    })->orWhereNull('district_id');
                });
            }
            if (!empty($municipality_panchayat_current)) {
                $trainingQuery->where(function ($query) use ($municipality_panchayat_current) {
                    $query->where(function ($query) use ($municipality_panchayat_current) {
                        foreach ($municipality_panchayat_current as $municipality) {
                            $query->orWhereRaw("FIND_IN_SET(?, municipality_id)", [$municipality]);
                        }
                    })->orWhereNull('municipality_id');
                });
            }
        }

        if (!empty($status)) {
            $status = explode(',', $request->get('status'));
            $trainingQuery->whereIn('status', $status);
        }

        if (!empty($search_input)) {
            $trainingQuery->where(function ($query) use ($search_input) {
                $query->where('name', 'LIKE', '%' . $search_input . '%');
            });
        }

        $trainingQuery->whereNotNull('training_end_at');

        $trainingQuery->orderByDesc('id');

        $training = $trainingQuery->paginate();
        $meta = [
            'first_page' => $training->url(1),
            'last_page' => $training->url($training->lastPage()),
            'prev_page_url' => $training->previousPageUrl(),
            'per_page' => $training->perPage(),
            'total_items' => $training->total(),
            'total_pages' => $training->lastPage()
        ];

        return response()->json(['status_code' => 200, 'success' => true, "message" => "Live Training List Loaded successfully", 'meta' => $meta, 'data' => new TrainingAPICollection($training)]);
    }

    public function storeTraining(Request $request)
    {
        $request->validate([
            'training_end_at' => ['required', 'date', 'after_or_equal:' . Carbon::today()->format('Y-m-d')],
        ]);

        $input = $request->all();
        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image');
            $coverImageName = time() . $coverImage->getClientOriginalName();
            $coverImage->move('uploads', $coverImageName);
            $input['cover_image'] = $coverImageName;
        }

        $training = Training::create($input);
        $this->addDemoGraphyNotification('training', $training->id);
        return response()->json(['success' => true, 'training_id' => $training->id, 'message' => 'Training created successfully']);
    }

    public function updateTraining(Request $request, Training $training)
    {

        $input = $request->all();
        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image');
            $coverImageName = time() . $coverImage->getClientOriginalName();
            $coverImage->move('uploads', $coverImageName);
            $input['cover_image'] = $coverImageName;
        }

        $training->fill($input);
        $training->save();
        return response()->json(['success' => true, 'training_id' => $training->id, 'message' => 'Training updated successfully']);
    }

    public function deleteTraining(Training $training)
    {
        $training->delete();
        return response()->json(['success' => true, 'message' => 'Training deleted successfully']);
    }
}
