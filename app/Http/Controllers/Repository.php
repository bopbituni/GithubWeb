<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Helpers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Repository extends Controller
{
    public function setRepositoryToDB(Request $request)
    {
        try {
            $repository = new \App\Repository();
            $repository->name = $request->name;
            $repository->full_name = $request->fullName;
            $repository->link_url = $request->link_url;
            $repository->fork = $request->fork;
            $repository->repo_id = $request->repo_id;
            $repository->date = $request->date;
            $repository->save();
            Session::flash('success', 'Thêm thành công Repository');

            return redirect()->to(route('home'));

        } catch (\Exception $exception) {
            return Helpers::formatResponseSystemBusy($exception);
        }
    }

    public function displayRepository()
    {
        $repos = \App\Repository::all();
        $forkRepoArray = [];
        $forkRepos = \App\ForkRepo::all()->toArray();
        foreach ($forkRepos as $forkRepo) {
            array_push($forkRepoArray, $forkRepo['repo_id']);
        }
        return view('myRepositoryClone', compact('repos','forkRepoArray', 'forkRepos'));
    }

    public function getRepository()
    {
        try {
            $repos = \App\Repository::all();
            return Helpers::formatResponseSuccess($repos);
        } catch (\Exception $exception) {
            return Helpers::formatResponseSystemBusy($exception);
        }
    }
}
