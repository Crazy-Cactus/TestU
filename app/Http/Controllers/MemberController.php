<?php
/**
 * Created by PhpStorm.
 * User: Genesis
 * Date: 20/04/2018
 * Time: 14:45
 */

namespace App\Http\Controllers;


use App\Services\MemberService;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    private $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }


    public function index(Request $request)
    {
        $members = $this->memberService->lists();

        return view('members.index', [
            'members' => $members,
            'alert' => $request->session()->get('alert')
        ]);
    }

    public function create(Request $request)
    {
        $values = $request->only([
            Member::EMAIL
        ]);

        if($this->validForm($values, [
            Member::EMAIL => 'required'
        ])) {

            return redirect()->action('MemberController@index')
                ->with('alert', [
                    'message' => 'required_fields',
                    'type' => 'warning'
                ])->setStatusCode(500);
        }

        try {
            $this->memberService->create($values[Member::EMAIL]);
        } catch (EmailAlreadyExistException $e) {
            return redirect()->action('MemberController@index')
                ->with('alert', [
                    'message' => 'success_message',
                    'type' => 'success'
                ]);
        }

        return redirect()->action('MemberController@index')
            ->with('alert', [
                'message' => 'success_message',
                'type' => 'success'
            ]);
    }

    private function validForm(array $values, array $rules): bool
    {
        $validator = Validator::make($values, $rules);

        if($validator->fails()) {
            return true;
        }

        return false;
    }
}