<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Helpers;
use App\Jobs\ForkRepoJob;
use App\Mail\SendEmailMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ForkRepo extends Controller
{
    public function saveRepoFork (Request $request) {
        try {
            $forkRepoUrl = new \App\ForkRepo();
            $forkRepoUrl->url = $request->url;
            $forkRepoUrl->repo_id = $request->repo_id;
            $forkRepoUrl->clone_url = $request->clone_url;
            $forkRepoUrl->save();
            ForkRepoJob::dispatch($forkRepoUrl);

            return Helpers::formatResponseSuccess($forkRepoUrl);
        } catch (\Exception $exception) {
            return Helpers::formatResponseSystemBusy($exception);
        }
    }
}
