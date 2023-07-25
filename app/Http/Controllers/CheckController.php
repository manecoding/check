<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\check;
use App\Http\Requests\serchRequest;
use App\Http\Requests\updateRequest;
use App\Http\Requests\registerRequest;

class CheckController extends Controller
{

    public function register_list(registerRequest $req){
        $data =new check;
        $data->name = $req->name;
        $data->contact= $req->contact;
        $data->company_name = $req->company_name;
        $data->profession = $req->profession;
        $data->email = $req->email;
        $data->invited_by = $req->invited_by;
        $data->check = 0;
        $data->pay_by = "";
        $result = $data->save();
        $get_data = $data->refresh();
        if($result){
            return response()->json([
                'success' => true,
                'data'=> $get_data
            ],200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Register error'
            ],400);
        }
    }

    public function check_list($pg = null)
    {
        $offset = 0;
        $limit  = 12;
        if ($pg > 0) {
            $offset = ($pg - 1) * $limit;
        }
        $pg ? $data = check::offset($offset)->limit($limit)->orderBy('name', 'asc')->where('check', 0)->get() :
            $data = check::orderBy('name', 'asc')->where('check', 0)->get();
        $total_pg = count(check::where('check', 0)->get());
        $result_pg = count($data);
        $num_pg = $total_pg / $limit;
        if (fmod($num_pg, 1) !== 0.0) {
            $num_pg = intval($total_pg / $limit) + 1;
        } else {
            $num_pg = $total_pg / $limit;
        }
        if (count($data) == 0) {
            $total_pg = 0;
            $sum_pg = 0;
        }
        if (($total_pg - $offset) < $limit || empty($pg)) {
            $sum_pg = $total_pg;
        } else {
            $sum_pg = $total_pg - ($total_pg - $offset) + $limit;
        }

        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data,
                'result_page' => $result_pg,
                'sum_page' => $sum_pg,
                'limit_page' => $num_pg,
                'total_page' => $total_pg

            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'List Not fount '
            ], 404);
        }
    }

    public function search_check_list(serchRequest $req, $pg = null)
    {
        // return 'search';
        $name = $req->name;
        $offset = 0;
        $limit = 12;
        $part = preg_split('/\s+/', $name);
        $data = check::query();
        $lenght = count($part);

        for ($i = 0; $i < $lenght; $i++) {
            $data->orwhere('name', 'like', "%{$part[$i]}%")
                ->where('check', 0)
                ->orwhere('contact', 'like', "%{$part[$i]}%")
                ->where('check', 0)
                ->orwhere('invited_by', 'like', "%{$part[$i]}%")
                ->where('check', 0)
                ->orwhere('email', 'like', "%{$part[$i]}%")
                ->where('check', 0)
                ->orwhere('profession', 'like', "%{$part[$i]}%")
                ->where('check', 0)
                ->orwhere('company_name', 'like', "%{$part[$i]}%");
        }

        // for ($i = 0; $i < $lenght; $i++) {
        // $data
        // ->where('check', 0)
        // ->where('name', 'like', "%{$part[$i]}%")

        // ->orwhere('invited_by', 'like', "%{$part[$i]}%");


        // ->where('email', 'like', "%{$part[$i]}%");
        // ->orwhere('profession', 'like', "%{$part[$i]}%")->orwhere('company_name', 'like', "%{$part[$i]}%");
        // }

        if ($pg > 0) {
            $offset = ($pg - 1) * $limit;
        }
        $pg ? $get_data = $data->offset($offset)->limit($limit)->orderBy('name', 'asc')->where('check', 0)->get() :
            $get_data = $data->orderBy('name', 'asc')->where('check', 0)->get();
        $total_pg = count($get_data);
        $result_pg = count($get_data);
        $num_pg = $total_pg / $limit;
        if (fmod($num_pg, 1) !== 0.0) {
            $num_pg = intval($total_pg / $limit) + 1;
        } else {
            $num_pg = $total_pg / $limit;
        }
        if (count($get_data) == 0) {
            $total_pg = 0;
            $sum_pg = 0;
            // abort(403, 'Search result not found');
            return response()->json([
                'success' => false,
                'message' => 'List not found',
                'result_page' => $result_pg,
                'sum_page' => $sum_pg,
                'limit_page' => $num_pg,
                'total_page' => $total_pg
            ], 404);
        }
        if (($total_pg - $offset) < $limit || empty($pg)) {
            $sum_pg = $total_pg;
        } else {
            $sum_pg = $total_pg - ($total_pg - $offset) + $limit;
        }
        if ($get_data) {
            return response()->json([
                'success' => true,
                'data' => $get_data,
                'result_page' => $result_pg,
                'sum_page' => $sum_pg,
                'limit_page' => $num_pg,
                'total_page' => $total_pg
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'List not found'
            ], 404);
        }
    }

    public function update_check_list(updateRequest $req, $pg = null)
    {
        $id = $req->id;
        $remark = $req->remark;
        $pay_by = $req->pay_by;
        $person = check::query();
        // $name = $req->name;
        //find
        $person_check = check::find($id);
        if ($person_check) {
            $person->where('id', $id)->update(['check' => 1, 'pay_by' => $pay_by, 'remark' => $remark]);
            $data = $person->first();
            return response()->json([
                'success' => true,
                'message' => 'You has been cheked.',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'List Not found'
            ], 404);
        }
    }

    public function detail_check_list($id)
    {
        $data = check::find($id);


        if ($data) {
            return response()->json([
                'success' => true,
                'message' => 'detail List',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "can't find List id",
            ], 404);
        }
    }
    //admin 
    public function checked_list($pg = null)
    {
        $offset = 0;
        $limit  = 12;
        if ($pg > 0) {
            $offset = ($pg - 1) * $limit;
        }
        $pg ? $data = check::offset($offset)->limit($limit)->orderBy('name', 'asc')->where('check', 1)->get() :
            $data = check::orderBy('name', 'asc')->where('check', 1)->get();
        $total_pg = count(check::where('check', 1)->get());
        $result_pg = count($data);
        $num_pg = $total_pg / $limit;
        if (fmod($num_pg, 1) !== 0.0) {
            $num_pg = intval($total_pg / $limit) + 1;
        } else {
            $num_pg = $total_pg / $limit;
        }
        if (count($data) == 0) {
            $total_pg = 0;
            $sum_pg = 0;
        }
        if (($total_pg - $offset) < $limit || empty($pg)) {
            $sum_pg = $total_pg;
        } else {
            $sum_pg = $total_pg - ($total_pg - $offset) + $limit;
        }

        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data,
                'result_page' => $result_pg,
                'sum_page' => $sum_pg,
                'limit_page' => $num_pg,
                'total_page' => $total_pg

            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'List Not fount '
            ], 404);
        }
    }

    public function search_checked_list(serchRequest $req, $pg = null)
    {
        // return 'search';
        $name = $req->name;
        $offset = 0;
        $limit = 12;
        $part = preg_split('/\s+/', $name);
        $data = check::query();
        $lenght = count($part);

        for ($i = 0; $i < $lenght; $i++) {
            $data->orwhere('name', 'like', "%{$part[$i]}%")
                ->where('check', 1)
                ->orwhere('contact', 'like', "%{$part[$i]}%")
                ->where('check', 1)
                ->orwhere('invited_by', 'like', "%{$part[$i]}%")
                ->where('check', 1)
                ->orwhere('email', 'like', "%{$part[$i]}%")
                ->where('check', 1)
                ->orwhere('profession', 'like', "%{$part[$i]}%")
                ->where('check', 1)
                ->orwhere('company_name', 'like', "%{$part[$i]}%");
        }

        // for ($i = 0; $i < $lenght; $i++) {
        // $data
        // ->where('check', 0)
        // ->where('name', 'like', "%{$part[$i]}%")

        // ->orwhere('invited_by', 'like', "%{$part[$i]}%");


        // ->where('email', 'like', "%{$part[$i]}%");
        // ->orwhere('profession', 'like', "%{$part[$i]}%")->orwhere('company_name', 'like', "%{$part[$i]}%");
        // }

        if ($pg > 0) {
            $offset = ($pg - 1) * $limit;
        }
        $pg ? $get_data = $data->offset($offset)->limit($limit)->orderBy('name', 'asc')->where('check', 1)->get() :
            $get_data = $data->orderBy('name', 'asc')->where('check', 1)->get();
        $total_pg = count($get_data);
        $result_pg = count($get_data);
        $num_pg = $total_pg / $limit;
        if (fmod($num_pg, 1) !== 0.0) {
            $num_pg = intval($total_pg / $limit) + 1;
        } else {
            $num_pg = $total_pg / $limit;
        }
        if (count($get_data) == 0) {
            $total_pg = 0;
            $sum_pg = 0;
            // abort(403, 'Search result not found');
            return response()->json([
                'success' => false,
                'message' => 'List not found',
                'result_page' => $result_pg,
                'sum_page' => $sum_pg,
                'limit_page' => $num_pg,
                'total_page' => $total_pg
            ], 404);
        }
        if (($total_pg - $offset) < $limit || empty($pg)) {
            $sum_pg = $total_pg;
        } else {
            $sum_pg = $total_pg - ($total_pg - $offset) + $limit;
        }
        if ($get_data) {
            return response()->json([
                'success' => true,
                'data' => $get_data,
                'result_page' => $result_pg,
                'sum_page' => $sum_pg,
                'limit_page' => $num_pg,
                'total_page' => $total_pg
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'List not found'
            ], 404);
        }
    }

    public function update_checked_list(updateRequest $req, $pg = null)
    {
        $id = $req->id;
        $remark = $req->remark;
        $pay_by = $req->pay_by;
        $person = check::query();
        // $name = $req->name;
        //find
        $person_check = check::find($id);
        if ($person_check) {
            $person->where('id', $id)->update(['check' => 0, 'pay_by' => $pay_by, 'remark' => $remark]);
            $data = $person->first();
            return response()->json([
                'success' => true,
                'message' => 'You has been cheked.',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'List Not found'
            ], 404);
        }
    }

    public function detail_checked_list($id)
    {
        $data = check::find($id);


        if ($data) {
            return response()->json([
                'success' => true,
                'message' => 'detail List',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "can't find List id",
            ], 404);
        }
    }

    // public function pay_detail()
    // {
    //     $data = check::orderBy('name', 'asc')->where('check', 1)->get();
    //     $data_sum_by_bank = check::orderBy('name', 'asc')->where('check', 1)->where('pay_by', Bank)->get();
    //     $result_pg = count($data);
    //     $total_pay = $result_pg * 15;
    //     $num_pg = $total_pg / $limit;
    //     if ($data) {
    //         return response()->json([
    //             'success' => true,
    //             'data' => $data
    //         ], 200);
    //     } else {
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'List Not fount '
    //         ], 404);
    //     }
    // }
}
