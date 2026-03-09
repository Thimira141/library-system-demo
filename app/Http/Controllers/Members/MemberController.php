<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Members;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{
    /**
     * Summary of viewMemberDashboard
     * @return \Illuminate\Contracts\View\View
     * @author Thimira Dilshan <thimirad865@gmail.com>
     */
    public function viewMemberDashboard()
    {
        // return view (no filters at the moment)
        return view('members.main-list');
    }

    /**
     * Summary of MembersDashboardDataHandler_AJAX
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author Thimira Dilshan <thimirad865@gmail.com>
     */
    public function MembersDashboardDataHandler_AJAX(Request $request)
    {
        // prep query
        $query = Members::all();
        // apply filters(nothing at the moment)
        // return DataTables::of(query)->...
        return DataTables::of($query)->make(true);
    }

    /**
     * Summary of createMember
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author Thimira Dilshan <thimirad865@gmail.com>
     */
    public function createMember(Request $request)
    {
        // validate data
        $validate = $this->ValidateData($request);
        // handle validate error
        if ($validate->fails()) {
            return response()->json([
                'status' => 'validateFail',
                'message' => 'Data Validate Failed!',
                'errorBag' => $validate->errors()
            ], 422);
        }
        // store data via model
        $validated = $validate->validated();
        try {
            $member = Members::create([
                'member_name' => $validated['member_name'],
                'member_nic_type' => $validated['member_nic_type'],
                'member_nic_number' => $validated['member_nic_number'],
                'member_dob' => $validated['member_dob'],
                'member_added' => $validated['member_added'],
                'member_email' => $validated['member_email'],
                'member_tel' => $validated['member_tel'],
                'member_address' => $validated['member_address'],
                'member_remarks' => $validated['member_remarks']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Database error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
        // store file
        if (!empty($validated['member_cover_img'])) {
            try {
                $file = $validated['member_cover_img'];
                $extension = $file->getClientOriginalExtension();

                // build path using member_id
                $filepath = (string) 'members/' . $member->member_id . '.' . $extension;

                // store file in storage/app/public/members
                $file->storeAs('members', $member->member_id . '.' . $extension, 'public');

                // update member record with filepath
                $member->update([
                    'member_cover_img' => $filepath
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File upload failed.',
                    'error' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data Store Success!',
            'member' => $member->toArray(),
            'redirect' => route('members-view-member', (string) $member->member_id)
        ], 200);
    }

    /**
     * Summary of viewMember
     * @param string $member_id
     * @return \Illuminate\Contracts\View\View
     * @author Thimira Dilshan <thimirad865@gmail.com>
     */
    public function viewMember(string $member_id)
    {
        // load member from model
        $member = Members::where('member_id', $member_id)->firstOrFail();
        // return view
        return view('members.view-member', compact('member'));
    }

    /**
     * Summary of viewEditMember
     * @param string $member_id
     * @return \Illuminate\Contracts\View\View
     * @author Thimira Dilshan <thimirad865@gmail.com>
     */
    public function viewEditMember(string $member_id)
    {
        // load member from model
        $member = Members::where('member_id', $member_id)->firstOrFail();
        // return view
        return view('members.edit-member', compact('member'));
    }

    /**
     * Summary of saveEditMember
     * @param Request $request
     * @param string $member_id
     * @return \Illuminate\Http\JsonResponse
     * @author Thimira Dilshan <thimirad865@gmail.com>
     */
    public function saveEditMember(Request $request, string $member_id)
    {
        // get member from model
        $member = Members::where('member_id', $member_id)->firstOrFail();
        // validate data
        $validate = $this->ValidateData($request, $member->id);
        if ($validate->fails()) {
            return response()->json([
                'status' => 'validateFail',
                'message' => 'Data Validate Failed!',
                'errorBag' => $validate->errors()
            ], 422);
        }
        $validated = $validate->validated();
        // update member fields
        $member->member_name = $validated['member_name'];
        $member->member_nic_type = $validated['member_nic_type'];
        $member->member_nic_number = $validated['member_nic_number'];
        $member->member_dob = $validated['member_dob'];
        $member->member_added = $validated['member_added'];
        $member->member_email = $validated['member_email'];
        $member->member_tel = $validated['member_tel'];
        $member->member_address = $validated['member_address'];
        $member->member_remarks = $validated['member_remarks'] ?? null;
        // update file (if has)
        // Handle cover image replacement
        if (!empty($validated['member_cover_img'])) {
            try {
                if ($member->member_cover_img && Storage::disk('public')->exists($member->member_cover_img)) {
                    Storage::disk('public')->delete($member->member_cover_img);
                }

                $extension = $validated['member_cover_img']->getClientOriginalExtension();
                $path = $validated['member_cover_img']
                    ->storeAs('members', $member->member_id . '.' . $extension, 'public');

                $member->member_cover_img = $path;
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File upload failed.',
                    'error' => $e->getMessage()
                ], 500);
            }
        }
        // save updated fields
        $member->save();
        // return response
        return response()->json([
            'status' => 'success',
            'message' => 'Member updated successfully!',
        ], 200);
    }

    /**
     * Summary of deleteMember
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @author Thimira Dilshan <thimirad865@gmail.com>
     */
    public function deleteMember(Request $request)
    {
        // data validation
        $validate = Validator::make(
            $request->all(),
            ['member_id' => 'required|string|exists:members,member_id'],
            [],
            ['member_id' => 'MemberID']
        );
        if ($validate->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'validateFail',
                    'errorBag' => $validate->errors()->toArray(),
                    'message' => 'Data validation failed!',
                ], 401);
            }
            return back()->withErrors($validate->errors()->toArray());
        }
        $validated = $validate->validated();
        try {
            // TODO: make data mark as deleted instead of deleting it
            $member = Members::where('member_id', $validated['member_id'])->firstOrFail();

            // Delete file if exists
            if ($member->member_cover_img) {
                try {
                    if (Storage::disk('public')->exists($member->member_cover_img)) {
                        Storage::disk('public')->delete($member->member_cover_img);
                    }
                } catch (\Exception $e) {
                    // Log::error("Failed to delete cover image for member {$member->member_id}: " . $e->getMessage());
                    return response()->json([
                        'status' => 'error',
                        'message' => 'File delete failed.',
                        'error' => $e->getMessage()
                    ], 500);
                }
            }

            $member->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Member deleted successfully.'
            ]);
        } catch (\Exception $e) {
            // Log::error("Unexpected error deleting member: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Summary of ValidateData
     * @param Request $request
     * @param int|bool $id
     * @param array $rules
     * @param array $attributes
     * @return \Illuminate\Validation\Validator
     * @author Thimira Dilshan <thimirad865@gmail.com>
     */
    private function ValidateData(Request $request, int|bool $id = false, array $rules = [], array $attributes = [])
    {
        $rules = [
            'member_cover_img' => [
                'nullable',
                File::image()->max('2mb'),
            ],
            'member_name' => [
                'string',
                'required',
                'min:4',
                'max:200',
                $id !== false
                ? Rule::unique('members', 'member_name')->ignore($id, 'id') // update mode
                : Rule::unique('members', 'member_name'), // create mode
            ],
            'member_nic_type' => [
                'required',
                'in:NIC,Driving Permit,Post ID'
            ],
            'member_nic_number' => [
                'required',
                'string',
                'min:5',
                'max:200',
                $id !== false
                ? Rule::unique('members', 'member_nic_number')->ignore($id, 'id') // update mode
                : Rule::unique('members', 'member_nic_number'), // create mode
                // combination of nic_type + member_nic_number across the table unique
            ],
            'member_dob' => [
                'date',
                'required',
            ],
            'member_added' => [
                'date',
                'required',
            ],
            'member_email' => [
                'required',
                'email',
                $id !== false
                ? Rule::unique('members', 'member_email')->ignore($id, 'id') // update mode
                : Rule::unique('members', 'member_email'), // create mode
            ],
            'member_tel' => [
                'required',
                'min:10',
                'max:15',
                'string',
                'regex:/^\+[0-9]+$/',
                $id !== false
                ? Rule::unique('members', 'member_tel')->ignore($id, 'id') // update mode
                : Rule::unique('members', 'member_tel'), // create mode
            ],
            'member_address' => [
                'string',
                'required',
                'min:4',
                'max:200',
            ],
            'member_remarks' => [
                'string',
                'nullable',
                'max:200',
            ],
            ...$rules
        ];

        $attributes = [
            'member_cover_img' => 'Member Cover Image',
            'member_name' => 'Member Name',
            'member_nic_type' => 'Member NIC Type',
            'member_nic_number' => 'NIC Number',
            'member_dob' => 'Member Date of Birth',
            'member_added' => 'Member Added Date',
            'member_email' => 'Member Email',
            'member_tel' => 'Member Tel',
            'member_address' => 'Member Address',
            'member_remarks' => 'Member Remarks',
            ...$attributes
        ];

        return validator::make($request->all(), $rules, [], $attributes);
    }
}
