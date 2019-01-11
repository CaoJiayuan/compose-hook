<?php
/**
 * Created by PhpStorm.
 * User: cjy
 * Date: 2019-01-11
 * Time: 11:34
 */

namespace App\Http\Controllers;


use App\Jobs\ComposeJob;
use Illuminate\Http\Request;

class HookController extends Controller
{

    public function hook(Request $request)
    {
        if ($request->get('token') != env('API_TOKEN')) {
            return abort(403);
        }

        $this->validate($request, [
            'dir' => 'required'
        ]);

        dispatch(new ComposeJob($request->get('dir'), $request->get('service')));

        return 'OK';
    }
}
