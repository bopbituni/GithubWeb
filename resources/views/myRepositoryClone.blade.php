@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" style="margin-top: 20px">
                <div class="card">
                    <div class="card-header row">
                        <div style="
                font-weight: bold;
                margin-top: 8px;
                font-size: 20px" class="col-md-1"><a href="{{route('home')}}">Back</a>
                        </div>
                        <div style="
                font-weight: bold;
                font-size: 30px;
                text-align: center" class="col-md-11">Danh sách Repositories Clone
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-8 offset-md-2">
                            @foreach($repos as $index => $repo)
                                <div class='card' style='margin-bottom: 15px'>
                                    <div class='row' style='padding: 10px'>
                                        <div class='col-md-3'>Number :</div>
                                        <div class='col-md-9'>{{$index + 1}}</div>
                                        <div class='col-md-3'>Name :</div>
                                        <div class='col-md-9'>{{$repo->name}}</div>
                                        <div class='col-md-3'>Full name :</div>
                                        <div class='col-md-9'>{{$repo->full_name}}</div>
                                        <div class='col-md-3'>Link Url :</div>
                                        <div class='col-md-9'>{{$repo->repo_id}}</div>
                                        <div class='col-md-3'>Fork :</div>
                                        <div class='col-md-9'>{{$repo->fork}}</div>
                                        <div class='col-md-3'>Create At :</div>
                                        <div class='col-md-9'>{{$repo->date}}</div>
                                        <div class="col-md-6 offset-md-3" style="font-size: 18px">

                                            @if(!in_array($repo->repo_id, $forkRepoArray))
                                                <button name="{{$repo->full_name}}" id="{{$repo->id}}"
                                                        class="fork btn btn-link">
                                                    Create
                                                    Fork
                                                    Version
                                                </button>
                                            @else
                                                @foreach($forkRepos as $forkRepo)
                                                    <a style="font-size: 14px"
                                                       href="{{$forkRepo['clone_url']}}">{{$forkRepo['clone_url']}}</a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-danger" style="width: 5rem; height: 5rem;" role="status">
                    <div>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        showModalLoading();
        setTimeout(function () {
            $('#edit-modal').modal("hide")
        }, 1000)
        $('.fork').on('click', function (e) {
            showModalLoading();
            var full_name = $(this).attr('name');
            var id = $(this).attr('id');
            const username = "bopbituni";
            const password = "bopbi865616";
            const headers = {
                "Authorization": `Basic ${btoa(`${username}:${password}`)}`
            }
            $.ajax({
                url: "https://api.github.com/repos/" + full_name + "/forks",
                type: "POST",
                headers: headers,
                success: function (res) {
                    console.log(res)
                    try {
                        if (res.parent.id) {
                            $.ajax({
                                url: "{{route('fork-repo-save')}}",
                                type: "POST",
                                data: {
                                    'url': res.forks_url,
                                    'repo_id': res.parent.id,
                                    'clone_url': res.clone_url,
                                    "_token": "{{ csrf_token() }}",
                                },
                            });
                            alert('Fork thành công');
                        }
                    } catch (e) {
                        alert('Không thể tự fork repo của mình');
                    }

                    $('#' + id).remove();
                    setTimeout(function () {
                        $('#edit-modal').modal("hide")
                    }, 500)
                },
                error: function (e) {
                    setTimeout(function () {
                        $('#edit-modal').modal("hide")
                    }, 1000)
                }
            })
        })
    })

    function showModalLoading() {
        var options = {
            'backdrop': 'static',
            keyboard: false
        };
        $('#edit-modal').modal(options)
    }
</script>
