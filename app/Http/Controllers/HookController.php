<?php
/**
 * Created by PhpStorm.
 * User: cjy
 * Date: 2019-01-11
 * Time: 11:34
 */

namespace App\Http\Controllers;


use App\Jobs\ComposeJob;
use App\Jobs\GitJob;
use App\Jobs\LaravelJob;
use Illuminate\Http\Request;

class HookController extends Controller
{

    public function hook(Request $request)
    {
        $this->validate($request, [
            'dir' => 'required'
        ]);

        dispatch(new ComposeJob($request->get('dir'), $request->get('service'), $request->get('mail'), $request->get('url')));

        return 'OK';
    }

    public function git(Request $request)
    {
        $this->validate($request, [
            'dir' => 'required'
        ]);


        dispatch(new GitJob($request->get('dir')));

        return 'OK';
    }

    public function laravel(Request $request)
    {
        $this->validate($request, [
            'dir'     => 'required',
            'service' => 'required',
        ]);

        dispatch(new LaravelJob($request->get('dir'), $request->get('service'), $request->get('mail'), $request->get('extras', [])));

        return 'OK';
    }

}
